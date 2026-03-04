@extends('layouts.admin')
@section('title','Kelola Akun Siswa')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#0d1117;">👨‍🎓 Akun Siswa</h1>
        <p style="font-size:12px;color:#64748b;margin-top:3px;">FR-A-05, FR-A-06 · Edit profil dan kredensial siswa</p>
    </div>
    <form method="GET" style="display:flex;gap:8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." style="background:#fff;border:1.5px solid #e2e8f0;border-radius:9px;padding:8px 14px;font-size:13px;width:240px;outline:none;">
        <button type="submit" style="background:#0d1117;color:#fff;border:none;border-radius:9px;padding:8px 16px;font-size:12.5px;font-weight:700;cursor:pointer;">Cari</button>
    </form>
</div>

@if(session('success'))
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-left:3px solid #059669;color:#065f46;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">✅ {{ session('success') }}</div>
@endif

<div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 1px 3px rgba(0,0,0,.06);overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#f8fafc;">
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid #e2e8f0;">Nama & Email</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid #e2e8f0;">Sekolah Asal</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid #e2e8f0;">Status</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid #e2e8f0;">Daftar</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid #e2e8f0;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $siswa)
            <tr style="border-bottom:1px solid #e2e8f0;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">
                <td style="padding:12px 16px;">
                    <div style="font-weight:700;font-size:13px;">{{ $siswa->user->nama ?? '-' }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $siswa->user->email ?? '-' }}</div>
                </td>
                <td style="padding:12px 16px;font-size:12.5px;color:#374151;">{{ $siswa->sekolah_asal ?? '-' }}</td>
                <td style="padding:12px 16px;">
                    @if($siswa->user->is_active)
                        <span style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;padding:3px 9px;border-radius:100px;font-size:10.5px;font-weight:700;">✅ Aktif</span>
                    @else
                        <span style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:3px 9px;border-radius:100px;font-size:10.5px;font-weight:700;">❌ Nonaktif</span>
                    @endif
                </td>
                <td style="padding:12px 16px;font-size:11.5px;color:#64748b;">{{ $siswa->created_at?->format('d M Y') ?? '-' }}</td>
                <td style="padding:12px 16px;">
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.siswa.edit', $siswa->id) }}" style="display:inline-flex;align-items:center;gap:4px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:5px 11px;border-radius:7px;font-size:11.5px;font-weight:700;text-decoration:none;">✏️ Edit</a>
                        <form method="POST" action="{{ route('admin.siswa.status', $siswa->id) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" style="background:{{ $siswa->user->is_active ? '#fef2f2' : '#ecfdf5' }};color:{{ $siswa->user->is_active ? '#dc2626' : '#059669' }};border:1px solid {{ $siswa->user->is_active ? '#fecaca' : '#a7f3d0' }};padding:5px 11px;border-radius:7px;font-size:11.5px;font-weight:700;cursor:pointer;">
                                {{ $siswa->user->is_active ? '🔴 Nonaktifkan' : '🟢 Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="padding:32px;text-align:center;color:#94a3b8;font-size:13px;">Belum ada data siswa.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:14px 16px;border-top:1px solid #e2e8f0;">{{ $siswas->appends(request()->query())->links() }}</div>
</div>
@endsection