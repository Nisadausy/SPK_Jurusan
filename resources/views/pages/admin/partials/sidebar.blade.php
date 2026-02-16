@php
    // Helper untuk menandai menu aktif
    $isActive = fn($patterns) => request()->routeIs($patterns) ? 'active' : '';
@endphp

<aside class="sidebar d-flex flex-column p-3">
    <div class="brand pb-3 mb-3">
        <div class="fw-semibold fs-5">SPK SAW</div>
        <div class="text-secondary small">Admin Dashboard</div>
    </div>

    <nav class="nav nav-pills flex-column gap-1">
        <a class="nav-link {{ $isActive('admin.dashboard') }}"
           href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>

        <div class="mt-2 text-uppercase text-secondary small">Kelola Akun</div>
        <a class="nav-link {{ $isActive(['admin.gurubk.*']) }}"
           href="{{ route('admin.gurubk.index') }}">
            Akun Guru BK
        </a>
        <a class="nav-link {{ $isActive(['admin.siswa.*']) }}"
           href="{{ route('admin.siswa.index') }}">
            Akun Siswa
        </a>

        <div class="mt-2 text-uppercase text-secondary small">Kelola Status</div>
        <a class="nav-link {{ $isActive('admin.status.*') }}"
           href="{{ route('admin.status.index') }}">
            Status Siswa & Guru BK
        </a>

        <div class="mt-2 text-uppercase text-secondary small">Kelola Jurusan</div>
        <a class="nav-link {{ $isActive('admin.jurusan.*') }}"
           href="{{ route('admin.jurusan.index') }}">
            Data & Status Jurusan
        </a>

        <div class="mt-2 text-uppercase text-secondary small">Kelola Konten</div>
        <a class="nav-link {{ $isActive('admin.artikel.*') }}"
           href="{{ route('admin.artikel.index') }}">
            Artikel Jurusan
        </a>
        <a class="nav-link {{ $isActive('admin.infojurusan.*') }}"
           href="{{ route('admin.infojurusan.index') }}">
            Informasi Jurusan
        </a>

        <div class="mt-2 text-uppercase text-secondary small">Monitoring</div>
        <a class="nav-link {{ $isActive('admin.monitoring.*') }}"
           href="{{ route('admin.monitoring.index') }}">
            Statistik & Activity Log
        </a>
    </nav>

    <div class="mt-auto pt-3">
        <div class="border-top border-light border-opacity-10 pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light w-100" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
