#include "mjpeg-client.h"

#define WIN32_LEAN_AND_MEAN
#include <winsock2.h>
#include <ws2tcpip.h>
#include <windows.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define STB_IMAGE_IMPLEMENTATION
#define STBI_ONLY_JPEG
#include "vendor/stb_image.h"

#define RECV_CHUNK 65536
#define RECONNECT_DELAY_MS 1500

struct mjpeg_client {
    char host[256];
    int port;
    mjpeg_frame_cb cb;
    void *opaque;

    HANDLE thread;
    volatile LONG running;
    CRITICAL_SECTION target_lock;
};

/* Growable byte buffer for the raw socket stream. */
typedef struct {
    uint8_t *data;
    size_t len;
    size_t cap;
} bytebuf_t;

static void bb_reserve(bytebuf_t *b, size_t extra) {
    if (b->len + extra <= b->cap) return;
    size_t ncap = b->cap ? b->cap * 2 : 65536;
    while (ncap < b->len + extra) ncap *= 2;
    b->data = (uint8_t *)realloc(b->data, ncap);
    b->cap = ncap;
}

static void bb_append(bytebuf_t *b, const uint8_t *p, size_t n) {
    bb_reserve(b, n);
    memcpy(b->data + b->len, p, n);
    b->len += n;
}

static void bb_consume(bytebuf_t *b, size_t n) {
    if (n >= b->len) { b->len = 0; return; }
    memmove(b->data, b->data + n, b->len - n);
    b->len -= n;
}

/* Finds "\r\n\r\n" (end of a part's headers) inside the buffer; returns offset or -1. */
static long find_header_end(const uint8_t *data, size_t len) {
    for (size_t i = 0; i + 3 < len; i++) {
        if (data[i] == '\r' && data[i + 1] == '\n' && data[i + 2] == '\r' && data[i + 3] == '\n')
            return (long)i;
    }
    return -1;
}

static long find_content_length(const char *headers) {
    const char *p = strstr(headers, "Content-Length:");
    if (!p) p = strstr(headers, "content-length:");
    if (!p) return -1;
    p = strchr(p, ':');
    if (!p) return -1;
    return strtol(p + 1, NULL, 10);
}

static SOCKET connect_to(const char *host, int port) {
    struct addrinfo hints = {0}, *res = NULL;
    hints.ai_family = AF_INET;
    hints.ai_socktype = SOCK_STREAM;
    char portstr[16];
    snprintf(portstr, sizeof(portstr), "%d", port);
    if (getaddrinfo(host, portstr, &hints, &res) != 0) return INVALID_SOCKET;

    SOCKET s = socket(res->ai_family, res->ai_socktype, res->ai_protocol);
    if (s == INVALID_SOCKET) { freeaddrinfo(res); return INVALID_SOCKET; }

    DWORD timeout = 5000;
    setsockopt(s, SOL_SOCKET, SO_RCVTIMEO, (const char *)&timeout, sizeof(timeout));
    setsockopt(s, SOL_SOCKET, SO_SNDTIMEO, (const char *)&timeout, sizeof(timeout));

    if (connect(s, res->ai_addr, (int)res->ai_addrlen) != 0) {
        closesocket(s);
        freeaddrinfo(res);
        return INVALID_SOCKET;
    }
    freeaddrinfo(res);
    return s;
}

static void handle_jpeg(mjpeg_client_t *c, const uint8_t *jpeg, long jlen) {
    int w, h, comp;
    unsigned char *rgba = stbi_load_from_memory(jpeg, jlen, &w, &h, &comp, 4);
    if (!rgba) return;
    c->cb(c->opaque, rgba, w, h);
    stbi_image_free(rgba);
}

static DWORD WINAPI client_thread(LPVOID arg) {
    mjpeg_client_t *c = (mjpeg_client_t *)arg;
    bytebuf_t buf = {0};
    uint8_t recv_tmp[RECV_CHUNK];

    while (InterlockedCompareExchange(&c->running, 0, 0)) {
        char host[256];
        int port;
        EnterCriticalSection(&c->target_lock);
        strncpy(host, c->host, sizeof(host) - 1);
        host[sizeof(host) - 1] = 0;
        port = c->port;
        LeaveCriticalSection(&c->target_lock);

        SOCKET s = connect_to(host, port);
        if (s == INVALID_SOCKET) {
            Sleep(RECONNECT_DELAY_MS);
            continue;
        }

        char req[512];
        int reqlen = snprintf(req, sizeof(req),
            "GET /video HTTP/1.1\r\nHost: %s\r\nConnection: keep-alive\r\n\r\n", host);
        send(s, req, reqlen, 0);

        buf.len = 0;
        bool http_header_skipped = false;

        while (InterlockedCompareExchange(&c->running, 0, 0)) {
            int n = recv(s, (char *)recv_tmp, RECV_CHUNK, 0);
            if (n <= 0) break;
            bb_append(&buf, recv_tmp, (size_t)n);

            /* Skip the initial HTTP/1.1 200 OK response headers once. */
            if (!http_header_skipped) {
                long he = find_header_end(buf.data, buf.len);
                if (he < 0) continue;
                bb_consume(&buf, (size_t)he + 4);
                http_header_skipped = true;
            }

            /* Parse as many complete multipart parts as are buffered. */
            for (;;) {
                if (buf.len < 4) break;
                /* Skip boundary line(s) / CRLF before the part headers. */
                size_t skip = 0;
                while (skip < buf.len && (buf.data[skip] == '\r' || buf.data[skip] == '\n'))
                    skip++;
                if (skip > 0) bb_consume(&buf, skip);
                if (buf.len > 0 && buf.data[0] == '-') {
                    /* boundary marker line "--frame\r\n" */
                    long he = find_header_end(buf.data, buf.len);
                    if (he < 0) break;
                    /* nothing useful in the boundary-only line itself; fall through
                       to header parse below which expects Content-Type/Length. */
                }
                long he = find_header_end(buf.data, buf.len);
                if (he < 0) break;
                char headers[512];
                size_t hlen = he < (long)sizeof(headers) - 1 ? (size_t)he : sizeof(headers) - 1;
                memcpy(headers, buf.data, hlen);
                headers[hlen] = 0;
                long clen = find_content_length(headers);
                if (clen < 0) {
                    /* Malformed/boundary-only chunk; drop it and resync on next recv. */
                    bb_consume(&buf, (size_t)he + 4);
                    continue;
                }
                size_t total = (size_t)he + 4 + (size_t)clen;
                if (buf.len < total) break;
                handle_jpeg(c, buf.data + he + 4, clen);
                bb_consume(&buf, total);
            }
        }
        closesocket(s);
        Sleep(RECONNECT_DELAY_MS);
    }

    free(buf.data);
    return 0;
}

mjpeg_client_t *mjpeg_client_create(const char *host, int port, mjpeg_frame_cb cb, void *opaque) {
    WSADATA wsa;
    WSAStartup(MAKEWORD(2, 2), &wsa);

    mjpeg_client_t *c = (mjpeg_client_t *)calloc(1, sizeof(*c));
    strncpy(c->host, host ? host : "", sizeof(c->host) - 1);
    c->port = port;
    c->cb = cb;
    c->opaque = opaque;
    c->running = 1;
    InitializeCriticalSection(&c->target_lock);
    c->thread = CreateThread(NULL, 0, client_thread, c, 0, NULL);
    return c;
}

void mjpeg_client_set_target(mjpeg_client_t *c, const char *host, int port) {
    if (!c) return;
    EnterCriticalSection(&c->target_lock);
    strncpy(c->host, host ? host : "", sizeof(c->host) - 1);
    c->host[sizeof(c->host) - 1] = 0;
    c->port = port;
    LeaveCriticalSection(&c->target_lock);
}

void mjpeg_client_destroy(mjpeg_client_t *c) {
    if (!c) return;
    InterlockedExchange(&c->running, 0);
    if (c->thread) {
        WaitForSingleObject(c->thread, 3000);
        CloseHandle(c->thread);
    }
    DeleteCriticalSection(&c->target_lock);
    free(c);
}
