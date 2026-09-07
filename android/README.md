# BroadcastKit — Android Camera & Control App

Aplikasi Android pendamping untuk OBS: streaming kamera HP sebagai sumber video (MJPEG) ke OBS/PC di jaringan yang sama, plus kontrol tambahan seperti tally light, timer, dan soundboard.

## Fitur

- **Camera streaming** — stream kamera HP via MJPEG server ke OBS/browser di jaringan lokal.
- **Tally light** — indikator status live/preview dari OBS.
- **Timer** — activity timer untuk kebutuhan produksi.
- **Soundboard** — pemutar sound effect cepat.
- **Stats** — informasi statistik koneksi/stream.
- **OBS WebSocket integration** — komunikasi dua arah dengan OBS Studio.
- Foreground service agar streaming tetap jalan saat aplikasi di-background.
- **Dock menu & UI konsisten (v0.1)** — bottom navigation modern (vector icon, dark theme, tanpa emoji), toolbar seragam di semua layar (OBS Deck, More, Stats, Timer, Soundboard).

> Rilis APK siap pakai: lihat [Releases](https://github.com/rianprojects/BroadcastKit/releases).

## Spesifikasi Perangkat

| | |
|---|---|
| Versi Android minimum | Android 7.0 Nougat (API 24) |
| Target Android | Android 14 (API 34) |
| Kamera | Wajib, untuk fitur streaming |
| Jaringan | Wi-Fi (HP & PC/OBS harus satu jaringan) |
| RAM disarankan | 3 GB+ |

## Struktur Proyek

```
android/
├── app/
│   └── src/main/
│       ├── java/com/dcplugin/cam/   # Source code Kotlin
│       ├── res/                     # Layout, drawable, values
│       └── AndroidManifest.xml
├── build.gradle.kts
├── settings.gradle.kts
└── gradlew / gradlew.bat
```

## Requirements

- Android Studio (Koala atau lebih baru direkomendasikan)
- Android SDK
- Perangkat Android dengan kamera (min. sesuai `minSdk` di `app/build.gradle.kts`)
- OBS Studio dengan plugin/WebSocket aktif (opsional, untuk integrasi kontrol)

## Tutorial Build

### A. Build via Android Studio (paling gampang)

1. Install [Android Studio](https://developer.android.com/studio) (sudah termasuk Android SDK).
2. Clone repo:
   ```bash
   git clone https://github.com/rianprojects/BroadcastKit.git
   ```
3. Buka Android Studio → **Open** → pilih folder `BroadcastKit` (folder yang berisi `settings.gradle.kts`).
4. Tunggu proses **Gradle Sync** selesai (pojok kanan bawah). Kalau diminta update Gradle/SDK, ikuti saja.
5. Sambungkan HP Android via USB (aktifkan **USB Debugging** di Developer Options) atau siapkan emulator.
6. Klik tombol **Run ▶** (atau `Shift+F10`) — pilih device tujuan.
7. Aplikasi otomatis ter-install & terbuka di device.

### B. Build via Command Line (CLI)

1. Pastikan `JAVA_HOME` mengarah ke JDK 17+ dan Android SDK sudah terinstall (`ANDROID_HOME` di-set).
2. Clone repo lalu masuk ke foldernya:
   ```bash
   git clone https://github.com/rianprojects/BroadcastKit.git
   cd BroadcastKit
   ```
3. Build APK debug:
   ```bash
   ./gradlew assembleDebug
   ```
   (Windows PowerShell: `.\gradlew.bat assembleDebug`)
4. Hasil APK ada di:
   ```
   app/build/outputs/apk/debug/app-debug.apk
   ```
5. Install ke device yang sudah tersambung via ADB:
   ```bash
   adb install app/build/outputs/apk/debug/app-debug.apk
   ```

### C. Build APK Release (sudah di-sign, untuk dibagikan)

1. Generate keystore (sekali saja):
   ```bash
   keytool -genkey -v -keystore release.keystore -alias dcplugin -keyalg RSA -keysize 2048 -validity 10000
   ```
2. Tambahkan konfigurasi signing di `app/build.gradle.kts` (`signingConfigs` + `buildTypes.release`), atau sign manual pakai `apksigner` setelah build:
   ```bash
   ./gradlew assembleRelease
   apksigner sign --ks release.keystore app/build/outputs/apk/release/app-release-unsigned.apk
   ```

### Setelah Install

1. Buka aplikasi, izinkan permission **Camera** dan **Notification** (untuk foreground service).
2. Pastikan HP dan PC (OBS) terhubung di **Wi-Fi/jaringan yang sama**.
3. Jalankan streaming dari app — catat alamat IP:port yang muncul (default port **8899**, bisa diganti manual di app kalau bentrok dengan service lain di HP).
4. Di OBS, tambahkan **Source → Browser** atau **Media Source** dengan URL MJPEG tersebut (`http://<ip-hp>:8899/video`), atau hubungkan lewat OBS WebSocket sesuai konfigurasi di app.

> **Tips mengurangi delay:** gunakan Wi-Fi **5GHz atau Wi-Fi 6** (bukan 2.4GHz) untuk HP dan PC/OBS, dan pastikan keduanya konek ke access point yang sama (bukan lewat router berbeda/mesh yang jauh). Band 2.4GHz lebih rentan interferensi dan bandwidth-nya lebih kecil, sehingga delay/lag MJPEG streaming jadi lebih terasa.

## Izin yang Digunakan

| Permission | Kegunaan |
|---|---|
| `CAMERA` | Mengambil feed kamera untuk streaming |
| `INTERNET` | Server MJPEG & komunikasi WebSocket |
| `ACCESS_WIFI_STATE` / `ACCESS_NETWORK_STATE` | Deteksi alamat IP jaringan lokal |
| `FOREGROUND_SERVICE` / `FOREGROUND_SERVICE_CAMERA` | Menjaga streaming tetap aktif di background |

## Kontribusi & Penggunaan Bebas

Proyek ini **open source dan bebas digunakan**. Silakan:

- Fork, redesign, atau build ulang sesuai kebutuhan/selera kamu.
- Modifikasi fitur, UI, atau arsitektur tanpa perlu izin.
- Gunakan untuk proyek pribadi maupun komersial.

Tidak ada batasan berekspresi — cukup pertahankan notice lisensi di bawah saat mendistribusikan ulang.

### Kalau kamu rebuild/fork

Footer nama pembuat asli (**Rian Projects**) tetap tertanam di aplikasi dan tidak perlu dihapus. Untuk menambahkan namamu sebagai rebuilder, isi resource berikut sebelum build:

```xml
<!-- app/src/main/res/values/strings.xml -->
<string name="rebuilder_name">Nama Kamu — link.mu</string>
```

Baris "Rebuilt by: ..." otomatis muncul di footer aplikasi di bawah nama pembuat asli. Kalau dikosongkan, baris ini tersembunyi.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE) — bebas dipakai, dimodifikasi, dan didistribusikan ulang, dengan atau tanpa perubahan, untuk keperluan apa pun.
