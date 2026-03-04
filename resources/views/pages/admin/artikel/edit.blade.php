@extends('layouts.admin')
@section('title','Edit Artikel')
@section('content')
<div style="max-width:640px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.artikel.index') }}" style="font-size:12px;color:#2563eb;text-decoration:none;">← Kembali</a>
        <h1 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#0d1117;margin-top:8px;">Edit Artikel</h1>
        <p style="font-size:12px;color:#64748b;margin-top:3px;">FR-A-09 · Admin hanya bisa edit konten teks, bukan upload file</p>
    </div>
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:28px;box-shadow:0 1px 3px rgba(0,0,0,.06);">
        <form method="POST" action="{{ route('admin.artikel.update', $artikel->id) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:7px;">Jurusan *</label>
                <select name="jurusan_id" style="width:100%;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:10px 14px;outline:none;">
                    @foreach($jurusans as $j)
                    <option value="{{ $j->id }}" {{ $artikel->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:7px;">Judul *</label>
                <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" style="width:100%;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:10px 14px;outline:none;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:7px;">Deskripsi *</label>
                <textarea name="deskripsi" rows="6" style="width:100%;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:10px 14px;outline:none;resize:vertical;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">{{ old('deskripsi', $artikel->deskripsi) }}</textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
                <a href="{{ route('admin.artikel.index') }}" style="padding:9px 18px;border-radius:9px;font-size:12.5px;font-weight:700;border:1.5px solid #e2e8f0;color:#64748b;text-decoration:none;">Batal</a>
                <button type="submit" style="padding:9px 22px;border-radius:9px;font-size:12.5px;font-weight:700;background:linear-gradient(135deg,#0d1117,#1c2333);color:#fff;border:none;cursor:pointer;">✓ Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

