# Camera Plugin — native OBS plugin (droidcam-obs style)

Registers a native OBS source type ("Camera Plugin (Phone via WiFi/USB)") that
pulls the MJPEG stream from the Android app (`../android`) and feeds it into
OBS directly — no Browser Source needed, same integration style as DroidCam
(`C:\Program Files\obs-studio\data\obs-plugins\droidcam-obs`).

## How it works
- `src/mjpeg-client.c` — plain WinSock client thread: connects to
  `http://<host>:<port>/video`, parses the `multipart/x-mixed-replace` stream,
  decodes each JPEG with `stb_image` (vendored, public domain), and calls back
  with an RGBA frame.
- `src/droidcam-source.c` — OBS `obs_source_info` (`OBS_SOURCE_ASYNC_VIDEO`)
  that pushes each decoded frame via `obs_source_output_video`. Properties
  panel exposes Host/Port (type phone's WiFi IP, or `localhost` when using
  `adb forward` for USB — see `../windows` companion app).
- `src/plugin-main.c` — module entry point, registers the source.

## Build requirements (not yet installed on this machine)
1. **Visual Studio Build Tools** (C++ workload, MSVC) — OBS plugins must use
   the same compiler ABI as the OBS build.
2. **CMake** ≥ 3.20.
3. A checkout of **obs-studio** source matching your installed OBS version,
   built once so `obs.lib` exists (or grab prebuilt `libobs` dev files if
   available for your OBS version).

Install quickly via winget when ready:
```
winget install Kitware.CMake
winget install Microsoft.VisualStudio.2022.BuildTools --override "--add Microsoft.VisualStudio.Workload.VCTools --includeRecommended"
```

## Build
```
git clone --recursive https://github.com/obsproject/obs-studio
cd obs-studio && cmake -B build -DCMAKE_BUILD_TYPE=RelWithDebInfo && cmake --build build --config RelWithDebInfo

cd ../obs-plugin
cmake -B build ^
  -DOBS_SOURCE_DIR=<path-to-obs-studio> ^
  -DOBS_LIB_DIR=<path-to-obs-studio>/build/libobs/RelWithDebInfo
cmake --build build --config RelWithDebInfo
```

## Install
Copy the built `droidcam-obs.dll` into:
```
C:\Program Files\obs-studio\obs-plugins\64bit\
```
(or run `cmake --install build --config RelWithDebInfo` which does this,
given `OBS_PLUGIN_INSTALL_DIR` in `CMakeLists.txt`).

Restart OBS → Add Source → **Camera Plugin (Phone via WiFi/USB)** → enter the
phone's IP (from the Android app) or `localhost` for USB mode.
