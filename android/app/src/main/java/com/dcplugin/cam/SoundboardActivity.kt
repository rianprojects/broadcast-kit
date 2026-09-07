package com.dcplugin.cam

import android.content.Intent
import android.graphics.Color
import android.os.Bundle
import android.view.Gravity
import android.widget.Button
import android.widget.GridLayout
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.dcplugin.cam.databinding.ActivitySoundboardBinding
import org.json.JSONArray
import org.json.JSONObject

/**
 * Triggers OBS Media Sources via TriggerMediaInputAction (RESTART).
 * Useful for memes, sound effects, intro stingers.
 */
class SoundboardActivity : AppCompatActivity() {

    private lateinit var binding: ActivitySoundboardBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivitySoundboardBinding.inflate(layoutInflater)
        setContentView(binding.root)
        binding.appToolbar.toolbarTitle.text = "Soundboard"
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

        binding.sbRefreshBtn.setOnClickListener { loadMediaSources() }
    }

    override fun onResume() {
        super.onResume()
        loadMediaSources()
    }

    private fun loadMediaSources() {
        val obs = OBSWebSocketManager.get()
        if (obs == null || !obs.isConnected) {
            binding.sbStatusText.text = "OBS not connected. Open OBS Deck and connect first."
            return
        }
        binding.sbStatusText.text = "Fetching media sources from OBS…"
        obs.request("GetInputList", JSONObject().put("inputKind", "ffmpeg_source")) { r ->
            runOnUiThread {
                if (r == null) {
                    binding.sbStatusText.text = "Failed to load sources."
                    return@runOnUiThread
                }
                val inputs: JSONArray = r.optJSONArray("inputs") ?: JSONArray()
                binding.sbGrid.removeAllViews()
                if (inputs.length() == 0) {
                    binding.sbStatusText.text = "No 'Media Source' found in OBS."
                    return@runOnUiThread
                }
                binding.sbStatusText.text = "Found ${inputs.length()} media source(s):"
                val width = resources.displayMetrics.widthPixels / 2 - 32
                for (i in 0 until inputs.length()) {
                    val name = inputs.getJSONObject(i).optString("inputName")
                    val btn = Button(this).apply {
                        text = name
                        isAllCaps = false
                        setBackgroundColor(Color.parseColor("#424242"))
                        setTextColor(Color.WHITE)
                        layoutParams = GridLayout.LayoutParams().apply {
                            this.width = width
                            this.height = 160
                            setGravity(Gravity.FILL)
                        }
                        setOnClickListener {
                            triggerSource(name)
                        }
                    }
                    binding.sbGrid.addView(btn)
                }
            }
        }
    }

    private fun triggerSource(name: String) {
        val obs = OBSWebSocketManager.get() ?: return
        val data = JSONObject()
            .put("inputName", name)
            .put("mediaAction", "OBS_WEBSOCKET_MEDIA_INPUT_ACTION_RESTART")
        obs.request("TriggerMediaInputAction", data) { r ->
            runOnUiThread {
                Toast.makeText(this, "Played: $name", Toast.LENGTH_SHORT).show()
            }
        }
    }

    override fun onSupportNavigateUp(): Boolean {
        finish()
        return true
    }
}
