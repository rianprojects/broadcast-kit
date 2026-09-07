package com.dcplugin.cam

import android.content.Context
import android.graphics.Color
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.view.WindowManager
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.dcplugin.cam.databinding.FragmentTallyBinding

class TallyFragment : Fragment() {

    private var _binding: FragmentTallyBinding? = null
    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?
    ): View {
        _binding = FragmentTallyBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        requireActivity().window.addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON)

        val prefs = requireContext().getSharedPreferences("settings", Context.MODE_PRIVATE)
        binding.tallyHostInput.setText(prefs.getString("obs_host", ""))

        binding.tallyConnectBtn.setOnClickListener {
            val host = binding.tallyHostInput.text.toString().trim()
            val port = binding.tallyPortInput.text.toString().toIntOrNull() ?: 4455
            val pass = prefs.getString("obs_pass", null)?.ifEmpty { null }
            val trackedScene = binding.tallySceneInput.text.toString().trim()
            if (host.isEmpty()) return@setOnClickListener
            prefs.edit().putString("obs_host", host).apply()

            val obs = OBSWebSocketManager.connect(host, port, pass)
            obs.onStatus = { activity?.runOnUiThread { setIdle() } }
            obs.onEvent = { type, data ->
                if (type == "CurrentProgramSceneChanged") {
                    val scene = data.optString("sceneName")
                    activity?.runOnUiThread { setLive(scene, trackedScene) }
                }
            }
        }
        setIdle()
    }

    override fun onDestroyView() {
        requireActivity().window.clearFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON)
        _binding = null
        super.onDestroyView()
    }

    private fun setIdle() {
        binding.tallyColor.setBackgroundColor(Color.parseColor("#616161"))
        binding.tallyLabel.text = "IDLE"
        binding.tallyScene.text = ""
    }

    private fun setLive(scene: String, tracked: String) {
        val isLive = tracked.isEmpty() || scene.equals(tracked, ignoreCase = true)
        binding.tallyColor.setBackgroundColor(
            if (isLive) Color.parseColor("#D32F2F") else Color.parseColor("#388E3C")
        )
        binding.tallyLabel.text = if (isLive) "LIVE" else "STANDBY"
        binding.tallyScene.text = scene
    }
}
