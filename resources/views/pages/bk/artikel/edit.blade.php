@extends('layouts.bk')
@section('title','Edit Artikel')
@section('page-title','Edit Artikel')
@section('page-sub','FR-BK-07 · Perbarui artikel jurusan')

@section('content')
<a href="{{ route('bk.artikel.index') }}" class="btn btn-outline btn-sm" style="margin-bottom:16px;">← Kembali</a>
<div class="card" style="padding:24px;max-width:680px;">
    <div style="font-family:'Playfair Display',serif;font-size:15px;font-weight:800;color:var(--primary-dark);margin-bottom:20px;">✏️ Edit Artikel</div>
    <form method="POST" action="{{ route('bk.artikel.update', $artikel->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Judul <span class="req">*</span></label>
            <input name="judul" class="form-control" value="{{ old('judul', $artikel->judul) }}" required/>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Jurusan <span class="req">*</span></label>
                <select name="jurusan_id" class="form-control" required>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}" {{ old('jurusan_id',$artikel->jurusan_id) == $j->id ? 'selected':'' }}>{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi <span class="req">*</span></label>
            <textarea name="deskripsi" class="form-control" required>{{ old('deskripsi', $artikel->deskripsi) }}</textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Ganti Gambar</label>
                <input name="gambar" type="file" accept=".jpg,.jpeg" class="form-control"/>
                @if($artikel->gambarUpload) <div class="form-hint">Saat ini: {{ $artikel->gambarUpload->original_name }}</div> @endif
            </div>
            <div class="form-group">
                <label class="form-label">Ganti File</label>
                <input name="file" type="file" accept=".pdf,.mp4" class="form-control"/>
                @if($artikel->fileUpload) <div class="form-hint">Saat ini: {{ $artikel->fileUpload->original_name }}</div> @endif
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('bk.artikel.index') }}" class="btn btn-outline">Batal</a>
            <button class="btn btn-primary">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

