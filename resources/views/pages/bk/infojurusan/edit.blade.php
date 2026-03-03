@extends('layouts.bk')
@section('title',"Edit Info {$jurusan->nama}")
@section('page-title',"Edit Info Jurusan: {$jurusan->nama}")
@section('page-sub','FR-BK-08/09 · Fasilitas & prospek kerja')

@section('content')
<a href="{{ route('bk.infojurusan.index') }}" class="btn btn-outline btn-sm" style="margin-bottom:16px;">← Kembali</a>
<div class="card" style="padding:24px;max-width:680px;">
    <div style="font-family:'Playfair Display',serif;font-size:15px;font-weight:800;color:var(--primary-dark);margin-bottom:20px;">🏫 Edit Info Jurusan {{ $jurusan->nama }}</div>
    <form method="POST" action="{{ route('bk.infojurusan.update', $jurusan->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Fasilitas Jurusan</label>
            <textarea name="fasilitas" class="form-control">{{ old('fasilitas', $info->fasilitas ?? '') }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Prospek Kerja Umum</label>
            <div id="prospek-umum">
                @forelse($prospekUmum as $p)
                    <div style="display:flex;gap:8px;margin-bottom:8px;">
                        <input name="prospek_umum[]" class="form-control" value="{{ $p->isi }}" placeholder="Contoh: Network engineer..."/>
                        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>
                    </div>
                @empty
                    <div style="display:flex;gap:8px;margin-bottom:8px;">
                        <input name="prospek_umum[]" class="form-control" placeholder="Contoh: Network engineer..."/>
                        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="addRow('prospek-umum','prospek_umum')" class="btn btn-outline btn-sm" style="margin-top:6px;">+ Tambah</button>
        </div>
        <div class="form-group">
            <label class="form-label">Prospek Kerja Alumni</label>
            <div id="prospek-alumni">
                @forelse($prospekAlumni as $p)
                    <div style="display:flex;gap:8px;margin-bottom:8px;">
                        <input name="prospek_alumni[]" class="form-control" value="{{ $p->isi }}" placeholder="Pencapaian alumni..."/>
                        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>
                    </div>
                @empty
                    <div style="display:flex;gap:8px;margin-bottom:8px;">
                        <input name="prospek_alumni[]" class="form-control" placeholder="Pencapaian alumni..."/>
                        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="addRow('prospek-alumni','prospek_alumni')" class="btn btn-outline btn-sm" style="margin-top:6px;">+ Tambah</button>
        </div>
        <div class="form-actions">
            <a href="{{ route('bk.infojurusan.index') }}" class="btn btn-outline">Batal</a>
            <button class="btn btn-primary">💾 Simpan</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
function addRow(containerId, inputName){
    const d = document.createElement('div');
    d.style.cssText='display:flex;gap:8px;margin-bottom:8px;';
    d.innerHTML=`<input name="${inputName}[]" class="form-control" placeholder="Tambah..."/><button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>`;
    document.getElementById(containerId).appendChild(d);
}
</script>
@endpush

