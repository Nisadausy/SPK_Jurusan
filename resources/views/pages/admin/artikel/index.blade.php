@extends('layouts.admin')
@section('title','Kelola Artikel')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <div>
        <h1 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#0d1117;">📝 Artikel Jurusan</h1>
        <p style="font-size:12px;color:#64748b;margin-top:3px;">FR-A-09 · Edit atau hapus artikel yang dibuat Guru BK</p>
    </div>
</div>

@if(session('success'))
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-left:3px solid #059669;color:#065f46;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">✅ {{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;">
    @forelse($artikels as $artikel)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);">
        @if($artikel->gambarUpload)
        <div style="height:140px;background:#f1f5f9;overflow:hidden;">
            <img src="{{ Storage::url($artikel->gambarUpload->path) }}" style="width:100%;height:100%;object-fit:cover;">
        </div>
        @else
        <div style="height:80px;background:linear-gradient(135deg,#1c2333,#2d3748);display:flex;align-items:center;justify-content:center;font-size:28px;">📄</div>
        @endif
        <div style="padding:16px;">
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                <span style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:2px 8px;border-radius:100px;font-size:10px;font-weight:700;">{{ $artikel->jurusan->nama ?? '-' }}</span>
                <span style="font-size:11px;color:#94a3b8;">{{ $artikel->created_at?->format('d M Y') }}</span>
            </div>
            <div style="font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:#0d1117;margin-bottom:4px;line-height:1.4;">{{ Str::limit($artikel->judul, 50) }}</div>
            <div style="font-size:11.5px;color:#64748b;margin-bottom:12px;line-height:1.5;">{{ Str::limit($artikel->deskripsi, 80) }}</div>
            <div style="font-size:11px;color:#94a3b8;margin-bottom:12px;">Oleh: {{ $artikel->creator->nama ?? '-' }}</div>
            <div style="display:flex;gap:8px;padding-top:12px;border-top:1px solid #e2e8f0;">
                <a href="{{ route('admin.artikel.edit', $artikel->id) }}" style="flex:1;text-align:center;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:7px;border-radius:7px;font-size:11.5px;font-weight:700;text-decoration:none;">✏️ Edit</a>
                <form method="POST" action="{{ route('admin.artikel.destroy', $artikel->id) }}" style="flex:1;" onsubmit="return confirm('Hapus artikel ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="width:100%;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:7px;border-radius:7px;font-size:11.5px;font-weight:700;cursor:pointer;">🗑️ Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:40px;color:#94a3b8;">Belum ada artikel.</div>
    @endforelse
</div>
<div style="margin-top:20px;">{{ $artikels->links() }}</div>
@endsection