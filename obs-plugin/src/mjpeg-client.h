#pragma once
#include <stdint.h>
#include <stdbool.h>

/*
 * Background client that connects to <host>:<port>/video (the Android app's
 * MJPEG server), pulls frames, decodes each JPEG, and hands the caller the
 * latest decoded RGBA frame via a callback. One thread per instance.
 */

typedef struct mjpeg_client mjpeg_client_t;

typedef void (*mjpeg_frame_cb)(void *opaque, const uint8_t *rgba, int width, int height);

mjpeg_client_t *mjpeg_client_create(const char *host, int port, mjpeg_frame_cb cb, void *opaque);
void mjpeg_client_destroy(mjpeg_client_t *client);

/* Call when host/port changes; restarts the connection. */
void mjpeg_client_set_target(mjpeg_client_t *client, const char *host, int port);
