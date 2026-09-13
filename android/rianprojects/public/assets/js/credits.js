(function() {
    
    const art = [
        "       _                               _           _           ",
        "      (_)                             (_)         | |          ",
        "  _ __ _  __ _ _ __  _ __  _ __ ___  _  ___  ___| |_ ___ ___ ",
        " | '__| |/ _` | '_ \\| '_ \\| '__/ _ \\| |/ _ \\/ __| __/ __/ __|",
        " | |  | | (_| | | | | |_) | | | (_) | |  __/ (__| || (__\\__ \\",
        " |_|  |_|\\__,_|_| |_| .__/|_|  \\___/| |\\___|\\___|\\__\\___|___/",
        "                    | |            _/ |                      ",
        "                    |_|           |__/                       "
    ].join('\n');

    const styleLogo = "color: #00ffcc; font-family: monospace; font-weight: bold; line-height: 1.2;";
    const styleHeader = "color: #ffffff; background: #333; padding: 4px 10px; border-radius: 3px; font-weight: bold;";
    const styleText = "color: #00d4ff; font-weight: bold;";
    const styleWarning = "color: #ff4747; background: #1a1a1a; padding: 2px; border: 1px solid #ff4747;";
    
    console.log("%c" + art, styleLogo);
    console.log("%c INFO PROJECT ", styleHeader);
    console.log("%c👤 Dibuat oleh      : Rian Projects", styleText);
    console.log("%c📧 Lapor Bug/Celah  : rianprojects.id@gmail.com", styleText);
    console.log("\n%c ⚠️ PERINGATAN: Beraktivitas di console tanpa pengetahuan dapat merusak akun/keamanan Anda. ", styleWarning);
})();