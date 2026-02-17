@extends('layouts.landing')

@section('title', 'Tes SPK - SMK Negeri 2 Jember')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<style>
    /* ============================================================
       ROOT & RESET
    ============================================================ */
    :root {
        --bg:        #0d0f14;
        --surface:   #161921;
        --surface2:  #1e2330;
        --border:    #2a2f3e;
        --accent:    #f4b942;
        --accent2:   #e07b54;
        --text:      #e8eaf0;
        --text-dim:  #8892aa;
        --green:     #5cb85c;
        --danger:    #e05454;
        --radius:    16px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ── Sembunyikan navbar hanya di halaman tes ── */
    header, nav,
    .main-header, .top-bar,
    #mobile-menu, footer,
    .footer, [class*="navbar"],
    [class*="nav-bar"] {
        display: none !important;
    }
    main { padding-top: 0 !important; margin-top: 0 !important; }
    body  { padding-top: 0 !important; margin-top: 0 !important; }

    .spk-wrapper {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    /* BG FX */
    .bg-grain {
        position: fixed; inset: 0; z-index: 0; pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        opacity: 0.5;
    }
    .bg-glow  { position:fixed; top:-200px; left:-200px; width:700px; height:700px; background:radial-gradient(ellipse,rgba(244,185,66,.08) 0%,transparent 70%); pointer-events:none; z-index:0; }
    .bg-glow2 { position:fixed; bottom:-150px; right:-150px; width:500px; height:500px; background:radial-gradient(ellipse,rgba(224,123,84,.07) 0%,transparent 70%); pointer-events:none; z-index:0; }

    /* LAYOUT */
    .spk-container {
        position: relative; z-index: 1;
        max-width: 860px; margin: 0 auto; padding: 48px 20px 80px;
    }

    /* PAGE HEADER */
    .page-header { text-align: center; margin-bottom: 44px; animation: fadeDown .7s ease both; }
    .header-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(244,185,66,.12); border: 1px solid rgba(244,185,66,.25);
        color: var(--accent); font-size: 11px; font-weight: 600; letter-spacing: .1em;
        text-transform: uppercase; padding: 6px 16px; border-radius: 100px; margin-bottom: 18px;
    }
    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.9rem, 5vw, 3rem); font-weight: 900; line-height: 1.15;
        background: linear-gradient(135deg, #f4b942, #e8eaf0 60%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 10px;
    }
    .page-sub { color: var(--text-dim); font-size: 14px; max-width: 480px; margin: 0 auto; line-height: 1.6; }

    /* PROGRESS */
    .progress-bar-wrap { background: var(--surface2); border-radius: 100px; height: 6px; margin-bottom: 10px; overflow: hidden; }
    .progress-bar-fill { height: 100%; border-radius: 100px; background: linear-gradient(90deg, var(--accent), var(--accent2)); transition: width .5s cubic-bezier(.4,0,.2,1); }
    .progress-label { display: flex; justify-content: space-between; font-size: 12px; color: var(--text-dim); margin-bottom: 28px; }

    /* STEPPER */
    .stepper { display: flex; align-items: flex-start; margin-bottom: 32px; animation: fadeIn .5s ease both .1s; }
    .step-item-nav { display: flex; flex-direction: column; align-items: center; gap: 7px; flex: 1; position: relative; }
    .step-item-nav::after {
        content: ''; position: absolute; top: 17px;
        left: calc(50% + 18px); right: calc(-50% + 18px);
        height: 2px; background: var(--border); z-index: 0; transition: background .4s;
    }
    .step-item-nav:last-child::after { display: none; }
    .step-item-nav.done::after   { background: var(--green); }
    .step-item-nav.active::after { background: linear-gradient(90deg, var(--green), var(--border)); }
    .step-circle {
        width: 34px; height: 34px; border-radius: 50%; border: 2px solid var(--border);
        background: var(--surface); display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 800; color: var(--text-dim);
        position: relative; z-index: 1; transition: all .3s cubic-bezier(.4,0,.2,1);
        box-shadow: 0 2px 8px rgba(0,0,0,.3);
    }
    .step-item-nav.active .step-circle { border-color: var(--accent); background: var(--accent); color: #111; box-shadow: 0 0 0 4px rgba(244,185,66,.2), 0 2px 8px rgba(0,0,0,.3); transform: scale(1.1); }
    .step-item-nav.done   .step-circle { border-color: var(--green);  background: var(--green);  color: white; box-shadow: 0 0 0 4px rgba(92,184,92,.15), 0 2px 8px rgba(0,0,0,.3); }
    .step-label { font-size: 10px; font-weight: 600; color: var(--text-dim); text-align: center; line-height: 1.3; max-width: 64px; transition: color .3s; }
    .step-item-nav.active .step-label { color: var(--accent); }
    .step-item-nav.done   .step-label { color: var(--green); }

    /* STEP PANELS */
    .step-panel { display: none; }
    .step-panel.active { display: block; animation: slideIn .35s ease both; }

    /* CARD */
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 40px rgba(0,0,0,.35); }
    .card-header {
        background: linear-gradient(135deg, #0f1520, #1a2540);
        border-bottom: 1px solid var(--border); padding: 24px 30px; position: relative; overflow: hidden;
    }
    .card-header::before { content:''; position:absolute; top:-40px; right:-40px; width:160px; height:160px; border-radius:50%; background:rgba(244,185,66,.04); }
    .card-header::after  { content:''; position:absolute; bottom:0; left:0; right:0; height:2px; background:linear-gradient(90deg,var(--accent),var(--accent2),var(--accent)); }
    .card-step-label { font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(244,185,66,.7); margin-bottom: 5px; }
    .card-title { font-family: 'Playfair Display', serif; font-size: clamp(1.1rem,3vw,1.35rem); font-weight: 700; color: var(--text); line-height: 1.3; }
    .card-sub { font-size: 12px; color: var(--text-dim); margin-top: 4px; line-height: 1.5; }
    .card-body { padding: 28px 30px; }

    /* SECTION DIVIDER */
    .section-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: var(--accent); margin: 22px 0 14px; display: flex; align-items: center; gap: 10px; }
    .section-label::after { content:''; flex:1; height:1px; background:var(--border); }
    .section-label:first-child { margin-top: 0; }

    /* FORM FIELDS */
    .form-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    .form-grid.col3 { grid-template-columns: 1fr 1fr 1fr; }
    .form-grid.full { grid-template-columns: 1fr; }
    .field label { display: block; font-size: 11px; font-weight: 700; color: var(--text-dim); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 7px; }
    .field label .req { color: var(--danger); }
    .field input, .field select {
        width: 100%; background: var(--surface2); border: 1.5px solid var(--border);
        border-radius: 10px; color: var(--text); font-family: 'DM Sans', sans-serif;
        font-size: 13px; padding: 11px 14px; transition: border-color .2s, box-shadow .2s; outline: none; -webkit-appearance: none;
    }
    .field input:hover, .field select:hover { border-color: #3a4255; }
    .field input:focus, .field select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(244,185,66,.1); background: #21263a; }
    .field select option { background: var(--surface2); }
    .field input.has-unit { padding-right: 42px; }
    .input-wrap { position: relative; }
    .input-unit { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 10px; font-weight: 700; color: var(--text-dim); background: var(--border); padding: 2px 6px; border-radius: 4px; pointer-events: none; }
    .field-hint { font-size: 11px; color: var(--text-dim); margin-top: 5px; }

    /* ALERT */
    .alert-box { border-radius: 10px; padding: 13px 16px; margin-bottom: 20px; font-size: 12px; line-height: 1.6; display: flex; align-items: flex-start; gap: 10px; }
    .alert-warn { background: rgba(244,185,66,.07); border: 1px solid rgba(244,185,66,.2); border-left: 3px solid var(--accent); color: #c8a060; }
    .alert-warn strong { color: var(--accent); }
    .alert-error { background: rgba(224,84,84,.08); border: 1px solid rgba(224,84,84,.25); border-left: 3px solid var(--danger); color: #f08080; border-radius: 10px; padding: 13px 16px; margin-bottom: 20px; font-size: 12px; line-height: 1.7; }
    .alert-error ul { padding-left: 16px; margin-top: 6px; }
    .alert-info { background: rgba(92,184,92,.07); border: 1px solid rgba(92,184,92,.2); border-left: 3px solid var(--green); color: #7dcc7d; }

    /* TOGGLE */
    .toggle-group { display: flex; gap: 10px; }
    .toggle-btn { flex: 1; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 12px; font-weight: 600; cursor: pointer; text-align: center; transition: all .2s; background: var(--surface2); color: var(--text-dim); font-family: 'DM Sans', sans-serif; user-select: none; }
    .toggle-btn:hover { border-color: #3a4255; color: var(--text); }
    .toggle-btn.sel-ya    { border-color: var(--danger); background: rgba(224,84,84,.1);  color: #f08080; }
    .toggle-btn.sel-tidak { border-color: var(--green);  background: rgba(92,184,92,.1);  color: #7dcc7d; }

    /* RADIO CARDS */
    .radio-card-group { display: flex; gap: 10px; flex-wrap: wrap; }
    .radio-card { flex: 1; min-width: 130px; border: 1.5px solid var(--border); border-radius: 10px; padding: 12px 16px; cursor: pointer; transition: all .2s; display: flex; align-items: center; gap: 10px; background: var(--surface2); user-select: none; }
    .radio-card:hover { border-color: rgba(244,185,66,.4); background: rgba(244,185,66,.05); }
    .radio-card input[type="radio"] { accent-color: var(--accent); width: 15px; height: 15px; flex-shrink: 0; }
    .radio-card.selected { border-color: var(--accent); background: rgba(244,185,66,.08); box-shadow: 0 0 0 3px rgba(244,185,66,.1); }
    .radio-card-label { font-size: 13px; font-weight: 600; color: var(--text); }

    /* BMI CARD */
    #bmiCard { display: none; background: linear-gradient(135deg, #161d2a, #1a2135); border: 1.5px solid var(--border); border-radius: 10px; padding: 16px 20px; margin-bottom: 18px; animation: fadeIn .4s ease; }
    .bmi-label { font-size: 10px; color: var(--text-dim); font-weight: 700; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 8px; }
    .bmi-row   { display: flex; align-items: center; gap: 14px; }
    .bmi-num   { font-size: 2.2rem; font-weight: 900; color: var(--text); line-height: 1; font-family: 'Playfair Display', serif; }
    .bmi-cat   { font-size: 13px; font-weight: 700; }
    .bmi-sub   { font-size: 11px; color: var(--text-dim); margin-top: 2px; }

    /* NILAI CARDS */
    .nilai-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
    .nilai-card { background: var(--surface2); border: 1.5px solid var(--border); border-radius: 10px; padding: 14px 16px; transition: all .2s; }
    .nilai-card:focus-within { border-color: var(--accent); background: #21263a; box-shadow: 0 0 0 3px rgba(244,185,66,.1); }
    .nilai-label { font-size: 10px; font-weight: 700; color: var(--text-dim); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px; }
    .nilai-input { width: 100%; background: transparent; border: none; border-bottom: 2px solid var(--border); color: var(--text); font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; outline: none; padding: 4px 0; transition: border-color .2s; }
    .nilai-input:focus { border-color: var(--accent); }
    .nilai-scale { font-size: 10px; color: var(--text-dim); margin-top: 5px; }

    /* BAKAT QUESTIONS */
    .bakat-question { background: var(--surface2); border: 1.5px solid var(--border); border-radius: 12px; padding: 18px 20px; margin-bottom: 12px; transition: all .2s; }
    .bakat-question:hover    { border-color: rgba(244,185,66,.2); }
    .bakat-question.answered { border-color: rgba(92,184,92,.3); background: rgba(92,184,92,.04); }
    .bakat-q-num  { font-size: 10px; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 5px; }
    .bakat-q-text { font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 14px; line-height: 1.55; }
    .bakat-options { display: flex; gap: 7px; flex-wrap: wrap; }
    .bakat-opt { flex: 1; min-width: 100px; padding: 9px 8px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer; text-align: center; transition: all .2s; background: var(--bg); color: var(--text-dim); font-family: 'DM Sans', sans-serif; user-select: none; }
    .bakat-opt:hover { border-color: rgba(244,185,66,.4); color: var(--text); }
    .bakat-opt.selected { border-color: var(--accent); background: rgba(244,185,66,.12); color: var(--accent); font-weight: 700; box-shadow: 0 2px 8px rgba(244,185,66,.2); }
    .bakat-opt input { display: none; }

    /* SETUJU CHECKBOX */
    .setuju-box {
        background: rgba(244,185,66,.06); border: 1.5px solid rgba(244,185,66,.2);
        border-radius: 12px; padding: 18px 20px;
        display: flex; align-items: flex-start; gap: 14px; cursor: pointer;
        transition: all .2s; margin-top: 20px;
    }
    .setuju-box:hover { border-color: var(--accent); background: rgba(244,185,66,.1); }
    .setuju-box input[type="checkbox"] { accent-color: var(--accent); width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px; cursor: pointer; }
    .setuju-box-text { font-size: 13px; color: var(--text-dim); line-height: 1.6; }
    .setuju-box-text strong { color: var(--accent); }

    /* REVIEW */
    .review-section { margin-bottom: 20px; }
    .review-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--text-dim); margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
    .review-title::after { content:''; flex:1; height:1px; background:var(--border); }
    .review-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .review-item { background: var(--surface2); border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; transition: border-color .2s; }
    .review-item:hover { border-color: rgba(244,185,66,.3); }
    .review-item-label { font-size: 10px; color: var(--text-dim); margin-bottom: 3px; font-weight: 600; }
    .review-item-value { font-size: 13px; font-weight: 700; color: var(--text); }

    /* BUTTONS */
    .btn-nav { display: flex; gap: 12px; justify-content: space-between; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border); flex-wrap: wrap; }
    .btn-prev { padding: 11px 22px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px; font-weight: 600; color: var(--text-dim); background: transparent; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
    .btn-prev:hover { border-color: var(--accent); color: var(--accent); }
    .btn-next { padding: 11px 26px; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; color: #111; background: linear-gradient(135deg, var(--accent), var(--accent2)); cursor: pointer; transition: all .22s; margin-left: auto; font-family: 'DM Sans', sans-serif; box-shadow: 0 4px 18px rgba(244,185,66,.25); }
    .btn-next:hover { transform: translateY(-2px); box-shadow: 0 8px 26px rgba(244,185,66,.4); }
    .btn-submit { padding: 13px 30px; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; color: white; background: linear-gradient(135deg, #1a3c6e, #0f2548); cursor: pointer; transition: all .3s; margin-left: auto; font-family: 'DM Sans', sans-serif; box-shadow: 0 4px 18px rgba(15,37,72,.4); }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(15,37,72,.5); }
    .btn-submit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

    /* TOAST */
    .toast { position: fixed; top: 20px; right: 20px; z-index: 9999; background: var(--accent2); color: white; font-size: 13px; font-weight: 600; padding: 12px 20px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,.4); display: none; font-family: 'DM Sans', sans-serif; }

    /* ANIMATIONS */
    @keyframes fadeIn   { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeDown { from{opacity:0;transform:translateY(-14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes slideIn  { from{opacity:0;transform:translateX(16px)} to{opacity:1;transform:translateX(0)} }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .nilai-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 640px) {
        .spk-container { padding: 28px 14px 60px; }
        .card-body { padding: 20px 18px; }
        .card-header { padding: 20px 18px; }
        .form-grid, .form-grid.col3 { grid-template-columns: 1fr; }
        .nilai-grid { grid-template-columns: 1fr 1fr; }
        .review-grid { grid-template-columns: 1fr; }
        .step-label  { display: none; }
        .step-circle { width: 28px; height: 28px; font-size: 10px; }
        .step-item-nav::after { top: 14px; left: calc(50% + 15px); right: calc(-50% + 15px); }
        .bakat-options { flex-direction: column; }
        .bakat-opt    { min-width: 100%; }
        .toggle-group { flex-direction: column; }
        .radio-card-group { flex-direction: column; }
        .btn-nav      { flex-direction: column; }
        .btn-next, .btn-submit { margin-left: 0; width: 100%; justify-content: center; }
        .btn-prev     { width: 100%; text-align: center; }
    }
    @media (max-width: 400px) {
        .nilai-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="spk-wrapper">
    <div class="bg-grain"></div>
    <div class="bg-glow"></div>
    <div class="bg-glow2"></div>
    <div class="toast" id="toast"></div>

    <div class="spk-container">

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="header-badge">🎯 Sistem Pendukung Keputusan</div>
            <h1 class="page-title">Tes Minat &amp; Bakat<br/>Siswa</h1>
            <p class="page-sub">Temukan jurusan terbaik untukmu melalui analisis terukur menggunakan metode SAW.</p>
        </div>

        {{-- LARAVEL ERRORS --}}
        @if($errors->any())
        <div class="alert-error">
            <strong>⚠ Harap perbaiki kesalahan berikut:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif
        @if(session('info'))
        <div class="alert-box alert-info">ℹ️ {{ session('info') }}</div>
        @endif

        {{-- PROGRESS --}}
        <div class="progress-bar-wrap">
            <div class="progress-bar-fill" id="progressFill" style="width:25%"></div>
        </div>
        <div class="progress-label">
            <span id="progressLabel">Langkah 1 dari 4</span>
            <span id="progressPct">25%</span>
        </div>

        {{-- STEPPER --}}
        <div class="stepper">
            <div class="step-item-nav active" id="nav-0"><div class="step-circle">1</div><div class="step-label">Data Fisik</div></div>
            <div class="step-item-nav"         id="nav-1"><div class="step-circle">2</div><div class="step-label">Nilai</div></div>
            <div class="step-item-nav"         id="nav-2"><div class="step-circle">3</div><div class="step-label">Minat Bakat</div></div>
            <div class="step-item-nav"         id="nav-3"><div class="step-circle">4</div><div class="step-label">Review</div></div>
        </div>

        {{-- FORM — action & name attributes 100% sesuai SpkController --}}
        <form id="spkForm" method="POST" action="{{ route('siswa.tes.simpan') }}">
        @csrf

        {{-- ================================================
             STEP 1 — DATA FISIK & KESEHATAN
             Controller: tinggi_badan, berat_badan, buta_warna, jenis_kelamin
        ================================================ --}}
        <div class="step-panel active" id="step-0">
            <div class="card">
                <div class="card-header">
                    <div class="card-step-label">Langkah 1 dari 4</div>
                    <div class="card-title">📏 Data Fisik &amp; Kesehatan</div>
                    <div class="card-sub">Isi data fisik kamu dengan jujur dan akurat</div>
                </div>
                <div class="card-body">

                    <div class="alert-box alert-warn">
                        <span>⚠️</span>
                        <div><strong>Catatan:</strong> Beberapa jurusan memiliki persyaratan fisik tertentu. Isi data yang sebenarnya.</div>
                    </div>

                    <div class="form-grid">
                        <div class="field">
                            <label>Tinggi Badan <span class="req">*</span></label>
                            <div class="input-wrap">
                                <input type="number" name="tinggi_badan" id="tinggi_badan"
                                    class="has-unit" placeholder="165" min="100" max="220"
                                    value="{{ old('tinggi_badan') }}" required />
                                <span class="input-unit">cm</span>
                            </div>
                            <div class="field-hint">Dalam satuan sentimeter</div>
                        </div>
                        <div class="field">
                            <label>Berat Badan <span class="req">*</span></label>
                            <div class="input-wrap">
                                <input type="number" name="berat_badan" id="berat_badan"
                                    class="has-unit" placeholder="55" min="20" max="200"
                                    value="{{ old('berat_badan') }}" required />
                                <span class="input-unit">kg</span>
                            </div>
                            <div class="field-hint">Dalam satuan kilogram</div>
                        </div>
                    </div>

                    {{-- BMI PREVIEW --}}
                    <div id="bmiCard">
                        <div class="bmi-label">Indeks Massa Tubuh (BMI)</div>
                        <div class="bmi-row">
                            <div id="bmiValue" class="bmi-num">—</div>
                            <div>
                                <div id="bmiCategory" class="bmi-cat">—</div>
                                <div class="bmi-sub">Kategori BMI kamu</div>
                            </div>
                        </div>
                    </div>

                    <div class="section-label">Kondisi Kesehatan</div>

                    <div class="field" style="margin-bottom:18px">
                        <label>Apakah kamu mengalami buta warna? <span class="req">*</span></label>
                        <div class="toggle-group">
                            <div class="toggle-btn" id="btnButaYa"    onclick="setButaWarna('ya')">🔴 Ya, Buta Warna</div>
                            <div class="toggle-btn" id="btnButaTidak" onclick="setButaWarna('tidak')">🟢 Tidak, Normal</div>
                        </div>
                        {{-- name="buta_warna" sesuai controller: in:ya,tidak --}}
                        <input type="hidden" name="buta_warna" id="buta_warna" value="{{ old('buta_warna') }}" />
                    </div>

                    <div class="section-label">Identitas</div>

                    <div class="field">
                        <label>Jenis Kelamin <span class="req">*</span></label>
                        <div class="radio-card-group">
                            {{-- name="jenis_kelamin" sesuai controller: in:laki-laki,perempuan --}}
                            <label class="radio-card {{ old('jenis_kelamin') === 'laki-laki' ? 'selected' : '' }}" onclick="selectGender(this)">
                                <input type="radio" name="jenis_kelamin" value="laki-laki" required
                                    {{ old('jenis_kelamin') === 'laki-laki' ? 'checked' : '' }} />
                                <span class="radio-card-label">👦 Laki-laki</span>
                            </label>
                            <label class="radio-card {{ old('jenis_kelamin') === 'perempuan' ? 'selected' : '' }}" onclick="selectGender(this)">
                                <input type="radio" name="jenis_kelamin" value="perempuan" required
                                    {{ old('jenis_kelamin') === 'perempuan' ? 'checked' : '' }} />
                                <span class="radio-card-label">👧 Perempuan</span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="btn-nav">
                <div></div>
                <button type="button" class="btn-next" onclick="nextStep(0)">Selanjutnya: Nilai Akademik →</button>
            </div>
        </div>

        {{-- ================================================
             STEP 2 — NILAI AKADEMIK
             Controller: nilai_matematika, nilai_bahasa_indonesia, nilai_bahasa_inggris,
                         nilai_ipa, nilai_ips, nilai_fisika, nilai_biologi, nilai_pkn
        ================================================ --}}
        <div class="step-panel" id="step-1">
            <div class="card">
                <div class="card-header">
                    <div class="card-step-label">Langkah 2 dari 4</div>
                    <div class="card-title">📚 Nilai Akademik</div>
                    <div class="card-sub">Masukkan nilai rata-rata per mata pelajaran (skala 0 – 100)</div>
                </div>
                <div class="card-body">

                    <div class="section-label">Mata Pelajaran</div>
                    <div class="nilai-grid">
                        <div class="nilai-card">
                            <div class="nilai-label">Matematika</div>
                            <input type="number" name="nilai_matematika" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_matematika') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                        <div class="nilai-card">
                            <div class="nilai-label">Bahasa Indonesia</div>
                            <input type="number" name="nilai_bahasa_indonesia" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_bahasa_indonesia') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                        <div class="nilai-card">
                            <div class="nilai-label">Bahasa Inggris</div>
                            <input type="number" name="nilai_bahasa_inggris" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_bahasa_inggris') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                        <div class="nilai-card">
                            <div class="nilai-label">IPA</div>
                            <input type="number" name="nilai_ipa" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_ipa') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                        <div class="nilai-card">
                            <div class="nilai-label">IPS</div>
                            <input type="number" name="nilai_ips" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_ips') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                        <div class="nilai-card">
                            <div class="nilai-label">Fisika</div>
                            <input type="number" name="nilai_fisika" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_fisika') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                        <div class="nilai-card">
                            <div class="nilai-label">Biologi</div>
                            <input type="number" name="nilai_biologi" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_biologi') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                        <div class="nilai-card">
                            <div class="nilai-label">PPKN</div>
                            <input type="number" name="nilai_pkn" class="nilai-input"
                                placeholder="85" min="0" max="100" value="{{ old('nilai_pkn') }}" required />
                            <div class="nilai-scale">0 – 100</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="btn-nav">
                <button type="button" class="btn-prev" onclick="prevStep(1)">← Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(1)">Selanjutnya: Minat Bakat →</button>
            </div>
        </div>

        {{-- ================================================
             STEP 3 — TES MINAT BAKAT
             Controller: bakat_q1 .. bakat_q10, value 1..4
             Sesuai SoalMinat dari DB ($soal dari index())
        ================================================ --}}
        <div class="step-panel" id="step-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-step-label">Langkah 3 dari 4</div>
                    <div class="card-title">🧠 Tes Minat &amp; Bakat</div>
                    <div class="card-sub">Pilih jawaban yang paling menggambarkan dirimu</div>
                </div>
                <div class="card-body">

                    @php
                    // Opsi jawaban: value 1..4 sesuai controller (min:1|max:4)
                    $opsiJawaban = [
                        1 => 'Sangat Tidak Setuju',
                        2 => 'Tidak Setuju',
                        3 => 'Setuju',
                        4 => 'Sangat Setuju',
                    ];
                    @endphp

                    @if(isset($soal) && $soal->count() > 0)
                        {{-- Soal dari database via controller --}}
                        @foreach($soal as $i => $s)
                        <div class="bakat-question {{ old("bakat_q".($i+1)) ? 'answered' : '' }}" id="bq_{{ $i+1 }}">
                            <div class="bakat-q-num">Pertanyaan {{ $i + 1 }}</div>
                            <div class="bakat-q-text">{{ $s->pertanyaan ?? $s->soal ?? $s->teks ?? 'Pertanyaan '.($i+1) }}</div>
                            <div class="bakat-options">
                                @foreach($opsiJawaban as $val => $lbl)
                                <label class="bakat-opt {{ old("bakat_q".($i+1)) == $val ? 'selected' : '' }}"
                                    onclick="pilihBakat(this, {{ $i+1 }})">
                                    {{-- name="bakat_q1" s/d "bakat_q10" sesuai controller --}}
                                    <input type="radio" name="bakat_q{{ $i+1 }}" value="{{ $val }}"
                                        {{ old("bakat_q".($i+1)) == $val ? 'checked' : '' }} />
                                    {{ $lbl }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @else
                        {{-- Fallback: soal hardcode jika DB kosong --}}
                        @php
                        $soalFallback = [
                            1  => 'Saya suka memecahkan soal matematika atau logika.',
                            2  => 'Saya tertarik mempelajari bagaimana teknologi dan komputer bekerja.',
                            3  => 'Saya senang melakukan eksperimen atau percobaan ilmiah.',
                            4  => 'Saya mudah memahami konsep-konsep sains dan teknik.',
                            5  => 'Saya senang berbicara dan berinteraksi dengan banyak orang.',
                            6  => 'Saya tertarik membantu orang lain memecahkan masalah mereka.',
                            7  => 'Saya suka menggambar, melukis, atau membuat karya visual.',
                            8  => 'Saya tertarik pada dunia desain, musik, atau seni.',
                            9  => 'Saya suka berdagang atau merencanakan bisnis.',
                            10 => 'Saya senang bernegosiasi dan meyakinkan orang lain.',
                        ];
                        @endphp
                        @foreach($soalFallback as $no => $teks)
                        <div class="bakat-question {{ old("bakat_q{$no}") ? 'answered' : '' }}" id="bq_{{ $no }}">
                            <div class="bakat-q-num">Pertanyaan {{ $no }}</div>
                            <div class="bakat-q-text">{{ $teks }}</div>
                            <div class="bakat-options">
                                @foreach($opsiJawaban as $val => $lbl)
                                <label class="bakat-opt {{ old("bakat_q{$no}") == $val ? 'selected' : '' }}"
                                    onclick="pilihBakat(this, {{ $no }})">
                                    <input type="radio" name="bakat_q{{ $no }}" value="{{ $val }}"
                                        {{ old("bakat_q{$no}") == $val ? 'checked' : '' }} />
                                    {{ $lbl }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <div class="btn-nav">
                <button type="button" class="btn-prev" onclick="prevStep(2)">← Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(2)">Review &amp; Kirim →</button>
            </div>
        </div>

        {{-- ================================================
             STEP 4 — REVIEW & SUBMIT
             Controller: setuju required|in:1
        ================================================ --}}
        <div class="step-panel" id="step-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-step-label">Langkah 4 dari 4</div>
                    <div class="card-title">✅ Review &amp; Kirim</div>
                    <div class="card-sub">Periksa kembali semua data sebelum dikirim</div>
                </div>
                <div class="card-body">

                    <div class="review-section">
                        <div class="review-title">Data Fisik</div>
                        <div class="review-grid">
                            <div class="review-item"><div class="review-item-label">Tinggi Badan</div><div class="review-item-value" id="rev-tinggi">—</div></div>
                            <div class="review-item"><div class="review-item-label">Berat Badan</div><div class="review-item-value" id="rev-berat">—</div></div>
                            <div class="review-item"><div class="review-item-label">Buta Warna</div><div class="review-item-value" id="rev-buta">—</div></div>
                            <div class="review-item"><div class="review-item-label">Jenis Kelamin</div><div class="review-item-value" id="rev-gender">—</div></div>
                        </div>
                    </div>

                    <div class="review-section">
                        <div class="review-title">Nilai Akademik</div>
                        <div class="review-grid">
                            <div class="review-item"><div class="review-item-label">Matematika</div><div class="review-item-value" id="rev-mtk">—</div></div>
                            <div class="review-item"><div class="review-item-label">Bahasa Indonesia</div><div class="review-item-value" id="rev-bind">—</div></div>
                            <div class="review-item"><div class="review-item-label">Bahasa Inggris</div><div class="review-item-value" id="rev-bing">—</div></div>
                            <div class="review-item"><div class="review-item-label">IPA</div><div class="review-item-value" id="rev-ipa">—</div></div>
                            <div class="review-item"><div class="review-item-label">IPS</div><div class="review-item-value" id="rev-ips">—</div></div>
                            <div class="review-item"><div class="review-item-label">Fisika</div><div class="review-item-value" id="rev-fisika">—</div></div>
                            <div class="review-item"><div class="review-item-label">Biologi</div><div class="review-item-value" id="rev-biologi">—</div></div>
                            <div class="review-item"><div class="review-item-label">PPKN</div><div class="review-item-value" id="rev-pkn">—</div></div>
                        </div>
                    </div>

                    <div class="review-section">
                        <div class="review-title">Minat Bakat</div>
                        <div class="review-grid" id="rev-bakat-grid">
                            {{-- Diisi JS --}}
                        </div>
                    </div>

                    {{-- PERSETUJUAN — name="setuju" value="1" sesuai controller --}}
                    <label class="setuju-box" id="setujuBox">
                        <input type="checkbox" name="setuju" id="setujuCheck" value="1"
                            onchange="toggleSetuju(this)" />
                        <div class="setuju-box-text">
                            Saya menyatakan bahwa data yang saya isi adalah <strong>benar dan akurat</strong>.
                            Saya bersedia menerima rekomendasi jurusan berdasarkan hasil analisis SAW.
                        </div>
                    </label>

                </div>
            </div>
            <div class="btn-nav">
                <button type="button" class="btn-prev" onclick="prevStep(3)">← Kembali</button>
                <button type="submit" class="btn-submit" id="btnSubmit" disabled>⚡ Kirim &amp; Hitung SAW</button>
            </div>
        </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /* ============================================================
       STEP NAVIGATION
    ============================================================ */
    let currentStep = 0;
    const pct    = [25, 50, 75, 100];
    const labels = ['Langkah 1 dari 4','Langkah 2 dari 4','Langkah 3 dari 4','Langkah 4 dari 4'];

    function updateStepper(step) {
        for (let i = 0; i < 4; i++) {
            const nav    = document.getElementById('nav-' + i);
            const circle = nav.querySelector('.step-circle');
            nav.classList.remove('active','done');
            if      (i < step)  { nav.classList.add('done');   circle.innerHTML = '✓'; }
            else if (i === step) { nav.classList.add('active'); circle.innerHTML = i + 1; }
            else                 { circle.innerHTML = i + 1; }
        }
        document.getElementById('progressFill').style.width  = pct[step] + '%';
        document.getElementById('progressLabel').textContent  = labels[step];
        document.getElementById('progressPct').textContent    = pct[step] + '%';
    }

    function showStep(step) {
        document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        updateStepper(step);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function nextStep(from) {
        if (!validateStep(from)) return;
        if (from === 2) buildReview();
        currentStep = from + 1;
        showStep(currentStep);
    }

    function prevStep(from) {
        currentStep = from - 1;
        showStep(currentStep);
    }

    /* ============================================================
       VALIDASI PER STEP
    ============================================================ */
    function validateStep(step) {
        if (step === 0) {
            const t = document.getElementById('tinggi_badan').value;
            const b = document.getElementById('berat_badan').value;
            const w = document.getElementById('buta_warna').value;
            const g = document.querySelector('input[name="jenis_kelamin"]:checked');
            if (!t || !b) { showToast('⚠ Harap isi tinggi dan berat badan!'); return false; }
            if (!w)       { showToast('⚠ Harap pilih status buta warna!');    return false; }
            if (!g)       { showToast('⚠ Harap pilih jenis kelamin!');         return false; }
        }
        if (step === 1) {
            // 8 mapel sesuai controller
            const fields = [
                'nilai_matematika','nilai_bahasa_indonesia','nilai_bahasa_inggris',
                'nilai_ipa','nilai_ips','nilai_fisika','nilai_biologi','nilai_pkn'
            ];
            for (const f of fields) {
                const el = document.querySelector(`[name="${f}"]`);
                if (!el || el.value === '') {
                    showToast('⚠ Harap isi semua nilai akademik!'); return false;
                }
            }
        }
        if (step === 2) {
            // bakat_q1 .. bakat_q10 sesuai controller
            let firstErr = null;
            for (let i = 1; i <= 10; i++) {
                const el = document.getElementById('bq_' + i);
                if (!el) continue;
                if (!document.querySelector(`input[name="bakat_q${i}"]:checked`)) {
                    el.style.borderColor = '#e05454';
                    el.style.background  = 'rgba(224,84,84,.06)';
                    if (!firstErr) firstErr = el;
                }
            }
            if (firstErr) {
                showToast('⚠ Harap jawab semua pertanyaan minat bakat!');
                firstErr.scrollIntoView({ behavior:'smooth', block:'center' });
                return false;
            }
        }
        return true;
    }

    /* ============================================================
       BMI CALCULATOR
    ============================================================ */
    function calcBMI() {
        const t = parseFloat(document.getElementById('tinggi_badan').value);
        const b = parseFloat(document.getElementById('berat_badan').value);
        if (t > 0 && b > 0) {
            const bmi = (b / ((t / 100) * (t / 100))).toFixed(1);
            let cat = '', color = '';
            if      (bmi < 18.5) { cat = 'Berat Badan Kurang'; color = '#60a5fa'; }
            else if (bmi < 25)   { cat = 'Normal / Ideal';     color = '#5cb85c'; }
            else if (bmi < 30)   { cat = 'Berat Badan Lebih';  color = '#f4b942'; }
            else                 { cat = 'Obesitas';            color = '#e05454'; }
            document.getElementById('bmiCard').style.display   = 'block';
            document.getElementById('bmiValue').textContent    = bmi;
            document.getElementById('bmiCategory').textContent = cat;
            document.getElementById('bmiCategory').style.color = color;
        }
    }
    document.getElementById('tinggi_badan')?.addEventListener('input', calcBMI);
    document.getElementById('berat_badan')?.addEventListener('input',  calcBMI);

    /* ============================================================
       TOGGLE BUTA WARNA
    ============================================================ */
    function setButaWarna(val) {
        document.getElementById('buta_warna').value = val;
        document.getElementById('btnButaYa').className    = 'toggle-btn' + (val === 'ya'    ? ' sel-ya'    : '');
        document.getElementById('btnButaTidak').className = 'toggle-btn' + (val === 'tidak' ? ' sel-tidak' : '');
    }
    // Restore old value jika ada
    const oldButa = '{{ old("buta_warna") }}';
    if (oldButa) setButaWarna(oldButa);

    /* ============================================================
       RADIO GENDER
    ============================================================ */
    function selectGender(el) {
        document.querySelectorAll('.radio-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
    }

    /* ============================================================
       BAKAT OPTIONS
    ============================================================ */
    function pilihBakat(el, no) {
        const block = document.getElementById('bq_' + no);
        block.querySelectorAll('.bakat-opt').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        block.classList.add('answered');
        block.style.borderColor = '';
        block.style.background  = '';
    }

    /* ============================================================
       CHECKBOX SETUJU
    ============================================================ */
    function toggleSetuju(el) {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = !el.checked;
        const box = document.getElementById('setujuBox');
        box.style.borderColor = el.checked ? 'var(--accent)' : '';
        box.style.background  = el.checked ? 'rgba(244,185,66,.12)' : '';
    }

    /* ============================================================
       BUILD REVIEW (Step 4)
    ============================================================ */
    const opsiLabel = { '1':'Sangat Tidak Setuju', '2':'Tidak Setuju', '3':'Setuju', '4':'Sangat Setuju' };

    function buildReview() {
        const s = (id, val) => { const el = document.getElementById(id); if(el) el.textContent = val || '—'; };

        // Data fisik
        s('rev-tinggi', (document.getElementById('tinggi_badan')?.value || '') + ' cm');
        s('rev-berat',  (document.getElementById('berat_badan')?.value  || '') + ' kg');
        s('rev-buta',   document.getElementById('buta_warna')?.value === 'ya' ? '🔴 Ya' : '🟢 Tidak');
        const g = document.querySelector('input[name="jenis_kelamin"]:checked');
        s('rev-gender', g ? (g.value === 'laki-laki' ? '👦 Laki-laki' : '👧 Perempuan') : '—');

        // Nilai akademik — name sesuai controller
        s('rev-mtk',    document.querySelector('[name="nilai_matematika"]')?.value);
        s('rev-bind',   document.querySelector('[name="nilai_bahasa_indonesia"]')?.value);
        s('rev-bing',   document.querySelector('[name="nilai_bahasa_inggris"]')?.value);
        s('rev-ipa',    document.querySelector('[name="nilai_ipa"]')?.value);
        s('rev-ips',    document.querySelector('[name="nilai_ips"]')?.value);
        s('rev-fisika', document.querySelector('[name="nilai_fisika"]')?.value);
        s('rev-biologi',document.querySelector('[name="nilai_biologi"]')?.value);
        s('rev-pkn',    document.querySelector('[name="nilai_pkn"]')?.value);

        // Minat bakat — bakat_q1..q10
        const grid = document.getElementById('rev-bakat-grid');
        let html = '';
        for (let i = 1; i <= 10; i++) {
            const checked = document.querySelector(`input[name="bakat_q${i}"]:checked`);
            const val     = checked ? checked.value : null;
            html += `
                <div class="review-item">
                    <div class="review-item-label">Soal ${i}</div>
                    <div class="review-item-value">${val ? opsiLabel[val] : '—'}</div>
                </div>`;
        }
        grid.innerHTML = html;
    }

    /* ============================================================
       SUBMIT LOADING STATE
    ============================================================ */
    document.getElementById('spkForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled    = true;
        btn.textContent = '⏳ Memproses...';
    });

    /* ============================================================
       TOAST
    ============================================================ */
    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent   = msg;
        t.style.display = 'block';
        clearTimeout(t._timer);
        t._timer = setTimeout(() => t.style.display = 'none', 3500);
    }
</script>
@endpush