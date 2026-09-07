package com.dcplugin.cam

import android.content.Context
import android.graphics.Color
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.view.Gravity
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.GridLayout
import androidx.fragment.app.Fragment
import com.dcplugin.cam.databinding.FragmentDeckBinding

class DeckFragment : Fragment() {

    private var _binding: FragmentDeckBinding? = null
    private val binding get() = _binding!!
    private val mainHandler = Handler(Looper.getMainLooper())

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?
    ): View {
        _binding = FragmentDeckBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        binding.appToolbar.toolbarTitle.text = "OBS Deck"
        val prefs = requireContext().getSharedPreferences("settings", Context.MODE_PRIVATE)
        binding.obsHostInput.setText(prefs.getString("obs_host", ""))
        binding.obsPasswordInput.setText(prefs.getString("obs_pass", ""))

        binding.obsConnectBtn.setOnClickListener {
            val host = binding.obsHostInput.text.toString().trim()
            val port = binding.obsPortInput.text.toString().toIntOrNull() ?: 4455
            val pass = binding.obsPasswordInput.text.toString().trim().ifEmpty { null }
            if (host.isEmpty()) return@setOnClickListener

            prefs.edit().putString("obs_host", host).putString("obs_pass", pass ?: "").apply()

            val obs = OBSWebSocketManager.connect(host, port, pass)
            obs.onStatus = { s -> activity?.runOnUiThread { _binding?.obsStatusText?.text = s } }
            obs.onEvent = { type, _ ->
                if (type == "CurrentProgramSceneChanged") activity?.runOnUiThread { refreshScenes() }
            }

            mainHandler.postDelayed({ refreshScenes() }, 1500)
        }

        binding.btnToggleStream.setOnClickListener { OBSWebSocketManager.get()?.toggleStream() }
        binding.btnToggleRecord.setOnClickListener { OBSWebSocketManager.get()?.toggleRecord() }
        binding.btnCut.setOnClickListener { OBSWebSocketManager.get()?.triggerTransition() }
    }

    override fun onDestroyView() {
        mainHandler.removeCallbacksAndMessages(null)
        _binding = null
        super.onDestroyView()
    }

    private fun refreshScenes() {
        val obs = OBSWebSocketManager.get() ?: return
        if (!obs.isConnected) return

        obs.getSceneList { current, scenes ->
            activity?.runOnUiThread {
                val b = _binding ?: return@runOnUiThread
                b.sceneGrid.removeAllViews()
                val width = resources.displayMetrics.widthPixels / 2 - 32
                for (scene in scenes) {
                    val btn = Button(requireContext()).apply {
                        text = scene
                        isAllCaps = false
                        val isActive = scene == current
                        setBackgroundColor(if (isActive) Color.parseColor("#4CAF50") else Color.parseColor("#333333"))
                        setTextColor(Color.WHITE)
                        layoutParams = GridLayout.LayoutParams().apply {
                            this.width = width
                            this.height = 160
                            setGravity(Gravity.FILL)
                        }
                        setOnClickListener {
                            obs.setScene(scene)
                            refreshScenes()
                        }
                    }
                    b.sceneGrid.addView(btn)
                }
            }
        }
    }
}
