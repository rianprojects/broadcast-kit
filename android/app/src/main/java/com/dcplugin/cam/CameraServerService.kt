package com.dcplugin.cam

import android.app.*
import android.content.Context
import android.content.Intent
import android.graphics.*
import android.hardware.camera2.CameraCharacteristics
import android.hardware.camera2.CaptureRequest
import android.os.Binder
import android.os.Build
import android.os.IBinder
import android.util.Range
import android.util.Size
import androidx.camera.camera2.interop.Camera2Interop
import androidx.camera.core.*
import androidx.camera.core.Camera
import androidx.camera.lifecycle.ProcessCameraProvider
import androidx.core.app.NotificationCompat
import androidx.lifecycle.LifecycleService
import java.io.ByteArrayOutputStream
import java.util.concurrent.Executors

private const val CHANNEL_ID = "camera_server"
private const val NOTIF_ID = 1

val RESOLUTION_PRESETS = listOf(
    Size(1920, 1080),
    Size(1280, 720),
    Size(854, 480),
    Size(640, 360)
)

val FPS_PRESETS = listOf(30, 60, 24, 15)

enum class CameraSource { DEVICE, USB }

class CameraServerService : LifecycleService() {

    inner class LocalBinder : Binder() {
        fun getService(): CameraServerService = this@CameraServerService
    }

    private val binder = LocalBinder()

    var server: MjpegServer? = null
        private set

    private val cameraExecutor = Executors.newSingleThreadExecutor()
    private var cameraProvider: ProcessCameraProvider? = null
    private var camera: Camera? = null

    var cameraSource = CameraSource.DEVICE
        private set
    private var usbController: UsbCameraController? = null
    var isUsbConnected = false
        private set

    var lensFacing = CameraSelector.LENS_FACING_BACK
        private set
    var resolution = RESOLUTION_PRESETS[0]
        private set
    var targetFps = 30
        private set
    var isTorchOn = false
        private set
    var isMirrorOn = false
        private set
    var isAeLocked = false
        private set
    var currentZoom = 1.0f
        private set
    var jpegQuality = 80
        private set
    var watermarkText: String? = null
    var serverPort = 8899
        private set
    var serverPin: String? = null
        private set

    var actualSize = resolution
        private set

    var onStateChanged: (() -> Unit)? = null

    /** List of available camera lens IDs */
    var availableCameras: List<CameraInfo> = emptyList()
        private set

    override fun onCreate() {
        super.onCreate()
        CameraServerServiceRef.service = this
        startForeground(NOTIF_ID, buildNotification())
        startServer()
        startCamera()
    }

    private fun startServer(attempt: Int = 0) {
        server?.stop()
        server = null
        try {
            server = MjpegServer(serverPort, serverPin) { action, value ->
                handleRemoteCommand(action, value)
            }.also { it.start(5000, false) }
        } catch (e: java.io.IOException) {
            // Port left bound by a not-yet-released previous instance (e.g. quick app
            // restart) — it frees up within ~1s. Retry a few times before giving up.
            if (attempt < 5) {
                android.os.Handler(mainLooper).postDelayed({ startServer(attempt + 1) }, 400)
            }
        }
    }

    fun reconfigureServer(port: Int, pin: String?) {
        val changed = port != serverPort || pin != serverPin
        serverPort = port
        serverPin = pin
        if (changed) {
            startServer()
        } else {
            server?.pin = pin
        }
    }

    private fun handleRemoteCommand(action: String, value: String?): String {
        when (action) {
            "switch" -> switchCamera()
            "torch", "flash" -> toggleTorch(value?.toBooleanStrictOrNull() ?: !isTorchOn)
            "zoom" -> value?.toFloatOrNull()?.let { setZoom(it) }
            "exposure" -> value?.toIntOrNull()?.let { setExposureCompensation(it) }
            "mirror" -> toggleMirror(value?.toBooleanStrictOrNull() ?: !isMirrorOn)
            "aelock" -> toggleAeLock(value?.toBooleanStrictOrNull() ?: !isAeLocked)
            "quality" -> value?.toIntOrNull()?.let { setJpegQuality(it) }
            "status" -> return "running"
        }
        return "ok"
    }

    fun switchCamera() {
        lensFacing = if (lensFacing == CameraSelector.LENS_FACING_BACK)
            CameraSelector.LENS_FACING_FRONT else CameraSelector.LENS_FACING_BACK
        isTorchOn = false
        startCamera()
    }

    fun setLensFacing(facing: Int) {
        lensFacing = facing
        isTorchOn = false
        startCamera()
    }

    fun setResolution(size: Size) {
        resolution = size
        if (cameraSource == CameraSource.USB) usbController?.setResolution(size) else startCamera()
    }

    fun setCameraSource(source: CameraSource) {
        if (source == cameraSource) return
        cameraSource = source
        stopCurrentCameraSource()
        startCamera()
    }

    private fun stopCurrentCameraSource() {
        cameraProvider?.unbindAll()
        usbController?.stop()
        usbController = null
        isUsbConnected = false
    }

    fun setFps(fps: Int) {
        targetFps = fps
        startCamera()
    }

    fun setJpegQuality(q: Int) {
        jpegQuality = q.coerceIn(50, 100)
    }

    fun toggleTorch(enable: Boolean? = null) {
        if (lensFacing == CameraSelector.LENS_FACING_FRONT) return
        isTorchOn = enable ?: !isTorchOn
        camera?.cameraControl?.enableTorch(isTorchOn)
        onStateChanged?.invoke()
    }

    fun toggleMirror(enable: Boolean? = null) {
        isMirrorOn = enable ?: !isMirrorOn
        onStateChanged?.invoke()
    }

    fun toggleAeLock(enable: Boolean? = null) {
        isAeLocked = enable ?: !isAeLocked
        startCamera()
    }

    fun setZoom(ratio: Float) {
        currentZoom = ratio
        camera?.cameraControl?.setZoomRatio(ratio)
    }

    fun zoomRatioRange(): Range<Float> {
        val state = camera?.cameraInfo?.zoomState?.value
        return if (state != null) Range(state.minZoomRatio, state.maxZoomRatio) else Range(1.0f, 1.0f)
    }

    fun exposureRange(): Range<Int> =
        camera?.cameraInfo?.exposureState?.exposureCompensationRange ?: Range(0, 0)

    fun setExposureCompensation(index: Int) {
        camera?.cameraControl?.setExposureCompensationIndex(index)
    }

    fun currentExposureIndex(): Int =
        camera?.cameraInfo?.exposureState?.exposureCompensationIndex ?: 0

    fun serverUrl(ip: String): String {
        val pinSuffix = if (!serverPin.isNullOrEmpty()) "?pin=$serverPin" else ""
        return "http://$ip:$serverPort/video$pinSuffix"
    }

    private fun startCamera() {
        if (cameraSource == CameraSource.USB) startUsbCamera() else startDeviceCamera()
    }

    private fun startUsbCamera() {
        if (usbController == null) {
            usbController = UsbCameraController(
                context = this,
                onFrame = { nv21, width, height ->
                    actualSize = Size(width, height)
                    val jpeg = nv21ToJpeg(nv21, width, height, isMirrorOn, watermarkText, jpegQuality)
                    server?.pushFrame(jpeg, width, height)
                },
                onConnectionChanged = { connected ->
                    isUsbConnected = connected
                    onStateChanged?.invoke()
                }
            )
        }
        usbController?.start(resolution)
        onStateChanged?.invoke()
    }

    private fun startDeviceCamera() {
        val future = ProcessCameraProvider.getInstance(this)
        future.addListener({
            cameraProvider = future.get()

            // Enumerate available cameras
            availableCameras = cameraProvider?.availableCameraInfos ?: emptyList()

            val selector = CameraSelector.Builder().requireLensFacing(lensFacing).build()

            val resolutionSelector = androidx.camera.core.resolutionselector.ResolutionSelector.Builder()
                .setAspectRatioStrategy(
                    androidx.camera.core.resolutionselector.AspectRatioStrategy(
                        AspectRatio.RATIO_16_9,
                        androidx.camera.core.resolutionselector.AspectRatioStrategy.FALLBACK_RULE_AUTO
                    )
                )
                .setResolutionStrategy(
                    androidx.camera.core.resolutionselector.ResolutionStrategy(
                        resolution,
                        androidx.camera.core.resolutionselector.ResolutionStrategy.FALLBACK_RULE_CLOSEST_HIGHER_THEN_LOWER
                    )
                )
                .build()

            val builder = ImageAnalysis.Builder()
                .setResolutionSelector(resolutionSelector)
                .setOutputImageFormat(ImageAnalysis.OUTPUT_IMAGE_FORMAT_YUV_420_888)
                .setBackpressureStrategy(ImageAnalysis.STRATEGY_KEEP_ONLY_LATEST)

            val ext = Camera2Interop.Extender(builder)
            ext.setCaptureRequestOption(
                CaptureRequest.CONTROL_AF_MODE,
                CaptureRequest.CONTROL_AF_MODE_CONTINUOUS_PICTURE
            )
            ext.setCaptureRequestOption(
                CaptureRequest.CONTROL_AE_TARGET_FPS_RANGE,
                Range(targetFps, targetFps)
            )
            if (isAeLocked) {
                ext.setCaptureRequestOption(CaptureRequest.CONTROL_AE_LOCK, true)
                ext.setCaptureRequestOption(CaptureRequest.CONTROL_AWB_LOCK, true)
            }

            val analysis = builder.build()
            analysis.setAnalyzer(cameraExecutor) { imageProxy ->
                try {
                    actualSize = Size(imageProxy.width, imageProxy.height)
                    val mirror = isMirrorOn && lensFacing == CameraSelector.LENS_FACING_FRONT
                    val jpeg = imageProxy.toJpeg(mirror, watermarkText, jpegQuality)
                    if (jpeg != null) server?.pushFrame(jpeg, imageProxy.width, imageProxy.height)
                } finally {
                    imageProxy.close()
                }
            }

            cameraProvider?.unbindAll()
            camera = cameraProvider?.bindToLifecycle(this, selector, analysis)
            if (isTorchOn && lensFacing == CameraSelector.LENS_FACING_BACK) {
                camera?.cameraControl?.enableTorch(true)
            }
            onStateChanged?.invoke()
        }, androidx.core.content.ContextCompat.getMainExecutor(this))
    }

    private fun ImageProxy.toJpeg(mirror: Boolean, watermark: String?, quality: Int): ByteArray? {
        if (format != ImageFormat.YUV_420_888) return null
        return nv21ToJpeg(yuv420ToNv21(this), width, height, mirror, watermark, quality)
    }

    private fun nv21ToJpeg(
        raw: ByteArray, width: Int, height: Int, mirror: Boolean, watermark: String?, quality: Int
    ): ByteArray {
        val nv21 = if (mirror) flipNv21Horizontal(raw, width, height) else raw
        val yuvImage = YuvImage(nv21, ImageFormat.NV21, width, height, null)

        if (watermark.isNullOrEmpty()) {
            // Mirroring is done on the raw YUV bytes above (cheap row reverse), so this
            // fast path (single JPEG encode) also covers the mirrored case — no need to
            // decode back to a Bitmap and re-encode, which used to add a full extra
            // encode/decode pass per frame and caused visible stream delay.
            val out = ByteArrayOutputStream()
            yuvImage.compressToJpeg(Rect(0, 0, width, height), quality, out)
            return out.toByteArray()
        }

        // Watermark text needs a Canvas, so only this path needs a Bitmap.
        val out = ByteArrayOutputStream()
        yuvImage.compressToJpeg(Rect(0, 0, width, height), 100, out)
        val rawBytes = out.toByteArray()
        val decodeOpts = BitmapFactory.Options().apply { inMutable = true }
        val bmp = BitmapFactory.decodeByteArray(rawBytes, 0, rawBytes.size, decodeOpts) ?: return rawBytes

        if (!watermark.isNullOrEmpty()) {
            val canvas = android.graphics.Canvas(bmp)
            val paint = Paint().apply {
                color = Color.WHITE
                textSize = bmp.height / 30f
                isAntiAlias = true
                setShadowLayer(2f, 1f, 1f, Color.BLACK)
            }
            canvas.drawText(watermark, 16f, bmp.height - 16f, paint)
        }

        val finalOut = ByteArrayOutputStream()
        bmp.compress(Bitmap.CompressFormat.JPEG, quality, finalOut)
        bmp.recycle()
        return finalOut.toByteArray()
    }

    /** Horizontal flip on raw NV21 bytes (Y plane + interleaved VU plane), no Bitmap needed. */
    private fun flipNv21Horizontal(nv21: ByteArray, width: Int, height: Int): ByteArray {
        val out = ByteArray(nv21.size)
        for (row in 0 until height) {
            val rowStart = row * width
            for (col in 0 until width) {
                out[rowStart + col] = nv21[rowStart + (width - 1 - col)]
            }
        }
        val ySize = width * height
        val chromaWidth = width / 2
        for (row in 0 until height / 2) {
            val rowStart = ySize + row * chromaWidth * 2
            for (col in 0 until chromaWidth) {
                val srcCol = chromaWidth - 1 - col
                out[rowStart + col * 2] = nv21[rowStart + srcCol * 2]
                out[rowStart + col * 2 + 1] = nv21[rowStart + srcCol * 2 + 1]
            }
        }
        return out
    }

    private fun yuv420ToNv21(image: ImageProxy): ByteArray {
        val width = image.width
        val height = image.height
        val nv21 = ByteArray(width * height * 3 / 2)

        val yPlane = image.planes[0]
        var pos = 0
        val yBuf = yPlane.buffer
        val yRowStride = yPlane.rowStride
        for (row in 0 until height) {
            yBuf.position(row * yRowStride)
            yBuf.get(nv21, pos, width)
            pos += width
        }

        val uPlane = image.planes[1]
        val vPlane = image.planes[2]
        val uBuf = uPlane.buffer
        val vBuf = vPlane.buffer
        val uRowStride = uPlane.rowStride
        val uPixelStride = uPlane.pixelStride
        val chromaHeight = height / 2
        val chromaWidth = width / 2
        for (row in 0 until chromaHeight) {
            val vRowStart = row * vPlane.rowStride
            val uRowStart = row * uRowStride
            for (col in 0 until chromaWidth) {
                nv21[pos++] = vBuf.get(vRowStart + col * vPlane.pixelStride)
                nv21[pos++] = uBuf.get(uRowStart + col * uPixelStride)
            }
        }
        return nv21
    }

    private fun buildNotification(): Notification {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            val channel = NotificationChannel(
                CHANNEL_ID, "Camera Server", NotificationManager.IMPORTANCE_LOW
            )
            getSystemService(NotificationManager::class.java).createNotificationChannel(channel)
        }

        val stopIntent = Intent(this, NotificationActionReceiver::class.java).apply {
            action = "ACTION_STOP"
        }
        val stopPending = android.app.PendingIntent.getBroadcast(
            this, 0, stopIntent,
            android.app.PendingIntent.FLAG_UPDATE_CURRENT or android.app.PendingIntent.FLAG_IMMUTABLE
        )

        val switchIntent = Intent(this, NotificationActionReceiver::class.java).apply {
            action = "ACTION_SWITCH_CAMERA"
        }
        val switchPending = android.app.PendingIntent.getBroadcast(
            this, 1, switchIntent,
            android.app.PendingIntent.FLAG_UPDATE_CURRENT or android.app.PendingIntent.FLAG_IMMUTABLE
        )

        return NotificationCompat.Builder(this, CHANNEL_ID)
            .setContentTitle("Camera server running")
            .setContentText("Streaming on port $serverPort")
            .setSmallIcon(android.R.drawable.ic_menu_camera)
            .setOngoing(true)
            .addAction(android.R.drawable.ic_media_pause, "Stop", stopPending)
            .addAction(android.R.drawable.ic_menu_rotate, "Switch Cam", switchPending)
            .build()
    }

    override fun onDestroy() {
        CameraServerServiceRef.service = null
        cameraProvider?.unbindAll()
        usbController?.stop()
        cameraExecutor.shutdown()
        server?.stop()
        super.onDestroy()
    }

    override fun onBind(intent: Intent): IBinder {
        super.onBind(intent)
        return binder
    }

    companion object {
        fun start(context: Context) {
            context.startForegroundService(Intent(context, CameraServerService::class.java))
        }

        fun stop(context: Context) {
            context.stopService(Intent(context, CameraServerService::class.java))
        }
    }
}
