#include "droidcam-source.h"
#include "mjpeg-client.h"

#include <obs-module.h>
#include <util/platform.h>
#include <media-io/video-io.h>
#include <stdlib.h>
#include <string.h>

struct droidcam_source {
    obs_source_t *source;
    mjpeg_client_t *client;
    char host[256];
    long long port;
};

static const char *droidcam_get_name(void *unused) {
    UNUSED_PARAMETER(unused);
    return "Camera Plugin (Phone via WiFi/USB)";
}

static void on_frame(void *opaque, const uint8_t *rgba, int width, int height) {
    struct droidcam_source *s = (struct droidcam_source *)opaque;
    if (width <= 0 || height <= 0) return;

    struct obs_source_frame frame = {0};
    frame.data[0] = (uint8_t *)rgba;
    frame.linesize[0] = width * 4;
    frame.width = (uint32_t)width;
    frame.height = (uint32_t)height;
    frame.format = VIDEO_FORMAT_RGBA;
    frame.timestamp = os_gettime_ns();

    obs_source_output_video(s->source, &frame);
}

static void droidcam_apply_settings(struct droidcam_source *s, obs_data_t *settings) {
    const char *host = obs_data_get_string(settings, "host");
    long long port = obs_data_get_int(settings, "port");
    strncpy(s->host, host ? host : "", sizeof(s->host) - 1);
    s->host[sizeof(s->host) - 1] = 0;
    s->port = port;

    if (s->client) {
        mjpeg_client_set_target(s->client, s->host, (int)s->port);
    } else {
        s->client = mjpeg_client_create(s->host, (int)s->port, on_frame, s);
    }
}

static void *droidcam_create(obs_data_t *settings, obs_source_t *source) {
    struct droidcam_source *s = (struct droidcam_source *)bzalloc(sizeof(*s));
    s->source = source;
    droidcam_apply_settings(s, settings);
    return s;
}

static void droidcam_destroy(void *data) {
    struct droidcam_source *s = (struct droidcam_source *)data;
    if (s->client) mjpeg_client_destroy(s->client);
    bfree(s);
}

static void droidcam_update(void *data, obs_data_t *settings) {
    struct droidcam_source *s = (struct droidcam_source *)data;
    droidcam_apply_settings(s, settings);
}

static void droidcam_get_defaults(obs_data_t *settings) {
    obs_data_set_default_string(settings, "host", "192.168.1.1");
    obs_data_set_default_int(settings, "port", 8080);
}

static obs_properties_t *droidcam_get_properties(void *data) {
    UNUSED_PARAMETER(data);
    obs_properties_t *props = obs_properties_create();
    obs_properties_add_text(props, "host", "Phone IP (or 'localhost' for USB)", OBS_TEXT_DEFAULT);
    obs_properties_add_int(props, "port", "Port", 1, 65535, 1);
    return props;
}

struct obs_source_info droidcam_source_info = {
    .id = "droidcam_plugin_source",
    .type = OBS_SOURCE_TYPE_INPUT,
    .output_flags = OBS_SOURCE_ASYNC_VIDEO,
    .get_name = droidcam_get_name,
    .create = droidcam_create,
    .destroy = droidcam_destroy,
    .update = droidcam_update,
    .get_defaults = droidcam_get_defaults,
    .get_properties = droidcam_get_properties,
    .icon_type = OBS_ICON_TYPE_CAMERA,
};
