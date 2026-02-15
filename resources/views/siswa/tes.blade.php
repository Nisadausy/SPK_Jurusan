{{-- resources/views/siswa/tes.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tes Minat & Bakat — SPK</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        :root {
            --bg: #0d0f14;
            --surface: #161921;
            --surface2: #1e2330;
            --border: #2a2f3e;
            --accent: #f4b942;
            --accent2: #e07b54;
            --text: #e8eaf0;
            --text-dim: #8892aa;
            --green: #5cb85c;
            --red: #e05454;
            --radius: 16px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* BG */
        .bg-grain {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: 0.5;
        }
        .bg-glow  { position:fixed; top:-200px; left:-200px; width:700px; height:700px; background:radial-gradient(ellipse,rgba(244,185,66,.08) 0%,transparent 70%); pointer-events:none; z-index:0; }
        .bg-glow2 { position:fixed; bottom:-150px; right:-150px; width:500px; height:500px; background:radial-gradient(ellipse,rgba(224,123,84,.07) 0%,transparent 70%); pointer-events:none; z-index:0; }

        /* LAYOUT */
        .container { position:relative; z-index:1; max-width:860px; margin:0 auto; padding:40px 20px 80px; }

        /* HEADER */
        .page-header { text-align:center; margin-bottom:48px; animation:fadeDown .7s ease both; }
        .badge {
            display:inline-flex; align-items:center; gap:8px;
            background:rgba(244,185,66,.12); border:1px solid rgba(244,185,66,.25);
            color:var(--accent); font-size:12px; font-weight:600; letter-spacing:.1em;
            text-transform:uppercase; padding:6px 16px; border-radius:100px; margin-bottom:20px;
        }
        .page-title {
            font-family:'Playfair Display',serif;
            font-size:clamp(2rem,5vw,3.2rem); font-weight:900; line-height:1.15;
            background:linear-gradient(135deg,#f4b942,#e8eaf0 60%);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            margin-bottom:12px;
        }
        .page-sub { color:var(--text-dim); font-size:15px; max-width:500px; margin:0 auto; }

        /* ALERT */
        .alert {
            border-radius:12px; padding:14px 18px; margin-bottom:24px;
            font-size:14px; font-weight:500; display:flex; align-items:flex-start; gap:10px;
        }
        .alert-error   { background:rgba(224,84,84,.12); border:1px solid rgba(224,84,84,.3); color:#f08080; }
        .alert-success { background:rgba(92,184,92,.12); border:1px solid rgba(92,184,92,.3); color:#7dcc7d; }
        .alert-info    { background:rgba(244,185,66,.10); border:1px solid rgba(244,185,66,.25); color:var(--accent); }
        .alert ul { padding-left:18px; margin-top:6px; }
        .alert ul li { margin-bottom:3px; }

        /* PROGRESS */
        .progress-bar-wrap { background:var(--surface2); border-radius:100px; height:6px; margin-bottom:10px; overflow:hidden; }
        .progress-bar-fill { height:100%; border-radius:100px; background:linear-gradient(90deg,var(--accent),var(--accent2)); transition:width .5s cubic-bezier(.4,0,.2,1); }
        .progress-label { display:flex; justify-content:space-between; font-size:12px; color:var(--text-dim); margin-bottom:32px; }

        /* STEPS */
        .step { display:none; animation:fadeIn .5s ease both; }
        .step.active { display:block; }

        /* STEP INDICATOR */
        .step-indicators {
            display:flex; justify-content:center; gap:8px; margin-bottom:40px;
        }
        .step-dot {
            width:32px; height:32px; border-radius:50%; border:2px solid var(--border);
            display:flex; align-items:center; justify-content:center;
            font-size:12px; font-weight:700; color:var(--text-dim);
            transition:all .3s;
        }
        .step-dot.active { border-color:var(--accent); background:rgba(244,185,66,.15); color:var(--accent); }
        .step-dot.done   { border-color:var(--green); background:rgba(92,184,92,.15); color:var(--green); }
        .step-line { width:40px; height:2px; background:var(--border); align-self:center; transition:background .3s; }
        .step-line.done { background:var(--green); }

        /* CARD */
        .card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:32px; margin-bottom:24px; box-shadow:0 4px 40px rgba(0,0,0,.3); }
        .card-title { font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:var(--accent); margin-bottom:6px; }
        .card-desc { font-size:13px; color:var(--text-dim); margin-bottom:24px; }

        /* SECTION LABEL */
        .section-label {
            font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.12em;
            color:var(--accent); margin-bottom:16px; margin-top:8px;
            display:flex; align-items:center; gap:10px;
        }
        .section-label::after { content:''; flex:1; height:1px; background:var(--border); }

        /* FORM FIELDS */
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
        .form-row.full { grid-template-columns:1fr; }
        .field label { display:block; font-size:12px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:.06em; margin-bottom:8px; }
        .field input, .field select {
            width:100%; background:var(--surface2); border:1px solid var(--border);
            border-radius:10px; color:var(--text); font-family:'DM Sans',sans-serif;
            font-size:14px; padding:12px 16px; transition:border-color .2s,box-shadow .2s; outline:none; -webkit-appearance:none;
        }
        .field input:focus, .field select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(244,185,66,.12); }
        .field input.error, .field select.error { border-color:var(--red); }
        .field select option { background:var(--surface2); }
        .field-hint { font-size:11px; color:var(--text-dim); margin-top:5px; }

        /* KUESIONER */
        .question-block {
            background:var(--surface2); border:1.5px solid var(--border);
            border-radius:12px; padding:20px; margin-bottom:14px; transition:border-color .2s;
        }
        .question-block:hover { border-color:rgba(244,185,66,.25); }
        .question-block.unanswered { border-color:var(--red) !important; }
        .question-text { font-size:14px; font-weight:500; margin-bottom:16px; line-height:1.6; }
        .question-num {
            display:inline-flex; align-items:center; justify-content:center;
            width:24px; height:24px; background:var(--accent); color:#000;
            border-radius:50%; font-size:11px; font-weight:700; margin-right:8px; flex-shrink:0;
        }
        .scale-options { display:flex; gap:8px; justify-content:space-between; flex-wrap:wrap; }
        .scale-opt { flex:1; min-width:44px; }
        .scale-opt input[type="radio"] { display:none; }
        .scale-opt label {
            display:flex; flex-direction:column; align-items:center; gap:4px;
            background:var(--bg); border:1.5px solid var(--border);
            border-radius:10px; padding:10px 6px; cursor:pointer; font-size:11px;
            color:var(--text-dim); transition:all .2s; text-align:center;
        }
        .scale-opt label .num { font-size:16px; font-weight:700; color:var(--text); }
        .scale-opt input:checked + label { border-color:var(--accent); background:rgba(244,185,66,.12); color:var(--accent); }
        .scale-opt input:checked + label .num { color:var(--accent); }
        .scale-legend { display:flex; justify-content:space-between; font-size:10px; color:var(--text-dim); margin-top:6px; padding:0 2px; }

        /* SAW CRITERIA */
        .saw-info-box {
            background:rgba(244,185,66,.07); border:1px solid rgba(244,185,66,.2);
            border-radius:12px; padding:16px 20px; margin-bottom:24px;
        }
        .saw-info-box p { font-size:13px; color:var(--text-dim); line-height:1.7; }
        .saw-info-box strong { color:var(--accent); }

        .criteria-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .criteria-card { background:var(--surface2); border:1px solid var(--border); border-radius:12px; padding:20px; }
        .criteria-name { font-size:13px; font-weight:600; color:var(--accent); margin-bottom:4px; }
        .criteria-desc { font-size:11px; color:var(--text-dim); margin-bottom:14px; }
        .criteria-input-wrap { display:flex; align-items:center; gap:10px; }
        .criteria-input-wrap input[type="range"] { flex:1; accent-color:var(--accent); cursor:pointer; height:4px; }
        .criteria-val {
            min-width:38px; text-align:center;
            background:rgba(244,185,66,.12); border:1px solid rgba(244,185,66,.2);
            border-radius:6px; padding:4px 6px; font-size:13px; font-weight:700; color:var(--accent);
        }
        .weight-row { display:flex; align-items:center; gap:10px; margin-top:12px; }
        .weight-row label { font-size:11px; color:var(--text-dim); white-space:nowrap; }
        .weight-row input[type="number"] {
            width:72px; background:var(--bg); border:1px solid var(--border);
            border-radius:8px; color:var(--text); font-size:13px; padding:6px 10px;
            outline:none; font-family:'DM Sans',sans-serif;
        }
        .weight-row input:focus { border-color:var(--accent); }
        .weight-total {
            display:flex; align-items:center; gap:8px; justify-content:flex-end;
            font-size:12px; color:var(--text-dim); margin-top:12px;
        }
        .weight-total span { font-weight:700; }
        .weight-total span.ok   { color:var(--green); }
        .weight-total span.warn { color:var(--accent); }

        /* FORMULA */
        .formula-box {
            background:var(--bg); border:1px dashed var(--border); border-radius:10px;
            padding:14px 18px; margin:16px 0; font-family:'Courier New',monospace;
            font-size:12px; color:var(--text-dim); line-height:1.8;
        }
        .formula-box .hl { color:var(--accent); }

        /* BUTTONS */
        .btn {
            display:inline-flex; align-items:center; gap:8px;
            font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600;
            padding:13px 28px; border-radius:10px; cursor:pointer; border:none;
            transition:all .2s; text-decoration:none; line-height:1;
        }
        .btn-primary {
            background:linear-gradient(135deg,var(--accent),var(--accent2));
            color:#111; box-shadow:0 4px 20px rgba(244,185,66,.25);
        }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(244,185,66,.4); }
        .btn-ghost { background:transparent; color:var(--text-dim); border:1.5px solid var(--border); }
        .btn-ghost:hover { border-color:var(--accent); color:var(--accent); }
        .btn-actions { display:flex; justify-content:space-between; align-items:center; margin-top:28px; flex-wrap:wrap; gap:12px; }

        /* RIWAYAT BANNER */
        .riwayat-banner {
            background:rgba(92,184,92,.08); border:1px solid rgba(92,184,92,.25);
            border-radius:12px; padding:16px 20px; margin-bottom:28px;
            display:flex; justify-content:space-between; align-items:center; gap:12px;
            flex-wrap:wrap;
        }
        .riwayat-banner p { font-size:13px; color:#7dcc7d; }
        .riwayat-banner strong { color:#a0e8a0; }

        /* ANIMATIONS */
        @keyframes fadeIn  { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeDown{ from{opacity:0;transform:translateY(-16px)} to{opacity:1;transform:translateY(0)} }

        /* TOAST */
        .toast {
            position:fixed; top:20px; right:20px; z-index:999;
            background:var(--accent2); color:#fff; font-size:13px; font-weight:600;
            padding:12px 20px; border-radius:10px; box-shadow:0 4px 20px rgba(0,0,0,.4);
            animation:fadeIn .3s ease; display:none;
        }

        @media(max-width:600px) {
            .form-row { grid-template-columns:1fr; }
            .criteria-grid { grid-template-columns:1fr; }
            .step-line { width:20px; }
        }
    </style>
</head>
<body>
<div class="bg-grain"></div>
<div class="bg-glow"></div>
<div class="bg-glow2"></div>
<div class="toast" id="toast"></div>

<div class="container">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="badge">🎯 Sistem Pendukung Keputusan</div>
        <h1 class="page-title">Tes Minat &amp; Bakat<br/>Siswa</h1>
        <p class="page-sub">Temukan jurusan dan karier terbaik berdasarkan minat, bakat, dan nilai kamu melalui metode SAW.</p>
    </div>

    {{-- RIWAYAT BANNER --}}
    @if(isset($riwayat) && $riwayat)
    <div class="riwayat-banner">
        <p>✅ Kamu sudah pernah mengerjakan tes. Hasil terakhir: <strong>{{ $riwayat->alternatif_nama }}</strong> (Skor: {{ number_format($riwayat->skor * 100, 2) }}%)</p>
        <a href="{{ route('siswa.tes.hasil') }}" class="btn btn-ghost" style="padding:8px 16px;font-size:13px;">Lihat Hasil →</a>
    </div>
    @endif

    {{-- LARAVEL VALIDATION ERRORS --}}
    @if($errors->any())
    <div class="alert alert-error">
        <span>⚠</span>
        <div>
            <strong>Harap perbaiki kesalahan berikut:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('info'))
    <div class="alert alert-info">ℹ️ {{ session('info') }}</div>
    @endif

    {{-- PROGRESS --}}
    <div class="progress-bar-wrap">
        <div class="progress-bar-fill" id="progressFill" style="width:0%"></div>
    </div>
    <div class="progress-label">
        <span id="progressText">Langkah 1 dari 3</span>
        <span id="progressPct">0%</span>
    </div>

    {{-- STEP INDICATORS --}}
    <div class="step-indicators">
        <div class="step-dot active" id="dot1">1</div>
        <div class="step-line" id="line1"></div>
        <div class="step-dot" id="dot2">2</div>
        <div class="step-line" id="line2"></div>
        <div class="step-dot" id="dot3">3</div>
    </div>

    {{-- FORM UTAMA --}}
    <form action="{{ route('siswa.tes.store') }}" method="POST" id="tesForm">
        @csrf

        {{-- ================================================
             STEP 1 — KUESIONER MINAT BAKAT
             ================================================ --}}
        <div class="step active" id="step1">
            <div class="card">
                <div class="card-title">🧠 Kuesioner Minat &amp; Bakat</div>
                <div class="card-desc">Jawab setiap pernyataan dengan <strong>jujur</strong>. Skala: 1 = Sangat Tidak Setuju &nbsp;|&nbsp; 5 = Sangat Setuju</div>

                {{-- Sains --}}
                <div class="section-label">🔬 Bidang Sains &amp; Teknologi</div>
                @php
                $pertanyaan_sains = [
                    'sains_0' => 'Saya suka memecahkan soal matematika atau fisika.',
                    'sains_1' => 'Saya tertarik mempelajari bagaimana teknologi dan komputer bekerja.',
                    'sains_2' => 'Saya senang melakukan eksperimen atau percobaan ilmiah.',
                    'sains_3' => 'Saya mudah memahami konsep-konsep sains.',
                ];
                @endphp
                @foreach($pertanyaan_sains as $kode => $teks)
                <div class="question-block" id="qblock_{{ $kode }}">
                    <div class="question-text">
                        <span class="question-num">{{ $loop->iteration }}</span>{{ $teks }}
                    </div>
                    <div class="scale-options">
                        @for($n = 1; $n <= 5; $n++)
                        <div class="scale-opt">
                            <input type="radio" name="jawaban[{{ $kode }}]" id="{{ $kode }}_{{ $n }}" value="{{ $n }}"
                                {{ old("jawaban.$kode") == $n ? 'checked' : '' }} />
                            <label for="{{ $kode }}_{{ $n }}">
                                <span class="num">{{ $n }}</span>
                                {{ ['STS','TS','N','S','SS'][$n-1] }}
                            </label>
                        </div>
                        @endfor
                    </div>
                    <div class="scale-legend"><span>Sangat Tidak Setuju</span><span>Sangat Setuju</span></div>
                </div>
                @endforeach

                {{-- Sosial --}}
                <div class="section-label">🤝 Bidang Sosial &amp; Humaniora</div>
                @php
                $pertanyaan_sosial = [
                    'sosial_0' => 'Saya senang berbicara dan berinteraksi dengan banyak orang.',
                    'sosial_1' => 'Saya tertarik membantu orang lain memecahkan masalah mereka.',
                    'sosial_2' => 'Saya suka belajar tentang sejarah, budaya, dan masyarakat.',
                    'sosial_3' => 'Saya merasa nyaman menjadi pemimpin dalam kelompok.',
                ];
                @endphp
                @foreach($pertanyaan_sosial as $kode => $teks)
                <div class="question-block" id="qblock_{{ $kode }}">
                    <div class="question-text">
                        <span class="question-num">{{ $loop->iteration }}</span>{{ $teks }}
                    </div>
                    <div class="scale-options">
                        @for($n = 1; $n <= 5; $n++)
                        <div class="scale-opt">
                            <input type="radio" name="jawaban[{{ $kode }}]" id="{{ $kode }}_{{ $n }}" value="{{ $n }}"
                                {{ old("jawaban.$kode") == $n ? 'checked' : '' }} />
                            <label for="{{ $kode }}_{{ $n }}">
                                <span class="num">{{ $n }}</span>
                                {{ ['STS','TS','N','S','SS'][$n-1] }}
                            </label>
                        </div>
                        @endfor
                    </div>
                    <div class="scale-legend"><span>Sangat Tidak Setuju</span><span>Sangat Setuju</span></div>
                </div>
                @endforeach

                {{-- Seni --}}
                <div class="section-label">🎨 Bidang Seni &amp; Kreativitas</div>
                @php
                $pertanyaan_seni = [
                    'seni_0' => 'Saya suka menggambar, melukis, atau membuat karya visual.',
                    'seni_1' => 'Saya merasa ekspresi diri melalui seni itu penting.',
                    'seni_2' => 'Saya tertarik pada dunia desain, musik, atau sastra.',
                    'seni_3' => 'Saya mudah berpikir kreatif dan melihat sesuatu dari sudut berbeda.',
                ];
                @endphp
                @foreach($pertanyaan_seni as $kode => $teks)
                <div class="question-block" id="qblock_{{ $kode }}">
                    <div class="question-text">
                        <span class="question-num">{{ $loop->iteration }}</span>{{ $teks }}
                    </div>
                    <div class="scale-options">
                        @for($n = 1; $n <= 5; $n++)
                        <div class="scale-opt">
                            <input type="radio" name="jawaban[{{ $kode }}]" id="{{ $kode }}_{{ $n }}" value="{{ $n }}"
                                {{ old("jawaban.$kode") == $n ? 'checked' : '' }} />
                            <label for="{{ $kode }}_{{ $n }}">
                                <span class="num">{{ $n }}</span>
                                {{ ['STS','TS','N','S','SS'][$n-1] }}
                            </label>
                        </div>
                        @endfor
                    </div>
                    <div class="scale-legend"><span>Sangat Tidak Setuju</span><span>Sangat Setuju</span></div>
                </div>
                @endforeach

                {{-- Bisnis --}}
                <div class="section-label">📈 Bidang Bisnis &amp; Wirausaha</div>
                @php
                $pertanyaan_bisnis = [
                    'bisnis_0' => 'Saya suka berdagang atau merencanakan bisnis kecil-kecilan.',
                    'bisnis_1' => 'Saya tertarik dengan cara perusahaan menghasilkan keuntungan.',
                    'bisnis_2' => 'Saya mudah mengelola uang dan membuat anggaran.',
                    'bisnis_3' => 'Saya senang bernegosiasi dan meyakinkan orang lain.',
                ];
                @endphp
                @foreach($pertanyaan_bisnis as $kode => $teks)
                <div class="question-block" id="qblock_{{ $kode }}">
                    <div class="question-text">
                        <span class="question-num">{{ $loop->iteration }}</span>{{ $teks }}
                    </div>
                    <div class="scale-options">
                        @for($n = 1; $n <= 5; $n++)
                        <div class="scale-opt">
                            <input type="radio" name="jawaban[{{ $kode }}]" id="{{ $kode }}_{{ $n }}" value="{{ $n }}"
                                {{ old("jawaban.$kode") == $n ? 'checked' : '' }} />
                            <label for="{{ $kode }}_{{ $n }}">
                                <span class="num">{{ $n }}</span>
                                {{ ['STS','TS','N','S','SS'][$n-1] }}
                            </label>
                        </div>
                        @endfor
                    </div>
                    <div class="scale-legend"><span>Sangat Tidak Setuju</span><span>Sangat Setuju</span></div>
                </div>
                @endforeach

                <div class="btn-actions">
                    <span></span>
                    <button type="button" class="btn btn-primary" onclick="goStep(2)">Lanjut ke Nilai →</button>
                </div>
            </div>
        </div>

        {{-- ================================================
             STEP 2 — INPUT NILAI & BOBOT SAW
             ================================================ --}}
        <div class="step" id="step2">
            <div class="card">
                <div class="card-title">📊 Input Nilai &amp; Bobot SAW</div>
                <div class="card-desc">Masukkan nilai kamu pada setiap kriteria dan tentukan bobot kepentingannya.</div>

                <div class="saw-info-box">
                    <p>
                        <strong>Metode SAW (Simple Additive Weighting)</strong> menentukan jurusan terbaik berdasarkan
                        bobot dan nilai tiap kriteria. Nilai <strong>0–100</strong>, bobot akan dinormalisasi otomatis
                        sehingga total tidak harus pas 100%.
                    </p>
                </div>

                <div class="formula-box">
                    <span class="hl">Normalisasi :</span>  r<sub>ij</sub> = x<sub>ij</sub> / max(x<sub>j</sub>)<br/>
                    <span class="hl">Skor SAW    :</span>  V<sub>i</sub> = &Sigma; w<sub>j</sub> &times; r<sub>ij</sub>
                </div>

                <div class="section-label">Kriteria Penilaian</div>
                <div class="criteria-grid">
                    @php
                    $kriteriaList = [
                        ['id' => 'matematika', 'nama' => 'Nilai Matematika', 'desc' => 'Nilai rata-rata pelajaran matematika',    'default_bobot' => 20],
                        ['id' => 'ipa',        'nama' => 'Nilai IPA / Sains', 'desc' => 'Nilai rata-rata pelajaran IPA',          'default_bobot' => 20],
                        ['id' => 'ips',        'nama' => 'Nilai IPS / Sosial','desc' => 'Nilai rata-rata pelajaran IPS',          'default_bobot' => 15],
                        ['id' => 'bahasa',     'nama' => 'Kemampuan Bahasa',  'desc' => 'Nilai Bahasa Indonesia / Inggris',       'default_bobot' => 15],
                        ['id' => 'seni',       'nama' => 'Bakat Seni',        'desc' => 'Kemampuan seni / kreativitas',           'default_bobot' => 10],
                        ['id' => 'logika',     'nama' => 'Kemampuan Logika',  'desc' => 'Kemampuan berpikir logis / analitis',    'default_bobot' => 20],
                    ];
                    @endphp

                    @foreach($kriteriaList as $k)
                    <div class="criteria-card">
                        <div class="criteria-name">{{ $k['nama'] }}</div>
                        <div class="criteria-desc">{{ $k['desc'] }}</div>
                        <div class="criteria-input-wrap">
                            <input type="range"
                                id="range_{{ $k['id'] }}"
                                min="0" max="100"
                                value="{{ old('nilai.'.$k['id'], 70) }}"
                                oninput="updateVal('{{ $k['id'] }}', this.value)" />
                            <div class="criteria-val" id="val_{{ $k['id'] }}">{{ old('nilai.'.$k['id'], 70) }}</div>
                        </div>
                        {{-- Hidden input yang akan dikirim ke server --}}
                        <input type="hidden" name="nilai[{{ $k['id'] }}]" id="input_{{ $k['id'] }}" value="{{ old('nilai.'.$k['id'], 70) }}" />
                        <div class="weight-row">
                            <label>Bobot (%)</label>
                            <input type="number"
                                name="bobot[{{ $k['id'] }}]"
                                id="bobot_{{ $k['id'] }}"
                                value="{{ old('bobot.'.$k['id'], $k['default_bobot']) }}"
                                min="0" max="100"
                                oninput="updateWeightTotal()" />
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="weight-total">
                    Total bobot: <span id="weightTotal" class="ok">100%</span>
                    <span style="color:var(--text-dim)">(akan dinormalisasi otomatis)</span>
                </div>

                <div class="btn-actions">
                    <button type="button" class="btn btn-ghost" onclick="goStep(1)">← Kembali</button>
                    <button type="button" class="btn btn-primary" onclick="goStep(3)">Review &amp; Submit →</button>
                </div>
            </div>
        </div>

        {{-- ================================================
             STEP 3 — KONFIRMASI & SUBMIT
             ================================================ --}}
        <div class="step" id="step3">
            <div class="card">
                <div class="card-title">✅ Konfirmasi &amp; Submit</div>
                <div class="card-desc">Periksa kembali sebelum mengirim. Klik <strong>Hitung SAW</strong> untuk memproses.</div>

                <div class="saw-info-box">
                    <p>Semua jawaban dan nilai akan dikirim ke server untuk dihitung menggunakan metode SAW. Hasilnya berupa <strong>ranking jurusan</strong> yang paling sesuai dengan profil kamu.</p>
                </div>

                <div class="section-label">Ringkasan Jawaban Kuesioner</div>
                <div id="ringkasanKuesioner" style="font-size:13px; color:var(--text-dim); line-height:2;">
                    <!-- Diisi JS -->
                </div>

                <div class="section-label" style="margin-top:20px;">Ringkasan Nilai &amp; Bobot</div>
                <div id="ringkasanNilai" style="font-size:13px; color:var(--text-dim); line-height:2;">
                    <!-- Diisi JS -->
                </div>

                <div class="btn-actions">
                    <button type="button" class="btn btn-ghost" onclick="goStep(2)">← Ubah Nilai</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">⚡ Hitung SAW &amp; Lihat Hasil</button>
                </div>
            </div>
        </div>

    </form>{{-- end form --}}

</div>{{-- end container --}}

<script>
// ============================================================
// DATA PERTANYAAN (untuk validasi & ringkasan)
// ============================================================
const semuaKode = [
    'sains_0','sains_1','sains_2','sains_3',
    'sosial_0','sosial_1','sosial_2','sosial_3',
    'seni_0','seni_1','seni_2','seni_3',
    'bisnis_0','bisnis_1','bisnis_2','bisnis_3',
];

const labelKuesioner = {
    sains_0:'Suka soal matematika/fisika', sains_1:'Tertarik teknologi & komputer',
    sains_2:'Senang eksperimen', sains_3:'Mudah memahami sains',
    sosial_0:'Suka berinteraksi', sosial_1:'Suka membantu orang lain',
    sosial_2:'Tertarik sejarah & budaya', sosial_3:'Nyaman jadi pemimpin',
    seni_0:'Suka menggambar/melukis', seni_1:'Ekspresi diri lewat seni',
    seni_2:'Tertarik desain/musik/sastra', seni_3:'Mudah berpikir kreatif',
    bisnis_0:'Suka berdagang', bisnis_1:'Tertarik bisnis & profit',
    bisnis_2:'Pandai kelola keuangan', bisnis_3:'Senang bernegosiasi',
};

const kriteriaIds = ['matematika','ipa','ips','bahasa','seni','logika'];
const kriteriaLabel = {
    matematika:'Matematika', ipa:'IPA/Sains', ips:'IPS/Sosial',
    bahasa:'Bahasa', seni:'Bakat Seni', logika:'Logika',
};

// ============================================================
// NAVIGATION
// ============================================================
function goStep(n) {
    if (n === 2 && !validateStep1()) return;
    if (n === 3) buildRingkasan();

    document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
    document.getElementById('step' + n).classList.add('active');

    // Progress
    const pct = Math.round(((n - 1) / 2) * 100);
    document.getElementById('progressFill').style.width = pct + '%';
    document.getElementById('progressText').textContent = `Langkah ${n} dari 3`;
    document.getElementById('progressPct').textContent = pct + '%';

    // Dots
    for (let i = 1; i <= 3; i++) {
        const dot  = document.getElementById('dot' + i);
        dot.classList.remove('active','done');
        if (i < n)  dot.classList.add('done');
        if (i === n) dot.classList.add('active');
    }
    for (let i = 1; i <= 2; i++) {
        const line = document.getElementById('line' + i);
        line.classList.toggle('done', i < n);
    }

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ============================================================
// VALIDASI STEP 1
// ============================================================
function validateStep1() {
    let allOk = true;
    let firstEl = null;

    semuaKode.forEach(kode => {
        const block    = document.getElementById('qblock_' + kode);
        const answered = document.querySelector(`input[name="jawaban[${kode}]"]:checked`);
        if (!answered) {
            block.classList.add('unanswered');
            allOk = false;
            if (!firstEl) firstEl = block;
        } else {
            block.classList.remove('unanswered');
        }
    });

    if (!allOk) {
        showToast('⚠ Harap jawab semua pertanyaan terlebih dahulu!');
        firstEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    return allOk;
}

// Hapus highlight merah saat dijawab
semuaKode.forEach(kode => {
    document.querySelectorAll(`input[name="jawaban[${kode}]"]`).forEach(radio => {
        radio.addEventListener('change', () => {
            document.getElementById('qblock_' + kode)?.classList.remove('unanswered');
        });
    });
});

// ============================================================
// UPDATE SLIDER
// ============================================================
function updateVal(id, val) {
    document.getElementById('val_'   + id).textContent = val;
    document.getElementById('input_' + id).value       = val;
}

// ============================================================
// UPDATE TOTAL BOBOT
// ============================================================
function updateWeightTotal() {
    let total = 0;
    kriteriaIds.forEach(id => {
        total += parseFloat(document.getElementById('bobot_' + id)?.value || 0);
    });
    const el = document.getElementById('weightTotal');
    el.textContent = total + '%';
    el.className   = total > 0 ? 'ok' : 'warn';
}
updateWeightTotal();

// ============================================================
// BUILD RINGKASAN (Step 3)
// ============================================================
const skalaLabel = ['','STS','TS','N','S','SS'];

function buildRingkasan() {
    // Kuesioner
    const kategori = {
        '🔬 Sains': ['sains_0','sains_1','sains_2','sains_3'],
        '🤝 Sosial': ['sosial_0','sosial_1','sosial_2','sosial_3'],
        '🎨 Seni': ['seni_0','seni_1','seni_2','seni_3'],
        '📈 Bisnis': ['bisnis_0','bisnis_1','bisnis_2','bisnis_3'],
    };

    let html = '';
    Object.entries(kategori).forEach(([kat, kodes]) => {
        html += `<div style="margin-bottom:10px;"><strong style="color:var(--accent)">${kat}</strong><br/>`;
        kodes.forEach(kode => {
            const checked = document.querySelector(`input[name="jawaban[${kode}]"]:checked`);
            const val     = checked ? checked.value : '—';
            const label   = checked ? skalaLabel[val] : '—';
            html += `<span style="margin-right:16px;">• ${labelKuesioner[kode]}: <strong style="color:var(--text)">${val} (${label})</strong></span>`;
        });
        html += '</div>';
    });
    document.getElementById('ringkasanKuesioner').innerHTML = html;

    // Nilai & Bobot
    let html2 = '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">';
    kriteriaIds.forEach(id => {
        const val   = document.getElementById('input_' + id)?.value || 0;
        const bobot = document.getElementById('bobot_' + id)?.value || 0;
        html2 += `
            <div style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:10px 12px;">
                <div style="font-size:11px;color:var(--text-dim)">${kriteriaLabel[id]}</div>
                <div style="font-size:15px;font-weight:700;color:var(--text)">${val}</div>
                <div style="font-size:11px;color:var(--accent)">Bobot: ${bobot}%</div>
            </div>`;
    });
    html2 += '</div>';
    document.getElementById('ringkasanNilai').innerHTML = html2;
}

// ============================================================
// SUBMIT — tambah loading state
// ============================================================
document.getElementById('tesForm').addEventListener('submit', function () {
    const btn = document.getElementById('btnSubmit');
    btn.disabled    = true;
    btn.textContent = '⏳ Menghitung...';
});

// ============================================================
// TOAST
// ============================================================
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.style.display = 'block';
    setTimeout(() => t.style.display = 'none', 3500);
}

// ============================================================
// AUTO RESTORE STEP (jika ada validation error dari server)
// ============================================================
@if($errors->has('jawaban.*'))
    // Error di kuesioner → tetap di step 1
@elseif($errors->hasAny(['nilai.*', 'bobot.*']))
    document.addEventListener('DOMContentLoaded', () => goStep(2));
@endif
</script>
</body>
</html>