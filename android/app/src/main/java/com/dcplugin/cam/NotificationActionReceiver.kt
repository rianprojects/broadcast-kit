package com.dcplugin.cam

import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent

class NotificationActionReceiver : BroadcastReceiver() {
    override fun onReceive(context: Context, intent: Intent) {
        when (intent.action) {
            "ACTION_STOP" -> CameraServerService.stop(context)
            "ACTION_SWITCH_CAMERA" -> {
                // Send a broadcast that the service picks up, or just restart
                // For simplicity, we'll use a static reference approach
                val svc = CameraServerServiceRef.service
                svc?.switchCamera()
            }
        }
    }
}

/** Lightweight ref so the notification receiver can reach the running service instance. */
object CameraServerServiceRef {
    @Volatile var service: CameraServerService? = null
}
