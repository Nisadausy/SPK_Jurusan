<footer class="footer text-white pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">

            {{-- KOLOM 1 --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center font-bold text-sm">S2J</div>
                    <div>
                        <div class="font-bold text-sm">SMK Negeri 2 Jember</div>
                        <div class="text-blue-300 text-xs">Est. 1970</div>
                    </div>
                </div>
                <p class="text-blue-200 text-xs leading-relaxed mb-4">
                    Mencetak generasi kompeten, berkarakter, dan siap bersaing di era industri 4.0.
                </p>
                <div class="flex gap-3">
                    @foreach(['f','t','ig','yt'] as $s)
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-xs font-bold transition-colors">
                            {{ strtoupper($s) }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- KOLOM 2 --}}
            <div>
                <h4 class="font-bold text-sm mb-4 text-amber-300">Tentang SMKN 2</h4>
                <ul class="space-y-2 text-xs text-blue-200">
                    @foreach(['Profil Sekolah', 'Visi & Misi', 'Struktur Organisasi', 'Tenaga Pendidik', 'Fasilitas Sekolah', 'Prestasi'] as $link)
                        <li><a href="#" class="hover:text-white transition-colors">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- KOLOM 3 --}}
            <div>
                <h4 class="font-bold text-sm mb-4 text-amber-300">Link Tautkan Kami</h4>
                <ul class="space-y-2 text-xs text-blue-200">
                    @foreach(['Dinas Pendidikan Jatim', 'Kemendikbud RI', 'PPDB Online Jatim', 'LTMPT / SNBT', 'Bursa Kerja Khusus'] as $link)
                        <li><a href="#" class="hover:text-white transition-colors">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- KOLOM 4 --}}
            <div>
                <h4 class="font-bold text-sm mb-4 text-amber-300">Informasi Kontak</h4>
                <ul class="space-y-3 text-xs text-blue-200">
                    <li class="flex gap-2"><span>📍</span><span>Jl. Tawangmangu No. 52, Jember, Jawa Timur 68121</span></li>
                    <li class="flex gap-2"><span>📞</span><span>(0331) 487550</span></li>
                    <li class="flex gap-2"><span>✉️</span><span>smkn2jember@gmail.com</span></li>
                    <li class="flex gap-2"><span>🌐</span><span>www.smkn2jember.sch.id</span></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-white/10 pt-5 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-blue-300">
            <span>© {{ date('Y') }} SMK Negeri 2 Jember. All Rights Reserved.</span>
            <span>Powered by <a href="#" class="text-amber-300 hover:underline">Sistem SPK Pemilihan Jurusan</a></span>
        </div>
    </div>
</footer>
