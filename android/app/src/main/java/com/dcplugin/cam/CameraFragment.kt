package com.dcplugin.cam

import android.Manifest
import android.content.*
import android.content.pm.ActivityInfo
import android.content.pm.PackageManager
import android.graphics.Bitmap
import android.graphics.Color
import android.hardware.Sensor
import android.hardware.SensorEvent
import android.hardware.SensorEventListener
import android.hardware.SensorManager
import android.net.Uri
import android.net.wifi.WifiManager
import android.os.*
import android.provider.Settings
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.AdapterView
import android.widget.ArrayAdapter
import android.widget.SeekBar
import android.widget.Toast
import androidx.activity.result.contract.ActivityResultContracts
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.app.AppCompatDelegate
import androidx.camera.core.CameraSelector
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import com.dcplugin.cam.databinding.FragmentCameraBinding
import com.google.zxing.BarcodeFormat
import com.google.zxing.qrcode.QRCodeWriter
import org.json.JSONObject
import java.net.NetworkInterface

private const val PREFS = "settings"
private const val KEY_THEME = "theme_mode"
private const val KEY_AUTO_START = "auto_start"
private const val KEY_SHAKE = "shake_to_switch"
private const val KEY_PORT = "server_port"
private const val KEY_PIN = "server_pin"
private const val KEY_WATERMARK = "watermark_text"
private const val KEY_TIMER = "auto_stop_timer"
private const val KEY_QUALITY = "jpeg_quality"
private const val KEY_ORIENTATION = "orientation_lock"
private const val KEY_CAMERA_SOURCE = "camera_source"

class CameraFragment : Fragment(), SensorEventListener {

    private var _binding: FragmentCameraBinding? = null
    private val binding get() = _binding!!

    private var running = false
    private var boundService: CameraServerService? = null
    private var isServiceBound = false
    private var isDimmed = false

    private var sensorManager: SensorManager? = null
    private var accelerometer: Sensor? = null
    private var lastShakeTime = 0L

    private val batteryReceiver = object : BroadcastReceiver() {
        override fun onReceive(context: Context, intent: Intent) {
            val level = intent.getIntExtra(BatteryManager.EXTRA_LEVEL, -1)
            val scale = intent.getIntExtra(BatteryManager.EXTRA_SCALE, -1)
            val pct = if (level != -1 && scale != -1) (level * 100 / scale) else -1
            val temp = intent.getIntExtra(BatteryManager.EXTRA_TEMPERATURE, 0) / 10.0
            binding.batteryText.text = "Battery $pct% | $temp°C"

            val plugged = intent.getIntExtra(BatteryManager.EXTRA_PLUGGED, -1)
            val usbConnected = plugged == BatteryManager.BATTERY_PLUGGED_USB
            binding.usbCableModeButton.isEnabled = usbConnected
            binding.usbCableModeButton.alpha = if (usbConnected) 1.0f else 0.5f
            binding.usbCableStatusText.text = if (usbConnected) "USB: connected" else "USB: not connected"
            binding.usbCableStatusText.setTextColor(if (usbConnected) 0xFF4CAF50.toInt() else resources.getColor(R.color.text_hint, null))
        }
    }

    private val timerHandler = Handler(Looper.getMainLooper())
    private var timerRunnable: Runnable? = null

    private val statsHandler = Handler(Looper.getMainLooper())
    private val statsRunnable = object : Runnable {
        override fun run() {
            updateStats()
            statsHandler.postDelayed(this, 1000)
        }
    }

    private val requestPermission = registerForActivityResult(
        ActivityResultContracts.RequestPermission()
    ) { granted -> if (granted) startServer() }

    private val connection = object : ServiceConnection {
        override fun onServiceConnected(name: ComponentName, service: IBinder) {
            isServiceBound = true
            boundService = (service as CameraServerService.LocalBinder).getService()
            boundService?.onStateChanged = { activity?.runOnUiThread { setupControls(); updateUi() } }
            applySavedConfigToService()
            setupControls()
            updateUi()
        }

        override fun onServiceDisconnected(name: ComponentName) {
            isServiceBound = false
            boundService = null
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?
    ): View {
        _binding = FragmentCameraBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        (requireActivity() as? AppCompatActivity)?.let {
            it.setSupportActionBar(binding.toolbar)
            it.supportActionBar?.setDisplayShowTitleEnabled(false)
        }

        sensorManager = requireContext().getSystemService(Context.SENSOR_SERVICE) as? SensorManager
        accelerometer = sensorManager?.getDefaultSensor(Sensor.TYPE_ACCELEROMETER)

        val currentTheme = getPrefs().getInt(KEY_THEME, 1)
        binding.themeSwitch.isChecked = currentTheme != 0
        binding.themeSwitch.setOnCheckedChangeListener { _, checked ->
            val mode = if (checked) 1 else 0
            getPrefs().edit().putInt(KEY_THEME, mode).apply()
            AppCompatDelegate.setDefaultNightMode(if (checked) AppCompatDelegate.MODE_NIGHT_YES else AppCompatDelegate.MODE_NIGHT_NO)
        }

        binding.autoStartSwitch.isChecked = getPrefs().getBoolean(KEY_AUTO_START, false)
        binding.autoStartSwitch.setOnCheckedChangeListener { _, checked ->
            getPrefs().edit().putBoolean(KEY_AUTO_START, checked).apply()
        }

        binding.shakeSwitch.isChecked = getPrefs().getBoolean(KEY_SHAKE, false)
        binding.shakeSwitch.setOnCheckedChangeListener { _, checked ->
            getPrefs().edit().putBoolean(KEY_SHAKE, checked).apply()
            if (checked) {
                accelerometer?.let { sensorManager?.registerListener(this, it, SensorManager.SENSOR_DELAY_UI) }
            } else {
                sensorManager?.unregisterListener(this)
            }
        }

        binding.footerLink.setOnClickListener { openUrl("https://rianprojects.my.id") }
        val rebuilder = getString(R.string.rebuilder_name)
        if (rebuilder.isNotBlank()) {
            binding.rebuilderLine.text = "Rebuilt by: $rebuilder"
            binding.rebuilderLine.visibility = View.VISIBLE
        }
        binding.instagramButton.setOnClickListener { openUrl("https://instagram.com/rian.projects") }
        binding.tiktokButton.setOnClickListener { openUrl("https://tiktok.com/@rian.projetcs") }
        binding.websiteButton.setOnClickListener { openUrl("https://rianprojects.my.id") }
        binding.githubButton.setOnClickListener { openUrl("https://github.com/rianprojects") }

        binding.toggleButton.setOnClickListener {
            if (running) stopServer() else ensurePermissionThenStart()
        }

        binding.copyUrlButton.setOnClickListener {
            val url = getActiveUrl()
            val clipboard = requireContext().getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
            clipboard.setPrimaryClip(ClipData.newPlainText("OBS URL", url))
            Toast.makeText(requireContext(), "URL copied to clipboard!", Toast.LENGTH_SHORT).show()
        }

        binding.usbCableModeButton.setOnClickListener {
            showUsbCableModeDialog()
        }

        binding.flashButton.setOnClickListener {
            boundService?.toggleTorch()
            val on = boundService?.isTorchOn == true
            binding.flashButton.text = if (on) "Flash: ON" else "Flash: OFF"
        }

        binding.dimmerButton.setOnClickListener {
            isDimmed = !isDimmed
            binding.screenDimmer.visibility = if (isDimmed) View.VISIBLE else View.GONE
            binding.dimmerButton.text = if (isDimmed) "Screen Dimmer: ON" else "Screen Dimmer: OFF"
        }
        binding.screenDimmer.setOnClickListener {
            isDimmed = false
            binding.screenDimmer.visibility = View.GONE
            binding.dimmerButton.text = "Screen Dimmer: OFF"
        }

        binding.mirrorSwitch.setOnCheckedChangeListener { _, checked -> boundService?.toggleMirror(checked) }
        binding.aeLockSwitch.setOnCheckedChangeListener { _, checked -> boundService?.toggleAeLock(checked) }


        binding.exportSettingsButton.setOnClickListener { exportSettings() }
        binding.importSettingsButton.setOnClickListener { importSettings() }

        setupSpinners()
        setupQualityBar()
        setupZoomBar()
        loadInputs()
        updateUi()

        if (getPrefs().getBoolean(KEY_AUTO_START, false) && !running) {
            ensurePermissionThenStart()
        }
    }

    override fun onResume() {
        super.onResume()
        requireContext().registerReceiver(batteryReceiver, IntentFilter(Intent.ACTION_BATTERY_CHANGED))
        if (getPrefs().getBoolean(KEY_SHAKE, false)) {
            accelerometer?.let { sensorManager?.registerListener(this, it, SensorManager.SENSOR_DELAY_UI) }
        }
        statsHandler.post(statsRunnable)
    }

    override fun onPause() {
        super.onPause()
        try { requireContext().unregisterReceiver(batteryReceiver) } catch (_: Exception) {}
        sensorManager?.unregisterListener(this)
        statsHandler.removeCallbacks(statsRunnable)
    }

    override fun onDestroyView() {
        // Keep the foreground service running across tab switches / app close;
        // only release the binding here, service persists independently.
        if (isServiceBound) {
            try { requireContext().unbindService(connection) } catch (_: Exception) {}
            isServiceBound = false
        }
        timerRunnable?.let { timerHandler.removeCallbacks(it) }
        _binding = null
        super.onDestroyView()
    }

    private fun getPrefs(): SharedPreferences = requireContext().getSharedPreferences(PREFS, Context.MODE_PRIVATE)

    private fun loadInputs() {
        binding.portInput.setText(getPrefs().getInt(KEY_PORT, 8899).toString())
        binding.pinInput.setText(getPrefs().getString(KEY_PIN, ""))
        binding.watermarkInput.setText(getPrefs().getString(KEY_WATERMARK, ""))
        binding.timerInput.setText(getPrefs().getInt(KEY_TIMER, 0).toString())
    }

    private fun saveInputs() {
        val port = binding.portInput.text.toString().toIntOrNull() ?: 8899
        val pin = binding.pinInput.text.toString().trim().ifEmpty { null }
        val watermark = binding.watermarkInput.text.toString().trim().ifEmpty { null }
        val timer = binding.timerInput.text.toString().toIntOrNull() ?: 0

        getPrefs().edit()
            .putInt(KEY_PORT, port)
            .putString(KEY_PIN, pin)
            .putString(KEY_WATERMARK, watermark)
            .putInt(KEY_TIMER, timer)
            .apply()

        boundService?.let {
            it.reconfigureServer(port, pin)
            it.watermarkText = watermark
        }
        setupTimer(timer)
    }

    private fun applySavedConfigToService() {
        val port = getPrefs().getInt(KEY_PORT, 8899)
        val pin = getPrefs().getString(KEY_PIN, null)
        val watermark = getPrefs().getString(KEY_WATERMARK, null)
        val quality = getPrefs().getInt(KEY_QUALITY, 80)

        val source = if (getPrefs().getInt(KEY_CAMERA_SOURCE, 0) == 1) CameraSource.USB else CameraSource.DEVICE

        boundService?.let {
            it.reconfigureServer(port, pin)
            it.watermarkText = watermark
            it.setJpegQuality(quality)
            if (it.cameraSource != source) it.setCameraSource(source)
        }
    }

    private fun setupTimer(minutes: Int) {
        timerRunnable?.let { timerHandler.removeCallbacks(it) }
        if (minutes > 0 && running) {
            timerRunnable = Runnable {
                Toast.makeText(requireContext(), "Auto-stop timer reached. Stopping server...", Toast.LENGTH_LONG).show()
                stopServer()
            }
            timerHandler.postDelayed(timerRunnable!!, minutes * 60 * 1000L)
        }
    }

    private fun setupSpinners() {
        val labels = RESOLUTION_PRESETS.map { "${it.width}x${it.height}" }
        binding.resolutionSpinner.adapter =
            ArrayAdapter(requireContext(), android.R.layout.simple_spinner_dropdown_item, labels)
        val currentIndex = RESOLUTION_PRESETS.indexOf(boundService?.resolution).coerceAtLeast(0)
        binding.resolutionSpinner.setSelection(currentIndex)
        binding.resolutionSpinner.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
            override fun onItemSelected(parent: AdapterView<*>?, view: View?, pos: Int, id: Long) {
                boundService?.let { if (it.resolution != RESOLUTION_PRESETS[pos]) it.setResolution(RESOLUTION_PRESETS[pos]) }
            }
            override fun onNothingSelected(parent: AdapterView<*>?) {}
        }

        val fpsLabels = FPS_PRESETS.map { "$it FPS" }
        binding.fpsSpinner.adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_dropdown_item, fpsLabels)
        binding.fpsSpinner.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
            override fun onItemSelected(parent: AdapterView<*>?, view: View?, pos: Int, id: Long) {
                boundService?.let { if (it.targetFps != FPS_PRESETS[pos]) it.setFps(FPS_PRESETS[pos]) }
            }
            override fun onNothingSelected(parent: AdapterView<*>?) {}
        }

        binding.switchCameraButton.setOnClickListener { boundService?.switchCamera() }

        val sourceOptions = listOf("Built-in Camera", "USB Camera (OTG)")
        binding.cameraSourceSpinner.adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_dropdown_item, sourceOptions)
        val savedSource = getPrefs().getInt(KEY_CAMERA_SOURCE, 0)
        binding.cameraSourceSpinner.setSelection(savedSource)
        binding.cameraSourceSpinner.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
            override fun onItemSelected(parent: AdapterView<*>?, view: View?, pos: Int, id: Long) {
                getPrefs().edit().putInt(KEY_CAMERA_SOURCE, pos).apply()
                val source = if (pos == 1) CameraSource.USB else CameraSource.DEVICE
                boundService?.let { if (it.cameraSource != source) it.setCameraSource(source) }
            }
            override fun onNothingSelected(parent: AdapterView<*>?) {}
        }

        val orientOptions = listOf("Auto / Sensor", "Portrait Lock", "Landscape Lock")
        binding.orientationSpinner.adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_dropdown_item, orientOptions)
        val savedOrient = getPrefs().getInt(KEY_ORIENTATION, 0)
        binding.orientationSpinner.setSelection(savedOrient)
        binding.orientationSpinner.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
            override fun onItemSelected(parent: AdapterView<*>?, view: View?, pos: Int, id: Long) {
                getPrefs().edit().putInt(KEY_ORIENTATION, pos).apply()
                requireActivity().requestedOrientation = when (pos) {
                    1 -> ActivityInfo.SCREEN_ORIENTATION_PORTRAIT
                    2 -> ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE
                    else -> ActivityInfo.SCREEN_ORIENTATION_UNSPECIFIED
                }
            }
            override fun onNothingSelected(parent: AdapterView<*>?) {}
        }
    }

    private fun setupQualityBar() {
        val savedQuality = getPrefs().getInt(KEY_QUALITY, 80)
        binding.qualitySeekBar.progress = savedQuality - 50
        binding.qualityLabel.text = "$savedQuality%"
        binding.qualitySeekBar.setOnSeekBarChangeListener(object : SeekBar.OnSeekBarChangeListener {
            override fun onProgressChanged(seekBar: SeekBar?, progress: Int, fromUser: Boolean) {
                val quality = 50 + progress
                binding.qualityLabel.text = "$quality%"
                if (fromUser) {
                    getPrefs().edit().putInt(KEY_QUALITY, quality).apply()
                    boundService?.setJpegQuality(quality)
                }
            }
            override fun onStartTrackingTouch(seekBar: SeekBar?) {}
            override fun onStopTrackingTouch(seekBar: SeekBar?) {}
        })
    }

    private fun setupZoomBar() {
        val range = boundService?.zoomRatioRange() ?: android.util.Range(1.0f, 1.0f)
        val maxRatio = (range.upper * 10).toInt()
        val minRatio = (range.lower * 10).toInt()
        binding.zoomSeekBar.max = (maxRatio - minRatio).coerceAtLeast(1)
        binding.zoomSeekBar.progress = ((boundService?.currentZoom ?: 1.0f) * 10 - minRatio).toInt()
        binding.zoomSeekBar.setOnSeekBarChangeListener(object : SeekBar.OnSeekBarChangeListener {
            override fun onProgressChanged(seekBar: SeekBar?, progress: Int, fromUser: Boolean) {
                if (fromUser) {
                    val ratio = (minRatio + progress) / 10.0f
                    boundService?.setZoom(ratio)
                }
            }
            override fun onStartTrackingTouch(seekBar: SeekBar?) {}
            override fun onStopTrackingTouch(seekBar: SeekBar?) {}
        })
    }

    private fun setupExposureBar() {
        val range = boundService?.exposureRange() ?: android.util.Range(0, 0)
        val span = (range.upper - range.lower).coerceAtLeast(1)
        binding.exposureSeekBar.max = span
        binding.exposureSeekBar.progress = (boundService?.currentExposureIndex() ?: 0) - range.lower
        binding.exposureSeekBar.setOnSeekBarChangeListener(object : SeekBar.OnSeekBarChangeListener {
            override fun onProgressChanged(seekBar: SeekBar?, progress: Int, fromUser: Boolean) {
                if (fromUser) boundService?.setExposureCompensation(range.lower + progress)
            }
            override fun onStartTrackingTouch(seekBar: SeekBar?) {}
            override fun onStopTrackingTouch(seekBar: SeekBar?) {}
        })
    }

    private fun setupControls() {
        setupExposureBar()
        setupZoomBar()
        binding.flashButton.text = if (boundService?.isTorchOn == true) "Flash: ON" else "Flash: OFF"
        binding.mirrorSwitch.isChecked = boundService?.isMirrorOn == true
        binding.aeLockSwitch.isChecked = boundService?.isAeLocked == true
    }

    private fun ensurePermissionThenStart() {
        if (ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.CAMERA)
            == PackageManager.PERMISSION_GRANTED
        ) {
            startServer()
        } else {
            requestPermission.launch(Manifest.permission.CAMERA)
        }
    }

    private fun startServer() {
        saveInputs()
        CameraServerService.start(requireContext())
        requireContext().bindService(Intent(requireContext(), CameraServerService::class.java), connection, Context.BIND_AUTO_CREATE)
        isServiceBound = true
        running = true
        updateUi()
        val timer = binding.timerInput.text.toString().toIntOrNull() ?: 0
        setupTimer(timer)
    }

    private fun stopServer() {
        timerRunnable?.let { timerHandler.removeCallbacks(it) }
        if (isServiceBound) {
            try { requireContext().unbindService(connection) } catch (_: Exception) {}
            isServiceBound = false
        }
        boundService = null
        CameraServerService.stop(requireContext())
        running = false
        updateUi()
    }

    private fun updateStats() {
        if (_binding == null) return
        val srv = boundService?.server
        val clients = srv?.clientCount() ?: 0
        val fps = srv?.currentFps ?: 0
        val kbps = srv?.currentKbps ?: 0L

        if (running && boundService?.cameraSource == CameraSource.USB && boundService?.isUsbConnected == false) {
            binding.clientCountText.text = "Waiting for USB camera (plug in via OTG)"
            binding.clientCountText.setTextColor(0xFFFFC107.toInt())
        } else if (running && clients > 0) {
            binding.clientCountText.text = "Connected ($clients OBS / Client)"
            binding.clientCountText.setTextColor(0xFF4CAF50.toInt())
        } else if (running) {
            binding.clientCountText.text = "Server Running (Waiting for OBS)"
            binding.clientCountText.setTextColor(0xFFFFC107.toInt())
        } else {
            binding.clientCountText.text = "Server Stopped"
            binding.clientCountText.setTextColor(0xFF888888.toInt())
        }
        binding.fpsText.text = "$fps FPS | $kbps KB/s"
    }

    private fun getActiveUrl(): String {
        val port = binding.portInput.text.toString().toIntOrNull() ?: 8899
        val pin = binding.pinInput.text.toString().trim().ifEmpty { null }
        val pinSuffix = if (!pin.isNullOrEmpty()) "?pin=$pin" else ""
        return "http://${getLocalIpAddress()}:$port/video$pinSuffix"
    }

    private fun updateUi() {
        binding.toggleButton.text = if (running) "Stop Camera Server" else "Start Camera Server"
        val activeUrl = getActiveUrl()
        binding.urlText.text = if (running) {
            val size = boundService?.actualSize
            var text = "OBS / Browser URL:\n$activeUrl"
            getTailscaleIpAddress()?.let { text += "\n\nOver Tailscale:\nhttp://$it:${boundService?.serverPort ?: 8899}/video" }
            if (size != null) text += "\n\nStream resolution: ${size.width}x${size.height}"
            text
        } else {
            "Server stopped"
        }

        if (running) {
            generateQrCode(activeUrl)?.let {
                binding.qrCodeImage.setImageBitmap(it)
                binding.qrCodeImage.visibility = View.VISIBLE
            }
        } else {
            binding.qrCodeImage.visibility = View.GONE
        }
        updateStats()
    }

    private fun generateQrCode(text: String): Bitmap? {
        return try {
            val writer = QRCodeWriter()
            val bitMatrix = writer.encode(text, BarcodeFormat.QR_CODE, 300, 300)
            val w = bitMatrix.width
            val h = bitMatrix.height
            val bmp = Bitmap.createBitmap(w, h, Bitmap.Config.RGB_565)
            for (x in 0 until w) {
                for (y in 0 until h) {
                    bmp.setPixel(x, y, if (bitMatrix.get(x, y)) Color.BLACK else Color.WHITE)
                }
            }
            bmp
        } catch (_: Exception) {
            null
        }
    }

    private fun exportSettings() {
        val obj = JSONObject().apply {
            put(KEY_PORT, getPrefs().getInt(KEY_PORT, 8899))
            put(KEY_PIN, getPrefs().getString(KEY_PIN, ""))
            put(KEY_WATERMARK, getPrefs().getString(KEY_WATERMARK, ""))
            put(KEY_QUALITY, getPrefs().getInt(KEY_QUALITY, 80))
            put(KEY_AUTO_START, getPrefs().getBoolean(KEY_AUTO_START, false))
            put(KEY_SHAKE, getPrefs().getBoolean(KEY_SHAKE, false))
        }
        val clipboard = requireContext().getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
        clipboard.setPrimaryClip(ClipData.newPlainText("Camera Settings", obj.toString()))
        Toast.makeText(requireContext(), "Settings JSON copied to clipboard!", Toast.LENGTH_SHORT).show()
    }

    private fun importSettings() {
        val clipboard = requireContext().getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
        val text = clipboard.primaryClip?.getItemAt(0)?.text?.toString()
        if (text.isNullOrEmpty()) {
            Toast.makeText(requireContext(), "Clipboard is empty. Copy settings JSON first.", Toast.LENGTH_SHORT).show()
            return
        }
        try {
            val obj = JSONObject(text)
            getPrefs().edit()
                .putInt(KEY_PORT, obj.optInt(KEY_PORT, 8899))
                .putString(KEY_PIN, obj.optString(KEY_PIN, ""))
                .putString(KEY_WATERMARK, obj.optString(KEY_WATERMARK, ""))
                .putInt(KEY_QUALITY, obj.optInt(KEY_QUALITY, 80))
                .putBoolean(KEY_AUTO_START, obj.optBoolean(KEY_AUTO_START, false))
                .putBoolean(KEY_SHAKE, obj.optBoolean(KEY_SHAKE, false))
                .apply()
            loadInputs()
            Toast.makeText(requireContext(), "Settings imported successfully!", Toast.LENGTH_SHORT).show()
        } catch (_: Exception) {
            Toast.makeText(requireContext(), "Invalid settings JSON in clipboard.", Toast.LENGTH_SHORT).show()
        }
    }

    override fun onSensorChanged(event: SensorEvent?) {
        if (event == null || !getPrefs().getBoolean(KEY_SHAKE, false)) return
        val x = event.values[0]
        val y = event.values[1]
        val z = event.values[2]
        val acceleration = Math.sqrt((x * x + y * y + z * z).toDouble()) - SensorManager.GRAVITY_EARTH
        val now = System.currentTimeMillis()
        if (acceleration > 12 && now - lastShakeTime > 1500) {
            lastShakeTime = now
            boundService?.switchCamera()
            Toast.makeText(requireContext(), "Shaken! Switched camera.", Toast.LENGTH_SHORT).show()
        }
    }

    override fun onAccuracyChanged(sensor: Sensor?, accuracy: Int) {}

    private fun openUrl(url: String) {
        startActivity(Intent(Intent.ACTION_VIEW, Uri.parse(url)))
    }

    private fun openTetherSettings() {
        val intents = listOf(
            Intent("android.settings.TETHER_SETTINGS"),
            Intent(Settings.ACTION_WIRELESS_SETTINGS)
        )
        for (intent in intents) {
            try {
                startActivity(intent)
                return
            } catch (_: Exception) {}
        }
        Toast.makeText(requireContext(), "Buka manual: Settings > Hotspot & Tethering", Toast.LENGTH_LONG).show()
    }

    private fun showUsbCableModeDialog() {
        val port = boundService?.serverPort ?: 8899
        val message = "Colok HP ke laptop pakai kabel USB, lalu aktifkan USB Tethering " +
            "(Settings > Network & Internet > Hotspot & Tethering > USB Tethering).\n\n" +
            "Tanpa WiFi/data. Setelah aktif, buka http://${getLocalIpAddress()}:$port/video " +
            "di browser laptop — IP ini otomatis muncul di URL card."
        AlertDialog.Builder(requireContext())
            .setTitle("Start Camera USB (via Cable)")
            .setMessage(message)
            .setPositiveButton("Open Tethering Settings") { _, _ -> openTetherSettings() }
            .setNegativeButton("Close", null)
            .show()
    }

    private fun getTailscaleIpAddress(): String? {
        try {
            for (intf in NetworkInterface.getNetworkInterfaces()) {
                for (addr in intf.inetAddresses) {
                    val ip = addr.hostAddress ?: continue
                    if (addr.isLoopbackAddress || ip.contains(":")) continue
                    val parts = ip.split(".")
                    if (parts.size == 4 && parts[0] == "100") {
                        val second = parts[1].toIntOrNull() ?: continue
                        if (second in 64..127) return ip
                    }
                }
            }
        } catch (_: Exception) {}
        return null
    }

    private fun getLocalIpAddress(): String {
        try {
            val wifi = requireContext().applicationContext.getSystemService(Context.WIFI_SERVICE) as WifiManager
            @Suppress("DEPRECATION")
            val ip = wifi.connectionInfo.ipAddress
            if (ip != 0) {
                return String.format(
                    "%d.%d.%d.%d",
                    ip and 0xff, ip shr 8 and 0xff, ip shr 16 and 0xff, ip shr 24 and 0xff
                )
            }
        } catch (_: Exception) {}
        try {
            for (intf in NetworkInterface.getNetworkInterfaces()) {
                for (addr in intf.inetAddresses) {
                    if (!addr.isLoopbackAddress && addr.hostAddress?.contains(":") == false) {
                        return addr.hostAddress ?: "unknown"
                    }
                }
            }
        } catch (_: Exception) {}
        return "127.0.0.1"
    }
}
