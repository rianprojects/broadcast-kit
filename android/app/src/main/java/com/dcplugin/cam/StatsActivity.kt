package com.dcplugin.cam

import android.content.Intent
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import androidx.appcompat.app.AppCompatActivity
import com.dcplugin.cam.databinding.ActivityStatsBinding

/**
 * Polls OBS every 2s for GetStats + GetStreamStatus + GetRecordStatus.
 * Reuses the shared OBSWebSocketManager connection.
 */
class StatsActivity : AppCompatActivity() {

    private lateinit var binding: ActivityStatsBinding
    private val handler = Handler(Looper.getMainLooper())
    private var polling = false

    private val pollRunnable = object : Runnable {
        override fun run() {
            fetchStats()
            fetchStreamStatus()
            fetchRecordStatus()
            if (polling) handler.postDelayed(this, 2000)
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityStatsBinding.inflate(layoutInflater)
        setContentView(binding.root)
        binding.appToolbar.toolbarTitle.text = "Stream Stats"
        binding.appToolbar.toolbarBack.visibility = android.view.View.VISIBLE
        binding.appToolbar.toolbarBack.setOnClickListener { finish() }

        binding.bottomNav.root.selectedItemId = R.id.nav_more
        binding.bottomNav.root.setOnItemSelectedListener { item ->
            if (item.itemId == R.id.nav_more) {
                finish()
            } else {
                startActivity(Intent(this, MainActivity::class.java).putExtra(MainActivity.EXTRA_TAB, item.itemId))
                finish()
            }
            true
        }
    }

    override fun onResume() {
        super.onResume()
        val obs = OBSWebSocketManager.get()
        if (obs == null || !obs.isConnected) {
            binding.statsConnText.text = "Not connected. Open OBS Deck and connect first."
            return
        }
        binding.statsConnText.text = "Connected"
        polling = true
        handler.post(pollRunnable)
    }

    override fun onPause() {
        super.onPause()
        polling = false
        handler.removeCallbacks(pollRunnable)
    }

    private fun fetchStats() {
        OBSWebSocketManager.get()?.request("GetStats") { r ->
            r ?: return@request
            runOnUiThread {
                binding.cpuText.text = String.format("%.1f%%", r.optDouble("cpuUsage", 0.0))
                binding.fpsText.text = String.format("%.1f", r.optDouble("activeFps", 0.0))
            }
        }
    }

    private fun fetchStreamStatus() {
        OBSWebSocketManager.get()?.request("GetStreamStatus") { r ->
            runOnUiThread {
                if (r == null) {
                    binding.streamStatusText.text = "Stream Status: OFFLINE"
                    binding.bitrateText.text = "0 kbps"
                    binding.droppedText.text = "0"
                    return@runOnUiThread
                }
                val active = r.optBoolean("outputActive", false)
                val timecode = r.optString("outputTimecode", "00:00:00")
                val kbps = r.optDouble("outputBytes", 0.0).toLong() / 1024 // rough
                val dropped = r.optInt("outputSkippedFrames", 0)
                val total = r.optInt("outputTotalFrames", 1).coerceAtLeast(1)
                val dropPct = (dropped * 100.0 / total)

                binding.streamStatusText.text = if (active) "LIVE — $timecode" else "Stream Status: OFFLINE"
                binding.bitrateText.text = "${kbps} kbps"
                binding.droppedText.text = "$dropped (${String.format("%.1f", dropPct)}%)"
            }
        }
    }

    private fun fetchRecordStatus() {
        OBSWebSocketManager.get()?.request("GetRecordStatus") { r ->
            runOnUiThread {
                if (r == null) {
                    binding.recordStatusText.text = "Record Status: OFFLINE"
                    return@runOnUiThread
                }
                val active = r.optBoolean("outputActive", false)
                val timecode = r.optString("outputTimecode", "00:00:00")
                binding.recordStatusText.text = if (active) "⏺ Recording — $timecode" else "Record Status: IDLE"
            }
        }
    }

    override fun onSupportNavigateUp(): Boolean {
        finish()
        return true
    }
}
