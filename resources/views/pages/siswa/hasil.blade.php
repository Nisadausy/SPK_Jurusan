@extends('layouts.landing')

@section('title', 'Hasil Tes SPK - SMK Negeri 2 Jember')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<style>
    /* ── Sembunyikan navbar & footer hanya di halaman hasil ── */
    header, nav,
    .main-header, .top-bar,
    #mobile-menu, footer,
    .footer, [class*="navbar"],
    [class*="nav-bar"] {
        display: none !important;
    }
    main { padding-top: 0 !important; margin-top: 0 !important; }
    body  { padding-top: 0 !important; margin-top: 0 !important; }

    :root {
        --bg: #0d0f14; --surface: #161921; --surface2: #1e2330;
        --border: #2a2f3e; --accent: #f4b942; --accent2: #e07b54;
        --text: #e8eaf0; --text-dim: #8892aa; --green: #5cb85c;
        --radius: 16px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .hasil-wrapper {
        background: var(--bg); color: var(--text);
        font-family: 'DM Sans', sans-serif; min-height: 100vh;
        position: relative; overflow-x: hidden;
    }
    .bg-grain { position:fixed; inset:0; z-index:0; pointer-events:none; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E"); opacity:0.5; }
    .bg-glow  { position:fixed; top:-200px; left:-200px; width:700px; height:700px; background:radial-gradient(ellipse,rgba(244,185,66,.08) 0%,transparent 70%); pointer-events:none; z-index:0; }
    .bg-glow2 { position:fixed; bottom:-150px; right:-150px; width:500px; height:500px; background:radial-gradient(ellipse,rgba(224,123,84,.07) 0%,transparent 70%); pointer-events:none; z-index:0; }

    .hasil-container { position:relative; z-index:1; max-width:860px; margin:0 auto; padding:48px 20px 80px; }

    /* HEADER */
    .page-header { text-align:center; margin-bottom:40px; animation:fadeDown .7s ease both; }
    .header-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(244,185,66,.12); border:1px solid rgba(244,185,66,.25); color:var(--accent); font-size:11px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; padding:6px 16px; border-radius:100px; margin-bottom:18px; }
    .page-title { font-family:'Playfair Display',serif; font-size:clamp(1.8rem,5vw,2.8rem); font-weight:900; background:linear-gradient(135deg,#f4b942,#e8eaf0 60%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:8px; }
    .page-sub { color:var(--text-dim); font-size:14px; }

    /* ALERT */
    .alert-success { background:rgba(92,184,92,.08); border:1px solid rgba(92,184,92,.25); border-left:3px solid var(--green); border-radius:10px; padding:13px 18px; font-size:13px; color:#7dcc7d; margin-bottom:24px; }

    /* HERO RESULT */
    .result-hero { background:linear-gradient(135deg,#0f1520,#1a2540); border:1px solid var(--border); border-radius:var(--radius); padding:36px 32px; margin-bottom:24px; text-align:center; position:relative; overflow:hidden; box-shadow:0 4px 40px rgba(0,0,0,.4); animation:fadeIn .6s ease both; }
    .result-hero::after { content:''; position:absolute; bottom:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--accent),var(--accent2),var(--accent)); }
    .result-hero-icon { width:90px; height:90px; border-radius:50%; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-size:42px; margin:0 auto 20px; box-shadow:0 0 50px rgba(244,185,66,.35); }
    .result-hero-rank { font-size:11px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:rgba(244,185,66,.7); margin-bottom:6px; }
    .result-hero-name { font-family:'Playfair Display',serif; font-size:clamp(1.4rem,4vw,2rem); font-weight:900; color:var(--accent); margin-bottom:8px; }
    .result-hero-score { display:inline-flex; align-items:center; gap:8px; background:rgba(244,185,66,.1); border:1px solid rgba(244,185,66,.2); border-radius:100px; padding:6px 18px; font-size:14px; font-weight:700; color:var(--accent); margin-bottom:12px; }
    .result-hero-sub { font-size:13px; color:var(--text-dim); }

    /* INFO CARD */
    .info-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:24px 28px; margin-bottom:20px; box-shadow:0 4px 20px rgba(0,0,0,.2); }
    .info-card-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--accent); margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .info-card-title::after { content:''; flex:1; height:1px; background:var(--border); }
    .info-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; }
    .info-item { background:var(--surface2); border-radius:8px; padding:10px 14px; }
    .info-item-label { font-size:10px; color:var(--text-dim); font-weight:600; text-transform:uppercase; letter-spacing:.05em; margin-bottom:4px; }
    .info-item-value { font-size:14px; font-weight:700; color:var(--text); }

    /* RANKING */
    .ranking-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:24px 28px; margin-bottom:20px; box-shadow:0 4px 20px rgba(0,0,0,.2); }
    .rank-item { display:flex; align-items:center; gap:16px; background:var(--surface2); border:1.5px solid var(--border); border-radius:12px; padding:14px 18px; margin-bottom:10px; transition:border-color .2s; }
    .rank-item:last-child { margin-bottom:0; }
    .rank-item.top  { border-color:rgba(244,185,66,.4); background:rgba(244,185,66,.05); }
    .rank-item.top2 { border-color:rgba(192,192,192,.3); }
    .rank-item.top3 { border-color:rgba(205,127,50,.3); }
    .rank-num { width:36px; height:36px; border-radius:50%; background:var(--border); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; color:var(--text-dim); flex-shrink:0; }
    .rank-item.top  .rank-num { background:linear-gradient(135deg,var(--accent),var(--accent2)); color:#000; }
    .rank-item.top2 .rank-num { background:linear-gradient(135deg,#c0c0c0,#a0a0a0); color:#000; }
    .rank-item.top3 .rank-num { background:linear-gradient(135deg,#cd7f32,#a0522d); color:#fff; }
    .rank-info { flex:1; min-width:0; }
    .rank-nama { font-size:14px; font-weight:600; color:var(--text); margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .rank-bar-wrap { height:6px; background:var(--bg); border-radius:100px; overflow:hidden; }
    .rank-bar-fill { height:100%; border-radius:100px; background:linear-gradient(90deg,var(--accent),var(--accent2)); transition:width 1.2s cubic-bezier(.4,0,.2,1); }
    .rank-score { font-size:16px; font-weight:800; color:var(--accent); flex-shrink:0; }

    /* SAW TABLE */
    .saw-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:24px 28px; margin-bottom:20px; box-shadow:0 4px 20px rgba(0,0,0,.2); }
    .table-wrap { overflow-x:auto; margin-top:16px; }
    .saw-table { width:100%; border-collapse:collapse; font-size:12px; min-width:500px; }
    .saw-table th { background:var(--surface2); color:var(--text-dim); font-weight:700; padding:10px 12px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap; }
    .saw-table td { padding:10px 12px; border-bottom:1px solid rgba(42,47,62,.5); color:var(--text-dim); }
    .saw-table tr.best td { color:var(--accent); font-weight:700; }
    .saw-table tr:last-child td { border-bottom:none; }
    .saw-table .score-col { font-weight:700; color:var(--text); }

    /* BUTTONS */
    .btn-group { display:flex; gap:12px; flex-wrap:wrap; justify-content:center; margin-top:28px; }
    .btn { display:inline-flex; align-items:center; gap:8px; font-family:'DM Sans',sans-serif; font-size:14px; font-weight:700; padding:13px 26px; border-radius:10px; cursor:pointer; border:none; transition:all .22s; text-decoration:none; }
    .btn-ghost { background:transparent; color:var(--text-dim); border:1.5px solid var(--border); }
    .btn-ghost:hover { border-color:var(--accent); color:var(--accent); }
    .btn-pdf { background:linear-gradient(135deg,#1a3c6e,#0f2548); color:white; box-shadow:0 4px 18px rgba(15,37,72,.35); }
    .btn-pdf:hover { transform:translateY(-2px); box-shadow:0 8px 26px rgba(15,37,72,.5); }
    .btn-print { background:linear-gradient(135deg,var(--accent),var(--accent2)); color:#111; box-shadow:0 4px 18px rgba(244,185,66,.25); }
    .btn-print:hover { transform:translateY(-2px); box-shadow:0 8px 26px rgba(244,185,66,.4); }

    @keyframes fadeIn   { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeDown { from{opacity:0;transform:translateY(-14px)} to{opacity:1;transform:translateY(0)} }

    @media(max-width:640px) {
        .hasil-container { padding:28px 14px 60px; }
        .info-grid { grid-template-columns:1fr 1fr; }
        .result-hero { padding:28px 20px; }
        .rank-item { gap:10px; padding:12px 14px; }
        .btn-group { flex-direction:column; }
        .btn { width:100%; justify-content:center; }
    }
</style>
@endpush

@section('content')
<div class="hasil-wrapper">
    <div class="bg-grain"></div>
    <div class="bg-glow"></div>
    <div class="bg-glow2"></div>

    <div class="hasil-container">

        {{-- HEADER --}}
        <div class="page-header">
            <div class="header-badge">🎯 Hasil Analisis SAW</div>
            <h1 class="page-title">Rekomendasi Jurusan</h1>
            <p class="page-sub">Hasil perhitungan Simple Additive Weighting berdasarkan nilai dan minat bakat kamu</p>
        </div>

        @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        @php
            $rekomendasi = $hasilList->first();
            $namaField = $siswa->nama_lengkap
                      ?? $siswa->nama
                      ?? $siswa->name
                      ?? Auth::user()->name
                      ?? 'Siswa';

            $jurusanIkon = [
                'Alat Berat'  => '🚜', 'Otomotif'    => '🚗',
                'Motor'       => '🏍️', 'Pemesinan'   => '🔧',
                'Mekatronika' => '🤖', 'Konstruksi'  => '🏗️',
                'Bangunan'    => '🏗️', 'Listrik'     => '⚡',
                'Pembangkit'  => '🔋', 'Audio'       => '📺',
                'Komputer'    => '💻', 'Desain'      => '🎨',
            ];
            $ikon = '🏆';
            foreach ($jurusanIkon as $kata => $ico) {
                if (str_contains($rekomendasi->jurusan->nama_jurusan ?? '', $kata)) {
                    $ikon = $ico; break;
                }
            }
        @endphp

        {{-- HERO RESULT --}}
        <div class="result-hero">
            <div class="result-hero-icon">{{ $ikon }}</div>
            <div class="result-hero-rank">🏆 Rekomendasi #1 Untukmu</div>
            <div class="result-hero-name">{{ $rekomendasi->jurusan->nama_jurusan ?? '-' }}</div>
            <div class="result-hero-score">
                ⭐ Skor SAW: {{ number_format($rekomendasi->nilai_preferensi * 100, 2) }}%
            </div>
            <p class="result-hero-sub">
                Halo <strong style="color:var(--text)">{{ $namaField }}</strong>,
                berdasarkan nilai akademik dan minat bakat kamu, jurusan ini paling sesuai untukmu.
            </p>
        </div>

        {{-- INFO TES --}}
        <div class="info-card">
            <div class="info-card-title">📋 Data Tes</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-item-label">Tanggal Tes</div>
                    <div class="info-item-value">{{ $tesTerakhir->created_at->format('d M Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">Nilai Akademik</div>
                    <div class="info-item-value">{{ number_format($tesTerakhir->nilai_akademik, 1) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">Skor Minat</div>
                    <div class="info-item-value">{{ $tesTerakhir->skor_minat_bakat }}%</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">Tinggi / Berat</div>
                    <div class="info-item-value">{{ $tesTerakhir->tinggi_badan }}cm / {{ $tesTerakhir->berat_badan }}kg</div>
                </div>
            </div>
        </div>

        {{-- RANKING LIST --}}
        <div class="ranking-card">
            <div class="info-card-title">🏅 Ranking Semua Jurusan</div>
            @foreach($hasilList as $i => $hasil)
            @php
                $rankClass = $i === 0 ? 'top' : ($i === 1 ? 'top2' : ($i === 2 ? 'top3' : ''));
                $pct       = number_format($hasil->nilai_preferensi * 100, 2);
                $barWidth  = number_format(($hasil->nilai_preferensi / $hasilList->first()->nilai_preferensi) * 100, 1);
            @endphp
            <div class="rank-item {{ $rankClass }}">
                <div class="rank-num">{{ $hasil->peringkat }}</div>
                <div class="rank-info">
                    <div class="rank-nama">{{ $hasil->jurusan->nama_jurusan ?? '-' }}</div>
                    <div class="rank-bar-wrap">
                        <div class="rank-bar-fill" style="width:0%" data-target="{{ $barWidth }}%"></div>
                    </div>
                </div>
                <div class="rank-score">{{ $pct }}%</div>
            </div>
            @endforeach
        </div>

        {{-- TABEL DETAIL SAW --}}
        <div class="saw-card">
            <div class="info-card-title">📊 Detail Nilai Preferensi SAW</div>
            <div class="table-wrap">
                <table class="saw-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Jurusan</th>
                            <th>Nilai Preferensi (V)</th>
                            <th>Skor (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasilList as $i => $hasil)
                        <tr class="{{ $i === 0 ? 'best' : '' }}">
                            <td>{{ $hasil->peringkat }}</td>
                            <td>{{ $hasil->jurusan->nama_jurusan ?? '-' }}</td>
                            <td class="score-col">{{ number_format($hasil->nilai_preferensi, 6) }}</td>
                            <td><strong>{{ number_format($hasil->nilai_preferensi * 100, 2) }}%</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="btn-group">
            <a href="{{ route('siswa.tes.index') }}" class="btn btn-ghost">🔄 Ulangi Tes</a>
            <a href="{{ route('siswa.tes.cetak') }}" class="btn btn-pdf" target="_blank">📄 Cetak / Download PDF</a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    setTimeout(() => {
        document.querySelectorAll('.rank-bar-fill').forEach(el => {
            el.style.width = el.dataset.target;
        });
    }, 300);
</script>
@endpush