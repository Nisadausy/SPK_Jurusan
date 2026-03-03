@php
    // Data dari Auth (sesuai ERD: nama ada di users)
    $user = Auth::user();

    // NUPTK: tidak ada di tabel admin pada ERD Anda.
    // Disiapkan placeholder agar "siap dinamis".
    // Anda bisa isi dari controller: return view(..., ['nuptk' => 'xxxx']);
    $nuptk = $nuptk ?? ($user->nuptk ?? null); // tetap aman jika tidak ada
@endphp

<header class="topbar px-3 py-2 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
        <span class="badge text-bg-dark">Admin</span>
        <span class="text-muted small">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    <div class="text-end">
        <div class="fw-semibold">{{ $user->nama ?? 'Admin' }}</div>
        <div class="text-muted small">
            NUPTK: <span class="fw-medium">{{ $nuptk ?: '-' }}</span>
        </div>
    </div>
</header>
