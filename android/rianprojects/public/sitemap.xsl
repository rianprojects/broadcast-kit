<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
    xmlns:html="http://www.w3.org/TR/REC-html40"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  
  <xsl:template match="/">
    <html xmlns="http://www.w3.org/1999/xhtml" class="dark">
      <head>
        <title>XML Sitemap - Rian Projects</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                            outfit: ['"Outfit"', 'sans-serif'],
                        },
                        colors: {
                            dark: {
                                900: '#0a0a0f',
                                800: '#131318',
                                700: '#1a1a24',
                            }
                        }
                    }
                }
            }
        </script>
        
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&amp;family=Plus+Jakarta+Sans:wght@300;400;500;600;700&amp;display=swap');
            
            body { 
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #0a0a0f; /* Warna dasar dark-900 */
                margin: 0;
            }
            h1 { font-family: 'Outfit', sans-serif; }

            .bg-grid {
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                z-index: -1;
                background-size: 40px 40px;
                background-image: 
                    linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            }

            .glass {
                background: rgba(19, 19, 24, 0.7);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }
        </style>
      </head>
      
      <body class="text-slate-300 min-h-screen p-4 md:p-10 antialiased relative">
        <div class="bg-grid"></div>
        <div class="max-w-6xl mx-auto glass rounded-[2.5rem] shadow-2xl border border-dark-700 overflow-hidden relative">
          <div class="absolute top-0 left-0 w-full h-1"></div>
          <div class="p-8 md:p-10 border-b border-dark-700">
            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight mb-2">Sitemap Index</h1>
            <div class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-dark-900/50 border border-dark-700 rounded-xl text-sm font-medium text-slate-400">
              <i class="fa-solid fa-link text-indigo-500"></i> Total URL Ditemukan:
              <span class="text-indigo-400 font-bold text-base">
                <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/>
              </span>
            </div>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-dark-900/40 text-slate-500 text-[10px] uppercase tracking-[0.2em] border-b border-dark-700">
                  <th class="p-6 font-bold pl-10">Lokasi URL</th>
                  <th class="p-6 font-bold text-center">Prioritas</th>
                  <th class="p-6 font-bold text-center">Frekuensi Update</th>
                  <th class="p-6 font-bold pr-10">Terakhir Diubah</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-dark-700/60">
                
                <xsl:for-each select="sitemap:urlset/sitemap:url">
                  <tr class="hover:bg-dark-700/30 transition-colors group">
                    <td class="p-6 pl-10">
                      <a href="{sitemap:loc}" target="_blank" class="text-sm font-medium text-slate-300 group-hover:text-indigo-400 transition-colors flex items-center gap-3">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs opacity-40 group-hover:opacity-100 transition-opacity"></i>
                        <xsl:value-of select="sitemap:loc"/>
                      </a>
                    </td>
                    <td class="p-6 text-center">
                      <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full text-[10px] font-bold tracking-widest">
                        <xsl:value-of select="sitemap:priority"/>
                      </span>
                    </td>
                    <td class="p-6 text-center">
                      <span class="text-xs font-medium text-slate-400 capitalize">
                        <xsl:value-of select="sitemap:changefreq"/>
                      </span>
                    </td>
                    <td class="p-6 pr-10 text-sm font-bold text-slate-500">
                      <xsl:value-of select="substring(sitemap:lastmod, 0, 11)"/>
                    </td>
                  </tr>
                </xsl:for-each>
                
              </tbody>
            </table>
          </div>
          
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>