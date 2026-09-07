package com.dcplugin.cam

import android.content.Intent
import android.graphics.Color
import android.graphics.drawable.GradientDrawable
import android.os.Bundle
import android.view.Gravity
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.LinearLayout
import android.widget.GridLayout
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import com.dcplugin.cam.databinding.FragmentMoreBinding

class MoreFragment : Fragment() {

    private var _binding: FragmentMoreBinding? = null
    private val binding get() = _binding!!

    data class Module(val name: String, val icon: Int, val badge: String, val target: Class<*>?)

    private val modules = listOf(
        Module("Wireless Mic", R.drawable.ic_mod_mic, "SOON", null),
        Module("Teleprompter", R.drawable.ic_mod_doc, "SOON", null),
        Module("Chat Reader", R.drawable.ic_mod_chat, "SOON", null),
        Module("OBS Monitor", R.drawable.ic_mod_tv, "SOON", null),
        Module("Timer / Countdown", R.drawable.ic_mod_clock, "READY", TimerActivity::class.java),
        Module("Soundboard", R.drawable.ic_mod_speaker, "READY", SoundboardActivity::class.java),
        Module("Stream Stats", R.drawable.ic_mod_chart, "READY", StatsActivity::class.java),
        Module("Media Controller", R.drawable.ic_mod_music, "SOON", null),
        Module("Show Rundown", R.drawable.ic_mod_list, "SOON", null),
        Module("Connection Hub", R.drawable.ic_mod_wifi, "SOON", null)
    )

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?
    ): View {
        _binding = FragmentMoreBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        binding.appToolbar.toolbarTitle.text = "More"
        val width = resources.displayMetrics.widthPixels / 2 - 32
        for (m in modules) {
            val ready = m.badge == "READY"
            val card = LinearLayout(requireContext()).apply {
                orientation = LinearLayout.VERTICAL
                gravity = Gravity.CENTER_HORIZONTAL
                setPadding(16, 20, 16, 16)
                background = GradientDrawable().apply {
                    cornerRadius = 16f
                    setColor(Color.parseColor(if (ready) "#2E4E32" else "#262626"))
                }
                layoutParams = GridLayout.LayoutParams().apply {
                    this.width = width
                    this.height = 180
                    setGravity(Gravity.FILL)
                }
                setOnClickListener {
                    if (m.target != null) {
                        startActivity(Intent(requireContext(), m.target))
                    } else {
                        Toast.makeText(requireContext(), "${m.name} is coming in next release!", Toast.LENGTH_SHORT).show()
                    }
                }
            }
            card.addView(ImageView(requireContext()).apply {
                setImageResource(m.icon)
                layoutParams = LinearLayout.LayoutParams(84, 84).apply { bottomMargin = 12 }
            })
            card.addView(TextView(requireContext()).apply {
                text = m.name
                textSize = 13f
                setTextColor(Color.WHITE)
                gravity = Gravity.CENTER
            })
            card.addView(TextView(requireContext()).apply {
                text = m.badge
                textSize = 10f
                setTextColor(if (ready) Color.parseColor("#8BC48F") else Color.parseColor("#8A9099"))
                gravity = Gravity.CENTER
                setPadding(0, 6, 0, 0)
            })
            binding.moduleGrid.addView(card)
        }
    }

    override fun onDestroyView() {
        _binding = null
        super.onDestroyView()
    }
}
