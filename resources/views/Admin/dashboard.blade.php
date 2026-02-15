@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row g-3">
    <div class="col-12">
        <div class="card card-soft p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-4 fw-semibold">Ringkasan Sistem</div>
                    <div class="text-muted">
                        Panel Admin untuk monitoring dan pengelolaan data (akun, jurusan, konten, aktivitas).
                    </div>
                </div>
                <a href="{{ route('admin.monitoring.index') }}" class="btn btn-dark">
                    Lihat Monitoring
                </a>
            </div>
        </div>
    </div>

    {{-- Kartu ringkas (angka dibuat dinamis dari controller) --}}
    <div class="col-md-3">
        <div class="card card-soft p-3">
            <div class="text-muted small">Total Siswa</div>
            <div class="fs-3 fw-semibold">{{ $totalSiswa ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-soft p-3">
            <div class="text-muted small">Total Guru BK</div>
            <div class="fs-3 fw-semibold">{{ $totalGuruBk ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-soft p-3">
            <div class="text-muted small">Total Jurusan</div>
            <div class="fs-3 fw-semibold">{{ $totalJurusan ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-soft p-3">
            <div class="text-muted small">Total Tes</div>
            <div class="fs-3 fw-semibold">{{ $totalTes ?? 0 }}</div>
        </div>
    </div>

    <div class="col-12">
        <div class="card card-soft p-3">
            <div class="fw-semibold mb-2">Aktivitas Terakhir</div>

            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($recentLogs ?? []) as $log)
                            <tr>
                                <td class="text-muted small">{{ $log->created_at }}</td>
                                <td>{{ $log->user_nama ?? '-' }}</td>
                                <td>{{ $log->aksi ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted">Belum ada data log.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
