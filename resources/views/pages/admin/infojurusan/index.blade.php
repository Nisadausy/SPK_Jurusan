@extends('layouts.admin')
@section('title','Kelola Info Jurusan')
@section('content')
<div style="margin-bottom:20px;">
    <h1 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#0d1117;">📋 Informasi Jurusan</h1>
    <p style="font-size:12px;color:#64748b;margin-top:3px;">FR-A-10 · Edit atau hapus informasi jurusan yang diisi Guru BK</p>
</div>

@if(session('success'))
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-left:3px solid #059669;color:#065f46;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">✅ {{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;">
    @forelse($jurusans as $j)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.06);">
        <div style="font-family:'Syne',sans-serif;font-size:15px;font-weight:800;color:#0d1117;margin-bottom:8px;">{{ $j->nama }}</div>
        <div style="font-size:12px;color:#64748b;margin-bottom:6px;">
            Fasilitas: <strong style="color:#374151;">{{ $j->informasiJurusan ? Str::limit($j->informasiJurusan->fasilitas, 60) : 'Belum diisi' }}</strong>
        </div>
        <div style="display:flex;gap:6px;margin-bottom:14px;">
            <span style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;padding:2px 8px;border-radius:100px;font-size:10px;font-weight:700;">{{ $j->prospekKerja->where('tipe','umum')->count() }} prospek umum</span>
            <span style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:2px 8px;border-radius:100px;font-size:10px;font-weight:700;">{{ $j->prospekKerja->where('tipe','alumni')->count() }} alumni</span>
        </div>
        <div style="display:flex;gap:8px;padding-top:12px;border-top:1px solid #e2e8f0;">
            <a href="{{ route('admin.infojurusan.edit', $j->id) }}" style="flex:1;text-align:center;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:7px;border-radius:7px;font-size:11.5px;font-weight:700;text-decoration:none;">✏️ Edit</a>
            @if($j->informasiJurusan)
            <form method="POST" action="{{ route('admin.infojurusan.destroy', $j->id) }}" style="flex:1;" onsubmit="return confirm('Hapus semua info jurusan ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="width:100%;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:7px;border-radius:7px;font-size:11.5px;font-weight:700;cursor:pointer;">🗑️ Hapus</button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:40px;color:#94a3b8;">Belum ada data jurusan.</div>
    @endforelse
</div>
@endsection

