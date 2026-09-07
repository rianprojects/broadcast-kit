# Camera Plugin — DroidCam-style camera source for OBS

Turns your Android phone into a webcam source for OBS over WiFi or USB. No virtual
camera driver required — OBS reads the stream via a Browser/Media Source.

## How it works
1. Install the Android app, grant camera permission, tap **Start Camera Server**.
   It streams MJPEG at `http://<phone-ip>:8899/video`.
2. Run the Windows companion app:
   - **WiFi**: type the phone's IP (shown in the Android app), click Check connection.
   - **USB**: enable USB debugging on the phone, plug it in, click Connect via USB
     (uses bundled `adb forward` so the stream is reachable at `http://localhost:8899/video`).
3. Copy the shown URL. In OBS: **Sources → + → Browser Source** → paste URL → set
   Width/Height to match the camera resolution (default 1280x720).

## Build the Android APK
```
cd android
./gradlew assembleRelease
```
Output: `android/app/build/outputs/apk/release/app-release.apk` (debug-signed; install
via `adb install` or copy to phone and enable "install unknown apps").

Requires Android Studio / Android SDK (compileSdk 34) and a JDK 17.

## Build the Windows .exe
```
cd windows
npm install
```
Download Android platform-tools and place `adb.exe`, `AdbWinApi.dll`,
`AdbWinUsbApi.dll` into `windows/resources/adb/` (see README.txt there), then:
```
npm run dist
```
Output: `windows/dist/*.exe` (portable, no installer needed).

## Notes
- Video only (like a plain webcam), no audio.
- Both devices must be on the same WiFi network for WiFi mode.
- USB mode requires USB debugging enabled and ADB drivers installed on Windows.
- **Play Protect warning on install**: expected. The APK isn't from Play Store and isn't
  release-signed with a recognized developer cert, so Android always flags sideloaded
  APKs as "unrecognized" the first time — tap **Install anyway**. This is inherent to
  sideloading, not fixable in the app itself; it goes away only by publishing through
  Google Play (even an Internal Testing track).
