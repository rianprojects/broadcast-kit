package com.dcplugin.cam

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.dcplugin.cam.databinding.ActivityMainBinding

/** Single-Activity shell: fixed bottom nav + swappable fragment content. */
class MainActivity : AppCompatActivity() {

    private lateinit var binding: ActivityMainBinding

    private val cameraFragment by lazy { CameraFragment() }
    private val deckFragment by lazy { DeckFragment() }
    private val tallyFragment by lazy { TallyFragment() }
    private val moreFragment by lazy { MoreFragment() }
    private var active: Fragment? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)

        // Night-mode toggle recreates this Activity; FragmentManager then restores the
        // old fragment instances from savedInstanceState, but the `by lazy` fields above
        // create fresh ones unaware of them — leading to duplicate/overlapping fragments
        // (visible as flicker) on the next nav click. Drop the restored ones so only the
        // freshly created lazy instances are ever added.
        if (savedInstanceState != null) {
            val tx = supportFragmentManager.beginTransaction()
            supportFragmentManager.fragments.forEach { tx.remove(it) }
            tx.commitNow()
        }

        binding.bottomNav.root.setOnItemSelectedListener { item ->
            val target = when (item.itemId) {
                R.id.nav_camera -> cameraFragment
                R.id.nav_deck -> deckFragment
                R.id.nav_tally -> tallyFragment
                R.id.nav_more -> moreFragment
                else -> return@setOnItemSelectedListener false
            }
            showFragment(target)
            true
        }

        val tab = if (savedInstanceState == null) {
            intent.getIntExtra(EXTRA_TAB, R.id.nav_camera)
        } else {
            binding.bottomNav.root.selectedItemId
        }
        binding.bottomNav.root.selectedItemId = tab
        showFragment(
            when (tab) {
                R.id.nav_deck -> deckFragment
                R.id.nav_tally -> tallyFragment
                R.id.nav_more -> moreFragment
                else -> cameraFragment
            }
        )
    }

    companion object {
        const val EXTRA_TAB = "extra_tab"
    }

    private fun showFragment(fragment: Fragment) {
        if (active === fragment) return
        val fm = supportFragmentManager
        val tx = fm.beginTransaction()
        if (!fragment.isAdded) {
            tx.add(R.id.fragment_container, fragment)
        }
        fm.fragments.forEach { if (it !== fragment) tx.hide(it) }
        tx.show(fragment)
        tx.commit()
        active = fragment
    }
}
