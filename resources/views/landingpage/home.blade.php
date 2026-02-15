<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Pemilihan Jurusan - SMK Negeri 2 Jember</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a3c6e;
            --primary-dark: #0f2548;
            --accent: #e8a020;
            --accent-light: #f5c55a;
            --bg-light: #f0f4fa;
            --text-dark: #1e2a3a;
            --text-muted: #6b7a8d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4fa;
            color: var(--text-dark);
        }

        /* NAV */
        .navbar-brand { font-family: 'Poppins', sans-serif; }

        /* TOP BAR */
        .top-bar {
            background: var(--primary-dark);
            font-size: 0.72rem;
        }

        /* HEADER */
        .main-header {
            background: var(--primary);
        }

        /* HERO */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, #2a5298 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-badge {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
        }
        .hero-cta-primary {
            background: var(--accent);
            color: var(--primary-dark);
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .hero-cta-primary:hover {
            background: var(--accent-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(232,160,32,0.4);
        }
        .hero-cta-secondary {
            border: 2px solid rgba(255,255,255,0.7);
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .hero-cta-secondary:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        /* STATS */
        .stat-card {
            background: white;
            border-left: 4px solid var(--accent);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(26, 60, 110, 0.12);
        }

        /* JURUSAN CARDS */
        .jurusan-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            border-top: 4px solid transparent;
        }
        .jurusan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(26, 60, 110, 0.15);
            border-top-color: var(--accent);
        }
        .jurusan-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }

        /* ARTIKEL CARDS */
        .artikel-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .artikel-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(26, 60, 110, 0.12);
        }
        .artikel-img {
            height: 170px;
            object-fit: cover;
            width: 100%;
            background: linear-gradient(135deg, #1a3c6e, #2a5298);
        }
        .artikel-badge {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* INFO KEGIATAN */
        .kegiatan-item {
            border-left: 3px solid var(--accent);
            background: white;
            transition: all 0.2s ease;
        }
        .kegiatan-item:hover {
            border-left-color: var(--primary);
            background: #f8fbff;
        }

        /* SECTION HEADINGS */
        .section-heading {
            position: relative;
            display: inline-block;
        }
        .section-heading::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--accent);
            border-radius: 2px;
        }

        /* NAV LINKS */
        .nav-link-custom {
            color: rgba(255,255,255,0.85);
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        /* FOOTER */
        .footer {
            background: var(--primary-dark);
        }
        .footer-logo-bg {
            background: rgba(255,255,255,0.1);
        }

        /* MOBILE NAV */
        #mobile-menu { display: none; }
        #mobile-menu.open { display: block; }

        /* CAROUSEL */
        .carousel-container {
            overflow: hidden;
            position: relative;
        }
        .carousel-slide {
            display: none;
        }
        .carousel-slide.active {
            display: block;
        }
        .carousel-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            cursor: pointer;
            transition: all 0.2s;
        }
        .carousel-dot.active {
            background: var(--accent);
            width: 28px;
            border-radius: 5px;
        }

        /* SCROLL ANIMATIONS */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    {{-- ===== TOP INFO BAR ===== --}}
    <div class="top-bar text-white py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex flex-wrap items-center gap-4 text-xs text-blue-200">
                <span>📞 (0331) 487550</span>
                <span class="hidden sm:inline">✉️ smkn2jember@gmail.com</span>
                <span class="hidden md:inline">📍 Jl. Tawangmangu No. 52, Jember</span>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-xs text-blue-200 hover:text-white">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-xs text-blue-200 hover:text-white">Login</a>
                    <a href="{{ route('register') }}" class="text-xs bg-amber-400 text-gray-900 font-semibold px-3 py-1 rounded hover:bg-amber-300 transition-colors">Daftar</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- ===== MAIN HEADER ===== --}}
    <header class="main-header text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                {{-- LOGO + NAMA --}}
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-md overflow-hidden flex-shrink-0">
                        {{-- Ganti src dengan path logo sekolah --}}
                        <span class="text-blue-900 font-bold text-lg">S2J</span>
                    </div>
                    <div>
                        <div class="font-bold text-sm sm:text-base leading-tight">SMK NEGERI 2 JEMBER</div>
                        <div class="text-blue-200 text-xs">Sistem Pendukung Keputusan Pemilihan Jurusan</div>
                    </div>
                </div>

                {{-- DESKTOP NAV --}}
<nav class="hidden md:flex items-center gap-1">
    <a href="{{ url('/') }}" class="nav-link-custom active">Beranda</a>
    <a href="#profil" class="nav-link-custom">Profil</a>

    <div class="relative group">
        <button class="nav-link-custom flex items-center gap-1">
            SPK Jurusan
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div class="absolute top-full left-0 w-52 bg-white text-gray-800 rounded-lg shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 text-xs">
            <a href="#jurusan" class="block px-4 py-2 hover:bg-blue-50">Cek Jurusan</a>
            <a href="#jurusan" class="block px-4 py-2 hover:bg-blue-50">History</a>     
        </div>
    </div>
    <a href="#artikel" class="nav-link-custom">Artikel</a>
    <a href="#kontak" class="nav-link-custom">Kontak</a>

    @auth
        <a href="{{ url('/dashboard') }}"
           class="ml-2 px-4 py-1.5 bg-amber-400 text-gray-900 font-semibold text-xs rounded-lg hover:bg-amber-300 transition-colors">
            Dashboard
        </a>

        <form method="POST" action="{{ route('logout') }}" class="ml-2 inline">
            @csrf
            <button type="submit"
                    class="px-4 py-1.5 bg-white/10 text-white font-semibold text-xs rounded-lg hover:bg-white/20 transition-colors">
                Logout
            </button>
        </form>
    @else
        <a href="{{ route('register') }}"
           class="ml-2 px-4 py-1.5 bg-amber-400 text-gray-900 font-semibold text-xs rounded-lg hover:bg-amber-300 transition-colors">
            Mulai SPK
        </a>
    @endauth
</nav>


                {{-- HAMBURGER --}}
                <button id="hamburger" class="md:hidden p-2 rounded-lg hover:bg-white/10 transition-colors" onclick="toggleMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- MOBILE NAV --}}
            <div id="mobile-menu" class="md:hidden mt-3 pb-2 border-t border-white/20">
                <div class="flex flex-col gap-1 pt-3">
                    <a href="{{ url('/') }}" class="nav-link-custom">Beranda</a>
                    <a href="#profil" class="nav-link-custom">Profil</a>
                    <a href="#spk" class="nav-link-custom">SPK Jurusan</a>
                    <a href="#artikel" class="nav-link-custom">Artikel</a>
                    <a href="#kontak" class="nav-link-custom">Kontak</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="mt-1 px-4 py-2 bg-amber-400 text-gray-900 font-semibold text-sm rounded-lg text-center">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="mt-1 px-4 py-2 bg-white/10 text-white text-sm rounded-lg text-center">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-amber-400 text-gray-900 font-semibold text-sm rounded-lg text-center">Daftar & Mulai SPK</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- ===== HERO / CAROUSEL SECTION ===== --}}
    <section class="hero-section">
        <div class="carousel-container">

            {{-- SLIDE 1 - PPDB / SPK --}}
            <div class="carousel-slide active">
                <div class="max-w-7xl mx-auto px-6 py-14 md:py-20 flex flex-col md:flex-row items-center gap-10 relative z-10">
                    <div class="flex-1 text-white">
                        <div class="hero-badge inline-flex items-center gap-2 text-xs font-semibold text-amber-300 px-4 py-1.5 rounded-full mb-5">
                            🎓 Tahun Ajaran 2025/2026
                        </div>
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">
                            Temukan Jurusan<br>
                            <span class="text-amber-300">Terbaik Untukmu</span>
                        </h1>
                        <p class="text-blue-100 text-sm md:text-base leading-relaxed mb-7 max-w-lg">
                            Gunakan Sistem Pendukung Keputusan berbasis <strong class="text-white">Metode SAW </strong> untuk menemukan jurusan yang paling sesuai dengan minat, bakat, dan kemampuan kamu di SMK Negeri 2 Jember.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="hero-cta-primary px-7 py-3 rounded-xl text-sm inline-block">
                                    Mulai Seleksi Jurusan →
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="hero-cta-primary px-7 py-3 rounded-xl text-sm inline-block">
                                    Mulai Seleksi Jurusan →
                                </a>
                                <a href="#spk" class="hero-cta-secondary px-7 py-3 rounded-xl text-sm inline-block">
                                    Pelajari Lebih Lanjut
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="flex-shrink-0 hidden md:block">
                        <div class="relative w-72 h-64 rounded-2xl overflow-hidden shadow-2xl bg-blue-800/50 backdrop-blur flex items-center justify-center border border-white/20">
                            <div class="text-center text-white">
                                <div class="text-6xl mb-3">🏫</div>
                                <div class="font-bold text-sm">SMK Negeri 2 Jember</div>
                                <div class="text-xs text-blue-200 mt-1">Berprestasi & Berkarakter</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SLIDE 2 --}}
            <div class="carousel-slide">
                <div class="max-w-7xl mx-auto px-6 py-14 md:py-20 flex flex-col md:flex-row items-center gap-10 relative z-10">
                    <div class="flex-1 text-white">
                        <div class="hero-badge inline-flex items-center gap-2 text-xs font-semibold text-amber-300 px-4 py-1.5 rounded-full mb-5">
                            🏆 Program Unggulan
                        </div>
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">
                            12 Program Keahlian<br>
                            <span class="text-amber-300">Siap Masa Depan</span>
                        </h1>
                        <p class="text-blue-100 text-sm md:text-base leading-relaxed mb-7 max-w-lg">
                            Pilih dari TKJ, DKV, TKR, TSM, TITL, Dan Masih Banyak Lainnya. Semua dirancang untuk mencetak lulusan kompeten dan siap kerja.
                        </p>
                        <a href="#jurusan" class="hero-cta-primary px-7 py-3 rounded-xl text-sm inline-block">
                            Lihat Semua Jurusan →
                        </a>
                    </div>
                    <div class="flex-shrink-0 hidden md:block">
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([['💻','TKJ'],['🚗','TKR'],['🎨','DKV'],['📊','AKT']] as $j)
                            <div class="bg-white/10 backdrop-blur border border-white/20 rounded-xl p-4 text-center text-white">
                                <div class="text-3xl mb-1">{{ $j[0] }}</div>
                                <div class="text-xs font-semibold">{{ $j[1] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- SLIDE 3 --}}
            <div class="carousel-slide">
                <div class="max-w-7xl mx-auto px-6 py-14 md:py-20 text-center relative z-10">
                    <div class="hero-badge inline-flex items-center gap-2 text-xs font-semibold text-amber-300 px-4 py-1.5 rounded-full mb-5 mx-auto">
                        📅  Sistem Rekomendasi Jurusan
                    </div>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4">
                        SMK Negeri 2 Jember<br>
                        <span class="text-amber-300">TA 2026/2027</span>
                    </h1>
                    <p class="text-blue-100 text-sm md:text-base mb-8 max-w-2xl mx-auto">
                        Cek Jurusanmu sekarang dan gunakan fitur SPK kami untuk mendapatkan rekomendasi jurusan terbaik sesuai dengan profil belajarmu.
                    </p>
                    <a href="{{ route('register') }}" class="hero-cta-primary px-8 py-3.5 rounded-xl text-sm inline-block font-bold">
                        Registrasi Sekarang !
                    </a>
                </div>
            </div>

        </div>

        {{-- Carousel Controls --}}
        <div class="flex justify-center gap-2 pb-6 pt-2 relative z-10">
            <button class="carousel-dot active" onclick="goToSlide(0)"></button>
            <button class="carousel-dot" onclick="goToSlide(1)"></button>
            <button class="carousel-dot" onclick="goToSlide(2)"></button>
        </div>
    </section>

    {{-- ===== STATS ROW ===== --}}
    <section class="bg-white shadow-md py-0">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100">
                @foreach([
                    ['1.200+', 'Siswa Aktif', '👨‍🎓'],
                    ['12', 'Program Keahlian', '📚'],
                    ['85+', 'Tenaga Pengajar', '👨‍🏫'],
                    ['95%', 'Tingkat Kelulusan', '🏆']
                ] as $stat)
                <div class="py-5 px-6 text-center group cursor-default">
                    <div class="text-2xl mb-1">{{ $stat[2] }}</div>
                    <div class="text-2xl font-extrabold text-blue-900 leading-tight">{{ $stat[0] }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">{{ $stat[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== SAMBUTAN + SPK INFO ===== --}}
    <section id="profil" class="py-14 px-4">
        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-8">

            {{-- SAMBUTAN --}}
            <div class="fade-in">
                <div class="bg-white rounded-2xl p-6 shadow-sm h-full border-b-4 border-blue-700">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-xl">🎙️</div>
                        <h2 class="font-bold text-gray-800 text-sm">Sambutan Kepala Sekolah</h2>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-3xl mx-auto mb-3">👨‍💼</div>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Selamat datang di portal resmi SMK Negeri 2 Jember. Kami berkomitmen mencetak lulusan yang kompeten, berkarakter, dan siap bersaing di era industri 4.0. Gunakan fitur SPK kami untuk memilih jurusan terbaik bagi masa depan Anda.
                    </p>
                    <div class="mt-4 pt-4 border-t text-xs text-gray-500">
                        <div class="font-semibold text-gray-700">Drs. H. Ahmad Syaifullah, M.Pd</div>
                        <div>Kepala SMK Negeri 2 Jember</div>
                    </div>
                </div>
            </div>

            {{-- TENTANG SPK --}}
            <div class="fade-in" style="transition-delay: 0.1s">
                <div class="bg-white rounded-2xl p-6 shadow-sm h-full border-b-4 border-amber-400" id="spk">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-xl">🧠</div>
                        <h2 class="font-bold text-gray-800 text-sm">Tentang Sistem SPK</h2>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed mb-3">
                        Sistem Pendukung Keputusan (SPK) ini dirancang untuk membantu siswa memilih jurusan yang paling sesuai berdasarkan:
                    </p>
                    <ul class="space-y-2 text-xs text-gray-600">
                        @foreach(['Nilai akademik & rapor', 'Tes minat & bakat', 'Kemampuan ekonomi', 'Preferensi karir'] as $item)
                        <li class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="mt-5 block w-full text-center bg-amber-400 hover:bg-amber-300 text-gray-900 font-semibold text-xs py-2.5 rounded-xl transition-colors">
                        Coba Sekarang →
                    </a>
                </div>
            </div>

            {{-- INFO KEGIATAN --}}
            <div class="fade-in" style="transition-delay: 0.2s">
                <div class="bg-white rounded-2xl p-6 shadow-sm h-full">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-xl">📅</div>
                            <h2 class="font-bold text-gray-800 text-sm">Info Kegiatan</h2>
                        </div>
                        <a href="#" class="text-xs text-blue-600 hover:underline">Semua</a>
                    </div>
                    <div class="space-y-3">
                        @foreach([
                            ['Apel Pagi HUT Pramuka ke-63', 'Agustus 2025', 'Ekstrakurikuler'],
                            ['Pameran Produk Inovasi Siswa', '13 Agustus 2025', 'Akademik'],
                            ['Ujian Tengah Semester Ganjil', 'Oktober 2025', 'Ujian'],
                            ['Workshop Industri 4.0', 'November 2025', 'Seminar'],
                        ] as $keg)
                        <div class="kegiatan-item rounded-r-xl pl-3 pr-3 py-2.5">
                            <div class="font-semibold text-xs text-gray-800 leading-tight">{{ $keg[0] }}</div>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs text-gray-400">{{ $keg[1] }}</span>
                                <span class="text-xs bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full font-medium">{{ $keg[2] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== PROGRAM KEAHLIAN ===== --}}
    <section id="jurusan" class="py-14 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-10 fade-in">
                <p class="text-amber-500 font-semibold text-sm mb-1">Program Unggulan</p>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 section-heading mx-auto">Program Keahlian</h2>
                <p class="text-gray-500 text-sm mt-6 max-w-xl mx-auto">Pilih jurusan yang sesuai dengan passion dan tujuan karir Anda bersama SMK Negeri 2 Jember.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                @php
                    $jurusans = [
                        ['💻', 'TKJ', 'Teknik Komputer & Jaringan', 'Instalasi & konfigurasi jaringan komputer, troubleshooting sistem.', 'bg-blue-100 text-blue-600'],
                        ['🖥️', 'RPL', 'Rekayasa Perangkat Lunak', 'Pemrograman web, mobile, dan pengembangan software profesional.', 'bg-purple-100 text-purple-600'],
                        ['🎨', 'MM', 'Multimedia', 'Desain grafis, video editing, animasi, dan produksi konten digital.', 'bg-pink-100 text-pink-600'],
                        ['📊', 'AKT', 'Akuntansi & Keuangan', 'Pembukuan, laporan keuangan, perpajakan, dan manajemen bisnis.', 'bg-green-100 text-green-600'],
                        ['🗂️', 'OTKP', 'Otomatisasi & Tata Kelola', 'Manajemen perkantoran, administrasi bisnis, dan sekretaris.', 'bg-yellow-100 text-yellow-600'],
                        ['🛒', 'BDP', 'Bisnis Daring & Pemasaran', 'E-commerce, digital marketing, manajemen toko dan distribusi.', 'bg-orange-100 text-orange-600'],
                    ];
                @endphp
                @foreach($jurusans as $j)
                <div class="jurusan-card shadow-sm fade-in p-5">
                    <div class="jurusan-icon {{ $j[4] }} mb-4">{{ $j[0] }}</div>
                    <div class="text-xs font-bold text-gray-400 mb-1">{{ $j[1] }}</div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base leading-tight mb-2">{{ $j[2] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4">{{ $j[3] }}</p>
                    <a href="#spk" class="text-xs text-blue-700 font-semibold hover:underline">Lihat Detail →</a>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block bg-blue-800 hover:bg-blue-900 text-white font-bold px-8 py-3 rounded-xl text-sm transition-colors shadow-md">
                        Mulai Seleksi Jurusan dengan SPK →
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-blue-800 hover:bg-blue-900 text-white font-bold px-8 py-3 rounded-xl text-sm transition-colors shadow-md">
                        Mulai Seleksi Jurusan dengan SPK →
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ===== ARTIKEL TERBARU ===== --}}
    <section id="artikel" class="py-14 px-4 bg-blue-50">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div class="fade-in">
                    <p class="text-amber-500 font-semibold text-sm mb-1">Blog & Informasi</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Artikel Terbaru</h2>
                    <p class="text-gray-500 text-xs mt-1">Update informasi, berita sekolah, dan tips memilih jurusan</p>
                </div>
                <a href="#" class="text-sm text-blue-700 font-semibold hover:underline whitespace-nowrap fade-in">Lihat Semua →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $artikels = [
                        [
                            'bg' => 'from-blue-700 to-blue-900',
                            'badge' => 'Prestasi',
                            'badge_color' => 'bg-green-100 text-green-700',
                            'judul' => 'SMK N 2 Jember Raih Juara 1 LKS Tingkat Provinsi Jawa Timur',
                            'ringkasan' => 'Siswa jurusan TKJ berhasil meraih juara pertama dalam Lomba Kompetensi Siswa bidang Networking Support.',
                            'tanggal' => '10 Feb 2025',
                            'penulis' => 'Humas SMKN2'
                        ],
                        [
                            'bg' => 'from-purple-700 to-purple-900',
                            'badge' => 'Akademik',
                            'badge_color' => 'bg-purple-100 text-purple-700',
                            'judul' => 'Cara Memilih Jurusan SMK yang Tepat Sesuai Minat dan Bakat',
                            'ringkasan' => 'Tips dan panduan lengkap untuk siswa kelas 9 SMP dalam menentukan pilihan jurusan di SMK secara tepat.',
                            'tanggal' => '05 Feb 2025',
                            'penulis' => 'Tim Konseling'
                        ],
                        [
                            'bg' => 'from-pink-700 to-rose-900',
                            'badge' => 'Kegiatan',
                            'badge_color' => 'bg-amber-100 text-amber-700',
                            'judul' => 'Pembukaan Kelas Industri Bersama PT. Telkom Indonesia',
                            'ringkasan' => 'SMK Negeri 2 Jember resmi membuka kelas industri bekerja sama dengan PT. Telkom untuk jurusan TKJ dan RPL.',
                            'tanggal' => '01 Feb 2025',
                            'penulis' => 'Tim Humas'
                        ],
                        [
                            'bg' => 'from-green-700 to-teal-900',
                            'badge' => 'Informasi',
                            'badge_color' => 'bg-blue-100 text-blue-700',
                            'judul' => 'Pendaftaran PPDB Online 2025/2026 Sudah Dibuka',
                            'ringkasan' => 'Penerimaan Peserta Didik Baru tahun ajaran 2025/2026 resmi dibuka. Daftar sekarang dan gunakan fitur SPK kami.',
                            'tanggal' => '28 Jan 2025',
                            'penulis' => 'Admin PPDB'
                        ],
                        [
                            'bg' => 'from-orange-600 to-amber-800',
                            'badge' => 'Workshop',
                            'badge_color' => 'bg-orange-100 text-orange-700',
                            'judul' => 'Workshop Desain UI/UX untuk Siswa Multimedia dan RPL',
                            'ringkasan' => 'Pelatihan intensif desain antarmuka pengguna dan pengalaman pengguna bersama praktisi industri kreatif Jember.',
                            'tanggal' => '20 Jan 2025',
                            'penulis' => 'Guru Multimedia'
                        ],
                        [
                            'bg' => 'from-indigo-700 to-blue-900',
                            'badge' => 'Beasiswa',
                            'badge_color' => 'bg-indigo-100 text-indigo-700',
                            'judul' => 'Informasi Beasiswa KIP-K untuk Siswa Berprestasi 2025',
                            'ringkasan' => 'Pendaftaran beasiswa KIP-K untuk melanjutkan ke perguruan tinggi bagi siswa kelas XII yang berprestasi.',
                            'tanggal' => '15 Jan 2025',
                            'penulis' => 'BK SMKN2'
                        ],
                    ];
                @endphp

                @foreach($artikels as $index => $artikel)
                <div class="artikel-card shadow-sm fade-in" style="transition-delay: {{ $index * 0.08 }}s">
                    {{-- Thumbnail placeholder --}}
                    <div class="artikel-img bg-gradient-to-br {{ $artikel['bg'] }} flex items-center justify-center">
                        <span class="text-white/30 text-5xl">📰</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="artikel-badge {{ $artikel['badge_color'] }} px-2 py-0.5 rounded-full">{{ $artikel['badge'] }}</span>
                            <span class="text-xs text-gray-400">{{ $artikel['tanggal'] }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm leading-tight mb-2 line-clamp-2">{{ $artikel['judul'] }}</h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-3">{{ $artikel['ringkasan'] }}</p>
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-400">✍️ {{ $artikel['penulis'] }}</span>
                            <a href="#" class="text-xs text-blue-700 font-semibold hover:underline">Baca →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    

    {{-- ===== FOOTER ===== --}}
    <footer id="kontak" class="footer text-white pt-12 pb-6">
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
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-xs font-bold transition-colors">{{ strtoupper($s) }}</a>
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

    <script>
        // ===== MOBILE MENU =====
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        }

        // ===== CAROUSEL =====
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');

        function goToSlide(index) {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            currentSlide = index;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        // Auto-play carousel
        setInterval(() => {
            goToSlide((currentSlide + 1) % slides.length);
        }, 5000);

        // ===== SCROLL ANIMATIONS =====
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // ===== SMOOTH SCROLL for anchor links =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile menu if open
                    document.getElementById('mobile-menu').classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>