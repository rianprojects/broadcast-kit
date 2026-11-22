# BroadcastKit — Android Camera & Control App

Companion Android app for OBS: streams the phone camera as a video source (MJPEG) to OBS/PC on the same network, plus extra controls such as tally light, timer, and soundboard.

## Features

- **Camera streaming** — stream the phone camera via an MJPEG server to OBS/browser on the local network.
- **Tally light** — live/preview status indicator from OBS.
- **Timer** — activity timer for production needs.
- **Soundboard** — quick sound effect player.
- **Stats** — connection/stream statistics.
- **OBS WebSocket integration** — two-way communication with OBS Studio.
- Foreground service keeps streaming running while the app is in the background.
- **Dock menu & consistent UI (v0.1)** — modern bottom navigation (vector icons, dark theme, no emoji), uniform toolbar across all screens (OBS Deck, More, Stats, Timer, Soundboard).

> Ready-to-use APK release: see [Releases](https://github.com/rianprojects/BroadcastKit/releases).

## Device Specifications

| | |
|---|---|
| Minimum Android version | Android 7.0 Nougat (API 24) |
| Target Android | Android 14 (API 34) |
| Camera | Required, for streaming |
| Network | Wi-Fi (phone & PC/OBS must be on the same network) |
| Recommended RAM | 3 GB+ |

## Project Structure

```
android/
├── app/
│   └── src/main/
│       ├── java/com/dcplugin/cam/   # Kotlin source code
│       ├── res/                     # Layout, drawable, values
│       └── AndroidManifest.xml
├── build.gradle.kts
├── settings.gradle.kts
└── gradlew / gradlew.bat
```

## Requirements

- Android Studio (Koala or newer recommended)
- Android SDK
- Android device with a camera (minimum per `minSdk` in `app/build.gradle.kts`)
- OBS Studio with plugin/WebSocket enabled (optional, for control integration)

## Build Tutorial

### A. Build via Android Studio (easiest)

1. Install [Android Studio](https://developer.android.com/studio) (includes the Android SDK).
2. Clone the repo:
   ```bash
   git clone https://github.com/rianprojects/BroadcastKit.git
   ```
3. Open Android Studio → **Open** → select the `BroadcastKit` folder (the one containing `settings.gradle.kts`).
4. Wait for **Gradle Sync** to finish (bottom-right corner). If prompted to update Gradle/SDK, follow along.
5. Connect an Android phone via USB (enable **USB Debugging** in Developer Options) or set up an emulator.
6. Click the **Run ▶** button (or `Shift+F10`) — choose the target device.
7. The app is installed and launched automatically on the device.

### B. Build via Command Line (CLI)

1. Make sure `JAVA_HOME` points to JDK 17+ and the Android SDK is installed (`ANDROID_HOME` set).
2. Clone the repo and enter its folder:
   ```bash
   git clone https://github.com/rianprojects/BroadcastKit.git
   cd BroadcastKit
   ```
3. Build the debug APK:
   ```bash
   ./gradlew assembleDebug
   ```
   (Windows PowerShell: `.\gradlew.bat assembleDebug`)
4. The APK is located at:
   ```
   app/build/outputs/apk/debug/app-debug.apk
   ```
5. Install on a device connected via ADB:
   ```bash
   adb install app/build/outputs/apk/debug/app-debug.apk
   ```

### C. Build a signed Release APK (for sharing)

1. Generate a keystore (once):
   ```bash
   keytool -genkey -v -keystore release.keystore -alias dcplugin -keyalg RSA -keysize 2048 -validity 10000
   ```
2. Add the signing config to `app/build.gradle.kts` (`signingConfigs` + `buildTypes.release`), or sign manually with `apksigner` after building:
   ```bash
   ./gradlew assembleRelease
   apksigner sign --ks release.keystore app/build/outputs/apk/release/app-release-unsigned.apk
   ```

### After Installation

1. Open the app and grant **Camera** and **Notification** permissions (for the foreground service).
2. Make sure the phone and PC (OBS) are connected to the **same Wi-Fi/network**.
3. Start streaming from the app — note the IP:port shown (default port **8899**, can be changed manually in the app if it conflicts with another service on the phone).
4. In OBS, add **Source → Browser** or **Media Source** with the MJPEG URL (`http://<phone-ip>:8899/video`), or connect via OBS WebSocket according to the app configuration.

> **Tips to reduce delay:** use **5GHz or Wi-Fi 6** (not 2.4GHz) Wi-Fi for both the phone and PC/OBS, and make sure both connect to the same access point (not through a different/far-away mesh router). The 2.4GHz band is more prone to interference and has lower bandwidth, making MJPEG streaming delay/lag more noticeable.

## Permissions Used

| Permission | Purpose |
|---|---|
| `CAMERA` | Capture the camera feed for streaming |
| `INTERNET` | MJPEG server & WebSocket communication |
| `ACCESS_WIFI_STATE` / `ACCESS_NETWORK_STATE` | Detect the local network IP address |
| `FOREGROUND_SERVICE` / `FOREGROUND_SERVICE_CAMERA` | Keep streaming active in the background |

## Contribution & Free Use

This project is **open source and free to use**. Feel free to:

- Fork, redesign, or rebuild to suit your needs/taste.
- Modify features, UI, or architecture without permission.
- Use it for personal or commercial projects.

There are no limits on expression — just keep the license notice below when redistributing.

### If you rebuild/fork

The original creator's footer name (**Rian Projects**) stays embedded in the app and does not need to be removed. To add your name as the rebuilder, fill in the following resource before building:

```xml
<!-- app/src/main/res/values/strings.xml -->
<string name="rebuilder_name">Your Name — your.link</string>
```

The "Rebuilt by: ..." line automatically appears in the app footer below the original creator's name. If left empty, this line is hidden.

## License

This project is licensed under the [MIT License](LICENSE) — free to use, modify, and redistribute, with or without changes, for any purpose.