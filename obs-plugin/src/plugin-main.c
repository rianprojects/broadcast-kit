#include <obs-module.h>
#include "droidcam-source.h"

OBS_DECLARE_MODULE()
OBS_MODULE_USE_DEFAULT_LOCALE("droidcam-obs", "en-US")

bool obs_module_load(void) {
    obs_register_source(&droidcam_source_info);
    blog(LOG_INFO, "[droidcam-obs] plugin loaded, source registered");
    return true;
}

void obs_module_unload(void) {
    blog(LOG_INFO, "[droidcam-obs] plugin unloaded");
}
