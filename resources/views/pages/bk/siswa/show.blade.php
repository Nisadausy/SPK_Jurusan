@extends('layouts.bk')
@section('title','Detail Siswa')
@section('page-title','Detail Siswa')
@section('page-sub','FR-BK-05 · Riwayat tes & perbandingan minat vs rekomendasi')

@section('content')
@php
    $lastTes = $riwayatTes->first();
    $rek     = $lastTes?->rekomendasiTeratas?->jurusan;
    $sesuai  = $lastTes && $rek && $rek->id === $lastTes->minat_jurusan_1_id;
@endphp

<a href="{{ route('bk.siswa.index') }}" class="btn btn-outline btn-sm" style="margin-bottom:16px;">← Kembali</a>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
    <div class="card" style="padding:20px;">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid var(--border);">
            {{-- Gunakan $siswa->user->nama --}}
            <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:20px;font-weight:800;color:#fff;flex-shrink:0;">
                {{ strtoupper(substr($siswa->user->nama ?? 'S', 0, 1)) }}
            </div>
            <div>
                <div style="font-size:15px;font-weight:800;color:var(--primary-dark);">{{ $siswa->user->nama ?? '-' }}</div>
                <div style="font-size:12px;color:var(--text-dim);">{{ $siswa->sekolah_asal ?? '-' }}</div>
                @if($rek) <span class="badge badge-blue" style="margin-top:5px;">{{ $rek->nama }}</span> @endif
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            @foreach([
                ['Email',      $siswa->user->email ?? '-'],
                ['Telepon',    $siswa->no_telepon ?? '-'],
                ['Gender',     $siswa->jenis_kelamin === 'L' ? '👦 Laki-laki' : '👧 Perempuan'],
                ['Jumlah Tes', $riwayatTes->count().' kali'],
            ] as [$l,$v])
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-dim);margin-bottom:3px;">{{ $l }}</div>
                <div style="font-size:13px;font-weight:600;color:var(--primary-dark);">{{ $v }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="card" style="padding:20px;">
        <div style="font-size:13.5px;font-weight:700;color:var(--primary-dark);margin-bottom:14px;">⚖️ Minat vs Rekomendasi</div>
        @if($lastTes)
        @php
            $m1nama  = $lastTes->minatJurusan1?->nama ?? '-';
            $m2nama  = $lastTes->minatJurusan2?->nama ?? '-';
            $rekNama = $rek?->nama ?? '-';
            $sesuai2 = $lastTes->minatJurusan2 && $rek && $lastTes->minat_jurusan_2_id === $rek->id;
        @endphp
        @foreach([[$m1nama,$sesuai],[$m2nama,$sesuai2]] as $i => [$minat,$cocok])
        <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;border-radius:8px;background:var(--surface2);border:1px solid var(--border);margin-bottom:8px;">
            <div style="font-size:11px;color:var(--text-dim);width:90px;flex-shrink:0;">Minat {{ $i === 0 ? 'Pertama':'Kedua' }}</div>
            <div style="font-size:12px;font-weight:700;color:var(--blue);flex:1;">{{ $minat }}</div>
            <div>→</div>
            <div style="font-size:12px;font-weight:700;color:var(--green);flex:1;">{{ $rekNama }}</div>
            <span class="badge {{ $cocok ? 'badge-green':'badge-red' }}">{{ $cocok ? 'Sesuai':'Beda' }}</span>
        </div>
        @endforeach
        <div style="margin-top:12px;font-size:12px;color:var(--text-mid);background:var(--surface2);padding:10px 12px;border-radius:8px;border:1px solid var(--border);">
            💡 Minat awal tidak mempengaruhi SAW, hanya referensi konseling.
        </div>
        @else
        <div style="color:var(--text-dim);">Siswa belum mengerjakan tes.</div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-head"><div class="card-title">📋 Riwayat Tes ({{ $riwayatTes->count() }} kali)</div></div>
    <table>
        <thead><tr><th>#</th><th>Tanggal</th><th>Rekomendasi</th><th>Minat 1</th><th>Minat 2</th><th>Nilai Akademik</th><th>Skor Minat</th><th>Buta Warna</th></tr></thead>
        <tbody>
            @forelse($riwayatTes as $i => $tes)
            <tr>
                <td style="color:var(--text-dim);">{{ $i+1 }}</td>
                <td style="font-size:11.5px;">{{ $tes->created_at->translatedFormat('d M Y H:i') }}</td>
                <td><span class="badge badge-blue">{{ $tes->rekomendasiTeratas?->jurusan?->nama ?? '-' }}</span></td>
                <td><span class="badge badge-gray">{{ $tes->minatJurusan1?->nama ?? '-' }}</span></td>
                <td><span class="badge badge-gray">{{ $tes->minatJurusan2?->nama ?? '-' }}</span></td>
                <td style="font-weight:700;">{{ $tes->nilai_akademik }}</td>
                <td style="font-weight:700;">{{ $tes->skor_minat_bakat }}/10</td>
                <td>{{ $tes->buta_warna ? '⚠ Ya':'Tidak' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-dim);padding:24px;">Belum ada riwayat tes.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
