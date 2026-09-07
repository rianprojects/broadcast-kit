package com.dcplugin.cam

import fi.iki.elonen.NanoHTTPD
import java.io.PipedInputStream
import java.io.PipedOutputStream
import java.util.concurrent.CopyOnWriteArraySet
import java.util.concurrent.Executors
import java.util.concurrent.atomic.AtomicInteger
import java.util.concurrent.atomic.AtomicLong

private const val BOUNDARY = "frame"

/**
 * Minimal MJPEG-over-HTTP server with PIN protection, remote API, and stats.
 */
class MjpegServer(
    port: Int,
    var pin: String? = null,
    private val actionHandler: ((action: String, value: String?) -> String)? = null
) : NanoHTTPD(port) {

    private val streams = CopyOnWriteArraySet<PipedOutputStream>()
    private val pushExecutor = Executors.newCachedThreadPool()

    @Volatile var lastWidth = 0
        private set
    @Volatile var lastHeight = 0
        private set

    // Stats
    private val frameCount = AtomicInteger(0)
    private val byteCount = AtomicLong(0)
    private var lastStatTime = System.currentTimeMillis()
    @Volatile var currentFps = 0
        private set
    @Volatile var currentKbps = 0L
        private set

    var onClientConnected: ((Int) -> Unit)? = null
    var onClientDisconnected: ((Int) -> Unit)? = null

    /** Call from the camera analyzer with each new JPEG frame. */
    fun pushFrame(jpeg: ByteArray, width: Int = 0, height: Int = 0) {
        if (width > 0) lastWidth = width
        if (height > 0) lastHeight = height

        // Update stats
        val count = frameCount.incrementAndGet()
        val bytes = byteCount.addAndGet(jpeg.size.toLong())
        val now = System.currentTimeMillis()
        val elapsed = now - lastStatTime
        if (elapsed >= 1000) {
            currentFps = (count * 1000L / elapsed).toInt()
            currentKbps = (bytes * 1000L / elapsed) / 1024
            frameCount.set(0)
            byteCount.set(0)
            lastStatTime = now
        }

        if (streams.isEmpty()) return

        val header = ("--$BOUNDARY\r\n" +
            "Content-Type: image/jpeg\r\n" +
            "Content-Length: ${jpeg.size}\r\n\r\n").toByteArray()
        val footer = "\r\n".toByteArray()
        for (out in streams) {
            pushExecutor.execute {
                try {
                    synchronized(out) {
                        out.write(header)
                        out.write(jpeg)
                        out.write(footer)
                        out.flush()
                    }
                } catch (e: Exception) {
                    streams.remove(out)
                    try { out.close() } catch (_: Exception) {}
                    onClientDisconnected?.invoke(streams.size)
                }
            }
        }
    }

    override fun serve(session: IHTTPSession): Response {
        val uri = session.uri
        val parms = session.parameters

        // Check PIN if set
        val reqPin = parms["pin"]?.firstOrNull()
        if (!pin.isNullOrEmpty() && pin != reqPin && uri != "/") {
            return newFixedLengthResponse(
                Response.Status.UNAUTHORIZED,
                "text/plain",
                "Unauthorized: PIN required (?pin=XXXX)"
            )
        }

        return when {
            uri == "/video" -> streamResponse()
            uri == "/" -> newFixedLengthResponse(Response.Status.OK, "text/html", statusPage(reqPin))
            uri.startsWith("/api/") -> handleApi(uri.removePrefix("/api/"), parms)
            else -> newFixedLengthResponse(Response.Status.NOT_FOUND, "text/plain", "not found")
        }
    }

    private fun handleApi(action: String, parms: Map<String, List<String>>): Response {
        val value = parms["val"]?.firstOrNull() ?: parms["value"]?.firstOrNull()
        val result = actionHandler?.invoke(action, value) ?: "ok"
        val resp = newFixedLengthResponse(
            Response.Status.OK,
            "application/json",
            """{"status":"$result","clients":${streams.size},"fps":$currentFps}"""
        )
        resp.addHeader("Access-Control-Allow-Origin", "*")
        return resp
    }

    private fun streamResponse(): Response {
        val pipedIn = PipedInputStream(1 shl 20)
        val pipedOut = PipedOutputStream(pipedIn)
        streams.add(pipedOut)
        onClientConnected?.invoke(streams.size)
        val resp = newChunkedResponse(
            Response.Status.OK,
            "multipart/x-mixed-replace; boundary=$BOUNDARY",
            pipedIn
        )
        resp.addHeader("Cache-Control", "no-cache, private")
        resp.addHeader("Connection", "close")
        resp.addHeader("Access-Control-Allow-Origin", "*")
        return resp
    }

    private fun statusPage(reqPin: String?): String {
        val dims = if (lastWidth > 0) "${lastWidth}x${lastHeight}" else "waiting for first frame..."
        val clients = streams.size
        val pinSuffix = if (!pin.isNullOrEmpty()) "?pin=$pin" else ""
        return """
        <html><body style="background:#111;color:#eee;font-family:sans-serif;text-align:center;padding:20px">
        <h2>BroadcastKit v0.1</h2>
        <div style="padding:10px;background:#222;display:inline-block;border-radius:8px;margin-bottom:15px">
            <b>Status:</b> ${if (clients > 0) "<span style='color:#4CAF50'>Connected ($clients Clients)</span>" else "<span style='color:#bbb'>Idle / No Client</span>"}<br>
            <b>Live Stats:</b> $currentFps FPS | $currentKbps KB/s<br>
            <b>Resolution:</b> $dims
        </div>
        <p>OBS Browser/Media Source URL:</p>
        <code>http://&lt;this-device-ip&gt;:${listeningPort}/video$pinSuffix</code>
        <p style="margin-top:15px"><img src="/video$pinSuffix" style="max-width:90%;border:2px solid #444;border-radius:6px" /></p>
        </body></html>
        """.trimIndent()
    }

    fun clientCount() = streams.size
}
