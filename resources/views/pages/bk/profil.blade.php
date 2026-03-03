@extends('layouts.bk')
@section('title','Profil Saya')
@section('page-title','Profil Saya')
@section('page-sub','FR-BK-04 · Data pribadi guru BK')

@section('content')
<div class="card" style="overflow:hidden;max-width:500px;">
    <div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));height:90px;position:relative;">
        <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--accent),#f97316,var(--accent));"></div>
    </div>
    <div style="padding:0 24px;margin-top:-36px;">
        {{-- Gunakan Auth::user()->nama --}}
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--accent),#f97316);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:28px;font-weight:800;color:#fff;border:4px solid #fff;box-shadow:0 4px 16px rgba(232,160,32,.3);">
            {{ strtoupper(substr($user->nama, 0, 1)) }}
        </div>
    </div>
    <div style="padding:14px 24px 24px;">
        <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:800;color:var(--primary-dark);margin-bottom:3px;">{{ $user->nama }}</div>
        <div style="font-size:12px;color:var(--text-mid);margin-bottom:16px;">Guru Bimbingan Konseling</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-dim);margin-bottom:4px;">NIP</div>
                <div style="font-size:13px;font-weight:600;color:var(--primary-dark);">{{ $guruBk->nip ?? '-' }}</div>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-dim);margin-bottom:4px;">Jurusan</div>
                <div style="font-size:13px;font-weight:600;color:var(--primary-dark);">{{ $guruBk->jurusan->nama ?? '-' }}</div>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-dim);margin-bottom:4px;">Email</div>
                <div style="font-size:13px;font-weight:600;color:var(--primary-dark);">{{ $user->email }}</div>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-dim);margin-bottom:4px;">Status</div>
                <span class="badge badge-green">✅ Aktif</span>
            </div>
        </div>
        <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border);font-size:12px;color:var(--text-dim);">
            Profil hanya dapat diubah oleh Admin.
        </div>
    </div>
</div>
