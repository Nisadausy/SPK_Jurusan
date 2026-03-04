@extends('layouts.admin')
@section('title','Status Akun')
@section('content')
<div style="margin-bottom:20px;">
    <h1 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#0d1117;">🔘 Status Siswa & Guru BK</h1>
    <p style="font-size:12px;color:#64748b;margin-top:3px;">FR-A-07 · Aktifkan atau nonaktifkan akun untuk kontrol akses</p>
</div>

@if(session('success'))
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-left:3px solid #059669;color:#065f46;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">✅ {{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

    {{-- Guru BK --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);">
        <div style="padding:15px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-family:'Syne',sans-serif;font-size:13.5px;font-weight:700;">👩‍🏫 Guru BK</div>
            <span style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;padding:3px 9px;border-radius:100px;font-size:10.5px;font-weight:700;">{{ $guruBks->total() }} data</span>
        </div>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e2e8f0;">Nama</th>
                    <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e2e8f0;">Status</th>
                    <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e2e8f0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guruBks as $guru)
                <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="padding:10px 16px;">
                        <div style="font-weight:600;font-size:12.5px;">{{ $guru->user->nama ?? '-' }}</div>
                        <div style="font-size:11px;color:#64748b;">{{ $guru->jurusan->nama ?? 'Belum ditentukan' }}</div>
                    </td>
                    <td style="padding:10px 16px;">
                        @if($guru->user->is_active)
                            <span style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;padding:3px 8px;border-radius:100px;font-size:10px;font-weight:700;">✅ Aktif</span>
                        @else
                            <span style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:3px 8px;border-radius:100px;font-size:10px;font-weight:700;">❌ Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding:10px 16px;">
                        <form method="POST" action="{{ route('admin.status.guru', $guru->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" style="background:{{ $guru->user->is_active ? '#fef2f2' : '#ecfdf5' }};color:{{ $guru->user->is_active ? '#dc2626' : '#059669' }};border:1px solid {{ $guru->user->is_active ? '#fecaca' : '#a7f3d0' }};padding:5px 10px;border-radius:7px;font-size:11px;font-weight:700;cursor:pointer;">
                                {{ $guru->user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding:20px;text-align:center;color:#94a3b8;font-size:12px;">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding:12px 16px;border-top:1px solid #e2e8f0;">{{ $guruBks->links() }}</div>
    </div>

    {{-- Siswa --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);">
        <div style="padding:15px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-family:'Syne',sans-serif;font-size:13.5px;font-weight:700;">👨‍🎓 Siswa</div>
            <span style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:3px 9px;border-radius:100px;font-size:10.5px;font-weight:700;">{{ $siswas->total() }} data</span>
        </div>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e2e8f0;">Nama</th>
                    <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e2e8f0;">Status</th>
                    <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e2e8f0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="padding:10px 16px;">
                        <div style="font-weight:600;font-size:12.5px;">{{ $siswa->user->nama ?? '-' }}</div>
                        <div style="font-size:11px;color:#64748b;">{{ $siswa->sekolah_asal ?? '-' }}</div>
                    </td>
                    <td style="padding:10px 16px;">
                        @if($siswa->user->is_active)
                            <span style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;padding:3px 8px;border-radius:100px;font-size:10px;font-weight:700;">✅ Aktif</span>
                        @else
                            <span style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:3px 8px;border-radius:100px;font-size:10px;font-weight:700;">❌ Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding:10px 16px;">
                        <form method="POST" action="{{ route('admin.status.siswa', $siswa->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" style="background:{{ $siswa->user->is_active ? '#fef2f2' : '#ecfdf5' }};color:{{ $siswa->user->is_active ? '#dc2626' : '#059669' }};border:1px solid {{ $siswa->user->is_active ? '#fecaca' : '#a7f3d0' }};padding:5px 10px;border-radius:7px;font-size:11px;font-weight:700;cursor:pointer;">
                                {{ $siswa->user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding:20px;text-align:center;color:#94a3b8;font-size:12px;">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding:12px 16px;border-top:1px solid #e2e8f0;">{{ $siswas->links() }}</div>
    </div>
</div>
@endsection