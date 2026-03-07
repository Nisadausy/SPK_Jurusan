{{-- resources/views/pages/admin/infojurusan/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Info Jurusan')

@section('content')
<div style="max-width:680px;">

    {{-- Header --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.infojurusan.index') }}" style="font-size:12px;color:#2563eb;text-decoration:none;">← Kembali</a>
        <h1 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#0d1117;margin-top:8px;">
            Edit Info Jurusan — {{ $jurusan->nama_jurusan }}
        </h1>
        <p style="font-size:12px;color:#64748b;margin-top:3px;">FR-A-10 · Edit fasilitas dan prospek kerja</p>
    </div>

    <form method="POST" action="{{ route('admin.infojurusan.update', $jurusan->id) }}">
        @csrf @method('PUT')

        {{-- Fasilitas --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.05);margin-bottom:16px;">
            <div style="font-family:'Syne',sans-serif;font-size:13.5px;font-weight:800;color:#0d1117;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #f1f5f9;">
                🏫 Fasilitas Jurusan
            </div>
            <div>
                <label style="display:block;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:7px;">
                    Deskripsi Fasilitas
                </label>
                <textarea name="fasilitas" rows="4"
                    placeholder="Contoh: Lab komputer 40 unit, server room, akses internet fiber optic..."
                    style="width:100%;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-family:'DM Sans',sans-serif;font-size:13px;padding:10px 14px;outline:none;resize:vertical;"
                    onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">{{ old('fasilitas', $info->fasilitas) }}</textarea>
            </div>
        </div>

        {{-- Prospek Umum --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.05);margin-bottom:16px;">
            <div style="font-family:'Syne',sans-serif;font-size:13.5px;font-weight:800;color:#0d1117;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #f1f5f9;">
                💼 Prospek Kerja Umum
            </div>
            <div id="prospek-umum-wrap">
                @forelse($prospekUmum as $p)
                <div class="input-row" style="display:flex;gap:8px;margin-bottom:8px;">
                    <input type="text" name="prospek_umum[]" value="{{ $p->isi }}"
                        placeholder="Contoh: Network Engineer"
                        style="flex:1;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:9px 13px;outline:none;"
                        onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                    <button type="button" onclick="this.closest('.input-row').remove()"
                        style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:9px;padding:8px 12px;font-size:12px;cursor:pointer;flex-shrink:0;">✕</button>
                </div>
                @empty
                <div class="input-row" style="display:flex;gap:8px;margin-bottom:8px;">
                    <input type="text" name="prospek_umum[]"
                        placeholder="Contoh: Network Engineer"
                        style="flex:1;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:9px 13px;outline:none;"
                        onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                    <button type="button" onclick="this.closest('.input-row').remove()"
                        style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:9px;padding:8px 12px;font-size:12px;cursor:pointer;flex-shrink:0;">✕</button>
                </div>
                @endforelse
            </div>
            <button type="button" onclick="addRow('prospek-umum-wrap', 'prospek_umum[]', 'Contoh: Network Engineer')"
                style="background:#f8fafc;color:#374151;border:1.5px solid #e2e8f0;border-radius:9px;padding:7px 14px;font-size:12px;font-weight:700;cursor:pointer;margin-top:4px;">
                ＋ Tambah Prospek Umum
            </button>
        </div>

        {{-- Prospek Alumni --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.05);margin-bottom:20px;">
            <div style="font-family:'Syne',sans-serif;font-size:13.5px;font-weight:800;color:#0d1117;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #f1f5f9;">
                🎓 Prospek Kerja Alumni
            </div>
            <div id="prospek-alumni-wrap">
                @forelse($prospekAlumni as $p)
                <div class="input-row" style="display:flex;gap:8px;margin-bottom:8px;">
                    <input type="text" name="prospek_alumni[]" value="{{ $p->isi }}"
                        placeholder="Contoh: Bekerja di PT Telkom"
                        style="flex:1;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:9px 13px;outline:none;"
                        onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                    <button type="button" onclick="this.closest('.input-row').remove()"
                        style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:9px;padding:8px 12px;font-size:12px;cursor:pointer;flex-shrink:0;">✕</button>
                </div>
                @empty
                <div class="input-row" style="display:flex;gap:8px;margin-bottom:8px;">
                    <input type="text" name="prospek_alumni[]"
                        placeholder="Contoh: Bekerja di PT Telkom"
                        style="flex:1;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:9px 13px;outline:none;"
                        onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                    <button type="button" onclick="this.closest('.input-row').remove()"
                        style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:9px;padding:8px 12px;font-size:12px;cursor:pointer;flex-shrink:0;">✕</button>
                </div>
                @endforelse
            </div>
            <button type="button" onclick="addRow('prospek-alumni-wrap', 'prospek_alumni[]', 'Contoh: Bekerja di PT Telkom')"
                style="background:#f8fafc;color:#374151;border:1.5px solid #e2e8f0;border-radius:9px;padding:7px 14px;font-size:12px;font-weight:700;cursor:pointer;margin-top:4px;">
                ＋ Tambah Prospek Alumni
            </button>
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <a href="{{ route('admin.infojurusan.index') }}"
                style="padding:9px 18px;border-radius:9px;font-size:12.5px;font-weight:700;border:1.5px solid #e2e8f0;color:#64748b;text-decoration:none;">
                Batal
            </a>
            <button type="submit"
                style="padding:9px 22px;border-radius:9px;font-size:12.5px;font-weight:700;background:linear-gradient(135deg,#0d1117,#1c2333);color:#fff;border:none;cursor:pointer;">
                ✓ Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
function addRow(wrapperId, inputName, placeholder) {
    const wrap = document.getElementById(wrapperId);
    const div = document.createElement('div');
    div.className = 'input-row';
    div.style.cssText = 'display:flex;gap:8px;margin-bottom:8px;';
    div.innerHTML = `
        <input type="text" name="${inputName}" placeholder="${placeholder}"
            style="flex:1;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;padding:9px 13px;outline:none;"
            onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
            onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
        <button type="button" onclick="this.closest('.input-row').remove()"
            style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:9px;padding:8px 12px;font-size:12px;cursor:pointer;flex-shrink:0;">✕</button>
    `;
    wrap.appendChild(div);
}
</script>
@endpush

@endsection