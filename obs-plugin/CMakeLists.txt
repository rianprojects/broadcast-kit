cmake_minimum_required(VERSION 3.20)
project(droidcam-plugin-obs VERSION 1.0.0)

# Point this at a checkout of https://github.com/obsproject/obs-studio
# (need libobs headers + libobs.lib to link against; matching your installed OBS version).
set(OBS_SOURCE_DIR "" CACHE PATH "Path to obs-studio source checkout")
# Point this at the folder containing obs.lib (built OBS, e.g. obs-studio/build/libobs/RelWithDebInfo)
set(OBS_LIB_DIR "" CACHE PATH "Path to folder containing obs.lib")
# Your installed OBS's plugin install dir, for the optional 'install' target.
set(OBS_PLUGIN_INSTALL_DIR "C:/Program Files/obs-studio" CACHE PATH "OBS install root")

if(NOT OBS_SOURCE_DIR)
    message(FATAL_ERROR "Set -DOBS_SOURCE_DIR=<path to obs-studio checkout>")
endif()

add_library(droidcam-obs MODULE
    src/plugin-main.c
    src/droidcam-source.c
    src/mjpeg-client.c
)

target_include_directories(droidcam-obs PRIVATE
    "${OBS_SOURCE_DIR}/libobs"
    src/vendor
)

target_link_directories(droidcam-obs PRIVATE "${OBS_LIB_DIR}")
target_link_libraries(droidcam-obs PRIVATE obs ws2_32)

set_target_properties(droidcam-obs PROPERTIES OUTPUT_NAME "droidcam-obs")

# Mirrors the real droidcam-obs layout: obs-plugins/64bit/<name>.dll + data/obs-plugins/<name>/
install(TARGETS droidcam-obs
    LIBRARY DESTINATION "${OBS_PLUGIN_INSTALL_DIR}/obs-plugins/64bit"
    RUNTIME DESTINATION "${OBS_PLUGIN_INSTALL_DIR}/obs-plugins/64bit"
)
