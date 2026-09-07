package com.dcplugin.cam

import android.content.Context
import android.hardware.usb.UsbDevice
import android.util.Size
import com.serenegiant.usb.USBMonitor
import com.serenegiant.usb.UVCCamera
import java.nio.ByteBuffer

/**
 * Wraps the vendored UVCCamera/USBMonitor (com.serenegiant.usb, from saki4510t's UVCCamera via
 * jiangdongguo/AndroidUSBCamera v1.3.2) to feed raw NV21 frames into the same JPEG pipeline used
 * for the built-in camera. No preview Surface is attached — UVCCamera streams via the frame
 * callback independent of any display, so this runs headless inside the foreground Service.
 */
class UsbCameraController(
    context: Context,
    private val onFrame: (nv21: ByteArray, width: Int, height: Int) -> Unit,
    private val onConnectionChanged: (connected: Boolean) -> Unit
) {
    private val appContext = context.applicationContext
    private var monitor: USBMonitor? = null
    private var camera: UVCCamera? = null
    private var requestedSize = Size(640, 480)

    private val listener = object : USBMonitor.OnDeviceConnectListener {
        override fun onAttach(device: UsbDevice) {
            monitor?.requestPermission(device)
        }

        override fun onDettach(device: UsbDevice) {}

        override fun onConnect(device: UsbDevice, ctrlBlock: USBMonitor.UsbControlBlock, createNew: Boolean) {
            openCamera(ctrlBlock)
        }

        override fun onDisconnect(device: UsbDevice, ctrlBlock: USBMonitor.UsbControlBlock) {
            closeCamera()
            onConnectionChanged(false)
        }

        override fun onCancel(device: UsbDevice) {
            onConnectionChanged(false)
        }
    }

    fun start(resolution: Size) {
        requestedSize = resolution
        if (monitor == null) monitor = USBMonitor(appContext, listener)
        monitor?.register()
        // Already-attached device won't fire onAttach again; request permission for it directly.
        monitor?.getDeviceList()?.firstOrNull()?.let { monitor?.requestPermission(it) }
    }

    /** Reopens the connected device (if any) at the new size; USBMonitor re-fires onConnect. */
    fun setResolution(resolution: Size) {
        requestedSize = resolution
        val dev = camera?.device ?: return
        closeCamera()
        monitor?.getDeviceList()?.firstOrNull { it.deviceId == dev.deviceId }?.let { monitor?.requestPermission(it) }
    }

    fun isConnected(): Boolean = camera != null

    fun stop() {
        closeCamera()
        monitor?.unregister()
        monitor?.destroy()
        monitor = null
    }

    private fun openCamera(ctrlBlock: USBMonitor.UsbControlBlock) {
        closeCamera()
        try {
            val cam = UVCCamera()
            cam.open(ctrlBlock)
            cam.setPreviewSize(requestedSize.width, requestedSize.height, UVCCamera.FRAME_FORMAT_MJPEG)
            cam.setFrameCallback({ frame: ByteBuffer ->
                val bytes = ByteArray(frame.remaining())
                frame.get(bytes)
                onFrame(bytes, requestedSize.width, requestedSize.height)
            }, UVCCamera.PIXEL_FORMAT_NV21)
            cam.startPreview()
            camera = cam
            onConnectionChanged(true)
        } catch (e: Exception) {
            camera = null
            onConnectionChanged(false)
        }
    }

    private fun closeCamera() {
        try {
            camera?.stopPreview()
            camera?.destroy()
        } catch (_: Exception) {
        }
        camera = null
    }
}
