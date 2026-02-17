@php
    $isSpkPage = request()->routeIs('siswa.tes.*');
    $isLanding = request()->routeIs('landing.home');
@endphp

<!-- {{-- TOP INFO BAR --}}
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
                <a href="{{ route('register') }}" class="text-xs bg-amber-400 text-gray-900 font-semibold px-3 py-1 rounded hover:bg-amber-300 transition-colors">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</div> -->

{{-- MAIN HEADER --}}
<header class="main-header text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-md overflow-hidden flex-shrink-0">
                    <span class="text-blue-900 font-bold text-lg">S2J</span>
                </div>
                <div>
                    <div class="font-bold text-sm sm:text-base leading-tight">SMK NEGERI 2 JEMBER</div>
                    <div class="text-blue-200 text-xs">Sistem Pendukung Keputusan Pemilihan Jurusan</div>
                </div>
            </div>

            {{-- DESKTOP NAV --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('landing.home') }}" class="nav-link-custom {{ $isLanding ? 'active' : '' }}">Beranda</a>
                <a href="#profil" class="nav-link-custom">Profil</a>

                <div class="relative group">
                    <button type="button" class="nav-link-custom flex items-center gap-1 {{ $isSpkPage ? 'active' : '' }}">
                        SPK Jurusan
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="absolute top-full left-0 w-52 bg-white text-gray-800 rounded-lg shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 text-xs">
                        <a href="{{ route('siswa.tes.index') }}" class="block px-4 py-2 hover:bg-blue-50">Cek Jurusan</a>
                        <a href="{{ route('siswa.tes.hasil') }}" class="block px-4 py-2 hover:bg-blue-50">History</a>
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
                    <a href="{{ route('login') }}" class="ml-2 px-4 py-1.5 bg-white/10 text-white font-semibold text-xs rounded-lg hover:bg-white/20 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="ml-2 px-4 py-1.5 bg-amber-400 text-gray-900 font-semibold text-xs rounded-lg hover:bg-amber-300 transition-colors">
                        Daftar
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
        <div id="mobile-menu" class="md:hidden mt-3 pb-2 border-t border-white/20" style="display:none;">
            <div class="flex flex-col gap-1 pt-3">
                <a href="{{ route('landing.home') }}" class="nav-link-custom {{ $isLanding ? 'active' : '' }}">Beranda</a>
                <a href="#profil" class="nav-link-custom">Profil</a>
                <a href="{{ route('siswa.tes.index') }}" class="nav-link-custom {{ $isSpkPage ? 'active' : '' }}">SPK Jurusan</a>
                <a href="#artikel" class="nav-link-custom">Artikel</a>
                <a href="#kontak" class="nav-link-custom">Kontak</a>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
    }
</script>
