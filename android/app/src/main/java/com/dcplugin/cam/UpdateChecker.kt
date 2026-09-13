package com.dcplugin.cam

import android.app.Activity
import android.app.AlertDialog
import android.content.Intent
import android.net.Uri
import org.json.JSONObject
import java.net.HttpURLConnection
import java.net.URL

/** Checks GitHub Releases for a newer version and shows a force-update dialog if found. */
object UpdateChecker {

    private const val API_URL = "https://domain-kamu.com/api/version"

    fun check(activity: Activity, currentVersion: String) {
        Thread {
            val result = runCatching {
                val conn = URL(API_URL).openConnection() as HttpURLConnection
                conn.connectTimeout = 5000
                conn.readTimeout = 5000
                val body = conn.inputStream.bufferedReader().use { it.readText() }
                JSONObject(body)
            }.getOrNull() ?: return@Thread

            val latestVersion = result.optString("latest_version")
            val apkUrl = result.optString("apk_url")
            val forceUpdate = result.optBoolean("force_update", false)
            if (latestVersion.isBlank() || latestVersion == currentVersion) return@Thread

            activity.runOnUiThread {
                if (!activity.isFinishing) showDialog(activity, latestVersion, apkUrl, forceUpdate)
            }
        }.start()
    }

    private fun showDialog(activity: Activity, latestVersion: String, url: String, force: Boolean) {
        val builder = AlertDialog.Builder(activity)
            .setTitle("Update tersedia")
            .setMessage("Versi terbaru ($latestVersion) sudah tersedia.")
            .setCancelable(false)
            .setPositiveButton("Update") { _, _ ->
                activity.startActivity(Intent(Intent.ACTION_VIEW, Uri.parse(url)))
                if (force) activity.finishAffinity()
            }
        if (force) {
            builder.setNegativeButton("Keluar") { _, _ -> activity.finishAffinity() }
        } else {
            builder.setNegativeButton("Nanti", null)
        }
        builder.show()
    }
}
