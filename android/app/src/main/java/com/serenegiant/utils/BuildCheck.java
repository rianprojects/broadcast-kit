package com.serenegiant.utils;

import android.os.Build;

/** Minimal replacement for saki4510t/libcommon's BuildCheck (only the SDK checks UVCCamera needs). */
public final class BuildCheck {
    private BuildCheck() {}

    public static boolean isLollipop() {
        return Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP;
    }

    public static boolean isAndroid5() {
        return isLollipop();
    }

    public static boolean isMarshmallow() {
        return Build.VERSION.SDK_INT >= Build.VERSION_CODES.M;
    }
}
