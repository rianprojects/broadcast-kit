package com.dcplugin.cam

import android.util.Base64
import android.util.Log
import org.java_websocket.client.WebSocketClient
import org.java_websocket.handshake.ServerHandshake
import org.json.JSONArray
import org.json.JSONObject
import java.net.URI
import java.security.MessageDigest
import java.util.concurrent.ConcurrentHashMap
import java.util.concurrent.atomic.AtomicInteger

/**
 * obs-websocket v5 client.
 * Protocol: Hello(0) -> Identify(1) -> Identified(2); Event(5), Request(6), RequestResponse(7).
 */
class OBSWebSocketManager(
    private val host: String,
    private val port: Int = 4455,
    private val password: String? = null
) {
    private var client: WebSocketClient? = null
    private val reqId = AtomicInteger(1)
    private val pending = ConcurrentHashMap<String, (JSONObject?) -> Unit>()

    @Volatile var isConnected = false
        private set

    /** Fired on connect/disconnect/error with a human-readable state. */
    var onStatus: ((String) -> Unit)? = null
    /** Fired for every OBS event: (eventType, eventData). */
    var onEvent: ((String, JSONObject) -> Unit)? = null

    fun connect() {
        disconnect()
        client = object : WebSocketClient(URI("ws://$host:$port")) {
            override fun onOpen(h: ServerHandshake?) = onStatus?.invoke("Handshaking…") ?: Unit
            override fun onMessage(message: String?) {
                message ?: return
                try { route(JSONObject(message)) } catch (e: Exception) { Log.e(TAG, "parse", e) }
            }
            override fun onClose(code: Int, reason: String?, remote: Boolean) {
                isConnected = false
                onStatus?.invoke("Disconnected ($code)")
            }
            override fun onError(ex: Exception?) {
                isConnected = false
                onStatus?.invoke("Error: ${ex?.message}")
            }
        }
        onStatus?.invoke("Connecting to $host:$port…")
        client?.connect()
    }

    private fun route(msg: JSONObject) {
        val d = msg.optJSONObject("d") ?: JSONObject()
        when (msg.optInt("op", -1)) {
            0 -> sendIdentify(d)
            2 -> { isConnected = true; onStatus?.invoke("Connected") }
            5 -> onEvent?.invoke(d.optString("eventType"), d.optJSONObject("eventData") ?: JSONObject())
            7 -> {
                val id = d.optJSONObject("requestStatus")?.let { d.optString("requestId") } ?: d.optString("requestId")
                val ok = d.optJSONObject("requestStatus")?.optBoolean("result") == true
                pending.remove(id)?.invoke(if (ok) d.optJSONObject("responseData") ?: JSONObject() else null)
            }
        }
    }

    private fun sendIdentify(hello: JSONObject) {
        val d = JSONObject().put("rpcVersion", 1)
        hello.optJSONObject("authentication")?.let { auth ->
            val pw = password.orEmpty()
            val salt = auth.optString("salt")
            val challenge = auth.optString("challenge")
            val secret = b64sha256(pw + salt)
            d.put("authentication", b64sha256(secret + challenge))
        }
        client?.send(JSONObject().put("op", 1).put("d", d).toString())
    }

    private fun b64sha256(s: String): String =
        Base64.encodeToString(MessageDigest.getInstance("SHA-256").digest(s.toByteArray()), Base64.NO_WRAP)

    fun request(type: String, data: JSONObject? = null, callback: ((JSONObject?) -> Unit)? = null) {
        val id = reqId.getAndIncrement().toString()
        callback?.let { pending[id] = it }
        val d = JSONObject().put("requestType", type).put("requestId", id)
        data?.let { d.put("requestData", it) }
        try {
            client?.send(JSONObject().put("op", 6).put("d", d).toString())
        } catch (e: Exception) {
            pending.remove(id)?.invoke(null)
        }
    }

    // --- Convenience wrappers ---

    fun getSceneList(cb: (current: String, scenes: List<String>) -> Unit) =
        request("GetSceneList") { r ->
            r ?: return@request cb("", emptyList())
            val arr: JSONArray = r.optJSONArray("scenes") ?: JSONArray()
            // OBS returns scenes in reverse display order
            val names = (0 until arr.length()).map { arr.getJSONObject(it).optString("sceneName") }.reversed()
            cb(r.optString("currentProgramSceneName"), names)
        }

    fun setScene(name: String) = request("SetCurrentProgramScene", JSONObject().put("sceneName", name))

    fun triggerTransition() = request("TriggerStudioModeTransition")

    fun toggleStream() = request("ToggleStream")
    fun toggleRecord() = request("ToggleRecord")

    fun disconnect() {
        pending.clear()
        isConnected = false
        try { client?.closeBlocking() } catch (_: Exception) {}
        client = null
    }

    companion object {
        private const val TAG = "OBSWebSocket"

        // Single shared connection used by Deck + Tally.
        @Volatile private var instance: OBSWebSocketManager? = null

        fun get(): OBSWebSocketManager? = instance

        fun connect(host: String, port: Int, password: String?): OBSWebSocketManager {
            instance?.disconnect()
            return OBSWebSocketManager(host, port, password).also { instance = it; it.connect() }
        }

        fun shutdown() {
            instance?.disconnect()
            instance = null
        }
    }
}
