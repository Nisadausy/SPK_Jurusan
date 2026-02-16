<x-app-layout>
    <x-slot name="header"></x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1a3c6e;
            --primary-dark: #0f2548;
            --accent: #e8a020;
            --accent-light: #fcd34d;
            --bg: #f0f4fa;
            --success: #10b981;
        }
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { background: var(--bg); }

        /* ===== LAYOUT ===== */
        .spk-wrapper { min-height: 100vh; background: var(--bg); }
        .spk-header { background: var(--primary-dark); padding: 14px 24px; display: flex; align-items: center; justify-content: space-between; }
        .spk-container { max-width: 780px; margin: 0 auto; padding: 32px 16px 60px; }

        /* ===== STEPPER ===== */
        .stepper { display: flex; align-items: center; gap: 0; margin-bottom: 36px; }
        .step-item-nav { display: flex; flex-direction: column; align-items: center; gap: 6px; flex: 1; position: relative; cursor: pointer; }
        .step-item-nav::after {
            content: '';
            position: absolute;
            top: 19px; left: 50%;
            width: 100%; height: 2px;
            background: #dde3ef;
            z-index: 0;
        }
        .step-item-nav:last-child::after { display: none; }
        .step-circle {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 2px solid #dde3ef;
            background: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700;
            color: #9ca3af;
            position: relative; z-index: 1;
            transition: all 0.3s ease;
        }
        .step-item-nav.active .step-circle { border-color: var(--accent); background: var(--accent); color: var(--primary-dark); }
        .step-item-nav.done .step-circle { border-color: var(--success); background: var(--success); color: white; }
        .step-item-nav.done::after, .step-item-nav.active::after { background: var(--success); }
        .step-label { font-size: 0.65rem; font-weight: 600; color: #9ca3af; text-align: center; line-height: 1.2; }
        .step-item-nav.active .step-label { color: var(--accent); }
        .step-item-nav.done .step-label { color: var(--success); }

        /* ===== CARD ===== */
        .spk-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(26,60,110,0.08);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            padding: 28px 32px;
            position: relative;
            overflow: hidden;
        }
        .card-header::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .card-header-step { font-size: 0.7rem; font-weight: 600; color: var(--accent-light); margin-bottom: 4px; }
        .card-header-title { font-size: 1.25rem; font-weight: 800; color: white; }
        .card-header-sub { font-size: 0.78rem; color: rgba(255,255,255,0.65); margin-top: 4px; }
        .card-body { padding: 28px 32px; }

        /* ===== FORM ELEMENTS ===== */
        .form-label { font-size: 0.78rem; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }
        .form-label span.req { color: #ef4444; }
        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e5eaf3;
            border-radius: 10px;
            font-size: 0.82rem;
            color: #1e2a3a;
            background: #f8fafc;
            transition: all 0.2s;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }
        .form-input:focus { border-color: var(--accent); background: white; box-shadow: 0 0 0 3px rgba(232,160,32,0.12); }
        .form-input.error { border-color: #ef4444; }
        .form-hint { font-size: 0.7rem; color: #9ca3af; margin-top: 4px; }
        .form-error { font-size: 0.7rem; color: #ef4444; margin-top: 4px; display: none; }
        .form-group { margin-bottom: 20px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

        /* ===== RADIO CARDS (bakat) ===== */
        .radio-card-group { display: flex; gap: 10px; flex-wrap: wrap; }
        .radio-card {
            flex: 1; min-width: 120px;
            border: 1.5px solid #e5eaf3;
            border-radius: 12px;
            padding: 12px 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap: 10px;
            background: #f8fafc;
        }
        .radio-card:hover { border-color: var(--accent); background: #fffbeb; }
        .radio-card input[type="radio"] { accent-color: var(--accent); width: 16px; height: 16px; flex-shrink: 0; }
        .radio-card.selected { border-color: var(--accent); background: #fffbeb; box-shadow: 0 0 0 3px rgba(232,160,32,0.12); }
        .radio-card-label { font-size: 0.78rem; font-weight: 500; color: #374151; }

        /* ===== TOGGLE (buta warna) ===== */
        .toggle-group { display: flex; gap: 10px; }
        .toggle-btn {
            flex: 1;
            padding: 10px;
            border: 1.5px solid #e5eaf3;
            border-radius: 10px;
            font-size: 0.78rem; font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            background: #f8fafc;
            color: #6b7280;
        }
        .toggle-btn.selected-yes { border-color: #ef4444; background: #fef2f2; color: #dc2626; }
        .toggle-btn.selected-no { border-color: var(--success); background: #f0fdf4; color: #059669; }

        /* ===== NILAI INPUT ===== */
        .nilai-card {
            background: #f8fafc;
            border: 1.5px solid #e5eaf3;
            border-radius: 12px;
            padding: 14px 16px;
            transition: border-color 0.2s;
        }
        .nilai-card:focus-within { border-color: var(--accent); background: white; }
        .nilai-label { font-size: 0.7rem; font-weight: 700; color: #6b7280; margin-bottom: 6px; display: block; text-transform: uppercase; letter-spacing: 0.05em; }
        .nilai-input {
            width: 100%;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem; font-weight: 700;
            color: var(--primary-dark);
            background: transparent;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }
        .nilai-scale { font-size: 0.65rem; color: #9ca3af; margin-top: 2px; }

        /* ===== BAKAT QUESTION ===== */
        .bakat-question {
            background: #f8fafc;
            border: 1.5px solid #e5eaf3;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 14px;
            transition: border-color 0.2s;
        }
        .bakat-question.answered { border-color: #d1fae5; background: #f0fdf4; }
        .bakat-q-text { font-size: 0.82rem; font-weight: 600; color: #1e2a3a; margin-bottom: 12px; line-height: 1.5; }
        .bakat-q-num { font-size: 0.7rem; font-weight: 700; color: var(--accent); margin-bottom: 4px; }
        .bakat-options { display: flex; gap: 8px; flex-wrap: wrap; }
        .bakat-opt {
            flex: 1; min-width: 100px;
            padding: 8px 12px;
            border: 1.5px solid #e5eaf3;
            border-radius: 8px;
            font-size: 0.75rem; font-weight: 500;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            background: white;
            color: #6b7280;
        }
        .bakat-opt:hover { border-color: var(--accent); color: var(--primary-dark); }
        .bakat-opt.selected { border-color: var(--accent); background: var(--accent); color: var(--primary-dark); font-weight: 700; }
        .bakat-opt input { display: none; }

        /* ===== SYARAT FISIK ALERT ===== */
        .syarat-alert {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.75rem;
            color: #92400e;
            margin-bottom: 20px;
        }

        /* ===== NAVIGATION BUTTONS ===== */
        .btn-nav { display: flex; gap: 12px; justify-content: space-between; margin-top: 28px; padding-top: 20px; border-top: 1px solid #f0f4fa; }
        .btn-prev {
            padding: 12px 24px;
            border: 1.5px solid #e5eaf3;
            border-radius: 12px;
            font-size: 0.82rem; font-weight: 600;
            color: #6b7280;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap-8px;
        }
        .btn-prev:hover { border-color: var(--primary); color: var(--primary); }
        .btn-next {
            padding: 12px 28px;
            border: none;
            border-radius: 12px;
            font-size: 0.82rem; font-weight: 700;
            color: var(--primary-dark);
            background: var(--accent);
            cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap: 8px;
            margin-left: auto;
        }
        .btn-next:hover { background: var(--accent-light); transform: translateY(-1px); }
        .btn-submit {
            padding: 14px 32px;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem; font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            cursor: pointer;
            transition: all 0.3s;
            display: flex; align-items: center; gap: 8px;
            margin-left: auto;
            box-shadow: 0 4px 16px rgba(26,60,110,0.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,60,110,0.4); }

        /* ===== PROGRESS BAR ===== */
        .progress-wrapper { margin-bottom: 12px; }
        .progress-text { display: flex; justify-content: space-between; font-size: 0.7rem; color: #9ca3af; margin-bottom: 6px; }
        .progress-track { height: 6px; background: #e5eaf3; border-radius: 99px; overflow: hidden; }
        .progress-fill { height: 100%; background: var(--accent); border-radius: 99px; transition: width 0.4s ease; }

        /* ===== REVIEW SECTION ===== */
        .review-section { margin-bottom: 20px; }
        .review-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af; margin-bottom: 10px; }
        .review-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .review-item { background: #f8fafc; border-radius: 10px; padding: 10px 14px; }
        .review-item-label { font-size: 0.68rem; color: #9ca3af; margin-bottom: 2px; }
        .review-item-value { font-size: 0.82rem; font-weight: 700; color: var(--primary-dark); }

        /* ===== MOBILE ===== */
        @media(max-width: 640px) {
            .grid-2 { grid-template-columns: 1fr; }
            .grid-3 { grid-template-columns: 1fr 1fr; }
            .card-body { padding: 20px 18px; }
            .card-header { padding: 20px 20px; }
            .stepper { gap: 0; }
            .step-label { display: none; }
        }

        /* ===== ANIMATE ===== */
        .step-panel { display: none; animation: slideIn 0.3s ease; }
        .step-panel.active { display: block; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
    </style>

    <div class="spk-wrapper">

        {{-- TOP BAR --}}
        <div class="spk-header">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center font-bold text-blue-900 text-xs">S2J</div>
                <div>
                    <div class="text-white font-bold text-xs leading-tight">SMK Negeri 2 Jember</div>
                    <div class="text-blue-300 text-xs">Sistem Pendukung Keputusan Jurusan</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-blue-300 text-xs hidden sm:inline">{{ Auth::user()->name }}</span>
                <a href="{{ url('/dashboard') }}" class="text-xs bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-lg transition-colors">← Dashboard</a>
            </div>
        </div>

        <div class="spk-container">

            {{-- PROGRESS TEXT --}}
            <div class="progress-wrapper">
                <div class="progress-text">
                    <span id="progressLabel">Langkah 1 dari 4</span>
                    <span id="progressPct">25%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" id="progressFill" style="width:25%"></div>
                </div>
            </div>

            {{-- STEPPER --}}
            <div class="stepper mb-8">
                <div class="step-item-nav active" id="nav-0">
                    <div class="step-circle">1</div>
                    <div class="step-label">Data Fisik</div>
                </div>
                <div class="step-item-nav" id="nav-1">
                    <div class="step-circle">2</div>
                    <div class="step-label">Nilai Akademik</div>
                </div>
                <div class="step-item-nav" id="nav-2">
                    <div class="step-circle">3</div>
                    <div class="step-label">Tes Minat Bakat</div>
                </div>
                <div class="step-item-nav" id="nav-3">
                    <div class="step-circle">4</div>
                    <div class="step-label">Review & Kirim</div>
                </div>
            </div>

            <form id="spkForm" method="POST" action="{{ route('siswa.tes.simpan') }}">
    @csrf

                {{-- ============================================================ --}}
                {{-- STEP 1: DATA FISIK --}}
                {{-- ============================================================ --}}
                <div class="step-panel active" id="step-0">
                    <div class="spk-card">
                        <div class="card-header">
                            <div class="card-header-step">Langkah 1 dari 4</div>
                            <div class="card-header-title">📏 Data Fisik & Kesehatan</div>
                            <div class="card-header-sub">Isi data fisik kamu dengan jujur — data ini digunakan untuk menentukan kesesuaian jurusan</div>
                        </div>
                        <div class="card-body">

                            <div class="syarat-alert">
                                ⚠️ <strong>Catatan:</strong> Beberapa jurusan memiliki syarat fisik tertentu. Data ini akan digunakan sebagai salah satu kriteria penilaian SPK.
                            </div>

                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label">Tinggi Badan <span class="req">*</span></label>
                                    <div style="position:relative">
                                        <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-input" placeholder="165" min="100" max="220" required>
                                        <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:0.75rem;color:#9ca3af;font-weight:600">cm</span>
                                    </div>
                                    <div class="form-hint">Masukkan tinggi badan dalam sentimeter</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Berat Badan <span class="req">*</span></label>
                                    <div style="position:relative">
                                        <input type="number" name="berat_badan" id="berat_badan" class="form-input" placeholder="55" min="20" max="200" required>
                                        <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:0.75rem;color:#9ca3af;font-weight:600">kg</span>
                                    </div>
                                    <div class="form-hint">Masukkan berat badan dalam kilogram</div>
                                </div>
                            </div>

                            {{-- BMI Preview --}}
                            <div id="bmiCard" style="display:none;background:linear-gradient(135deg,#f0f4fa,#e8f0fe);border-radius:12px;padding:14px 18px;margin-bottom:20px;border:1.5px solid #dde3ef">
                                <div style="font-size:0.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px">Indeks Massa Tubuh (BMI)</div>
                                <div style="display:flex;align-items:center;gap:12px">
                                    <div id="bmiValue" style="font-size:1.8rem;font-weight:800;color:var(--primary-dark)">—</div>
                                    <div>
                                        <div id="bmiCategory" style="font-size:0.78rem;font-weight:700;color:var(--primary)">—</div>
                                        <div style="font-size:0.68rem;color:#9ca3af">Kategori BMI kamu</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Buta Warna --}}
                            <div class="form-group">
                                <label class="form-label">Apakah kamu mengalami buta warna? <span class="req">*</span></label>
                                <div class="toggle-group">
                                    <div class="toggle-btn" id="btnButaYa" onclick="setButaWarna('ya')">
                                        🔴 Ya, Buta Warna
                                    </div>
                                    <div class="toggle-btn" id="btnButaTidak" onclick="setButaWarna('tidak')">
                                        🟢 Tidak, Normal
                                    </div>
                                </div>
                                <input type="hidden" name="buta_warna" id="buta_warna" value="">
                                <div class="form-hint">Buta warna dapat mempengaruhi kelayakan pada beberapa jurusan teknik</div>

                                {{-- Info per jurusan --}}
                                <div id="butaWarnaInfo" style="display:none;margin-top:12px;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;font-size:0.75rem;color:#7f1d1d">
                                    <div style="font-weight:700;margin-bottom:6px">⚠️ Jurusan yang memerlukan penglihatan warna normal:</div>
                                    <ul style="list-style:none;padding:0;margin:0;space-y:4px">
                                        <li>• Teknik Audio Video — warna komponen elektronik</li>
                                        <li>• Desain Komunikasi Visual (DKV) — desain grafis & warna</li>
                                        <li>• Teknik Instalasi Listrik — kode warna kabel</li>
                                        <li>• Teknik Pembangkit Tenaga Listrik — kode warna kabel</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                                <div class="radio-card-group">
                                    <label class="radio-card" id="lblLaki" onclick="selectGender(this,'laki-laki')">
                                        <input type="radio" name="jenis_kelamin" value="laki-laki" required>
                                        <span class="radio-card-label">👦 Laki-laki</span>
                                    </label>
                                    <label class="radio-card" id="lblPerempuan" onclick="selectGender(this,'perempuan')">
                                        <input type="radio" name="jenis_kelamin" value="perempuan" required>
                                        <span class="radio-card-label">👧 Perempuan</span>
                                    </label>
                                </div>
                                <div class="form-hint">Data ini digunakan untuk penyesuaian rekomendasi pada jurusan teknik berat</div>
                            </div>

                        </div>
                    </div>
                    <div class="btn-nav">
                        <div></div>
                        <button type="button" class="btn-next" onclick="nextStep(0)">
                            Selanjutnya: Nilai Akademik <span>→</span>
                        </button>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- STEP 2: NILAI AKADEMIK --}}
                {{-- ============================================================ --}}
                <div class="step-panel" id="step-1">
                    <div class="spk-card">
                        <div class="card-header">
                            <div class="card-header-step">Langkah 2 dari 4</div>
                            <div class="card-header-title">📊 Nilai Akademik</div>
                            <div class="card-header-sub">Masukkan nilai rapor semester terakhir (skala 0–100)</div>
                        </div>
                        <div class="card-body">

                            <div class="syarat-alert" style="background:#eff6ff;border-color:#bfdbfe;color:#1e40af">
                                📝 <strong>Tips:</strong> Masukkan nilai rata-rata semester terakhir dari raport SMP kamu. Nilai ini merupakan faktor utama dalam penentuan rekomendasi jurusan.
                            </div>

                            <div class="grid-3">
                                @php
                                    $matapalajaran = [
                                        ['bahasa_inggris', 'B. Inggris', '🇬🇧'],
                                        ['bahasa_indonesia', 'B. Indonesia', '🇮🇩'],
                                        ['matematika', 'Matematika', '🔢'],
                                        ['ipa', 'IPA', '🔬'],
                                        ['ips', 'IPS', '🌍'],
                                        ['fisika', 'Fisika', '⚡'],
                                        ['biologi', 'Biologi', '🌿'],
                                        ['pkn', 'PKN', '🏛️'],
                                    ];
                                @endphp
                                @foreach($matapalajaran as $mp)
                                <div class="nilai-card">
                                    <div class="nilai-label">{{ $mp[2] }} {{ $mp[1] }}</div>
                                    <input
                                        type="number"
                                        name="nilai_{{ $mp[0] }}"
                                        id="nilai_{{ $mp[0] }}"
                                        class="nilai-input"
                                        placeholder="0"
                                        min="0" max="100"
                                        oninput="updateRataRata()"
                                        required
                                    >
                                    <div class="nilai-scale">0 – 100</div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Rata-rata --}}
                            <div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:14px;padding:18px 22px;margin-top:8px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                                <div>
                                    <div style="font-size:0.7rem;color:rgba(255,255,255,0.6);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Rata-rata Nilai</div>
                                    <div id="rataRata" style="font-size:2rem;font-weight:800;color:var(--accent-light)">—</div>
                                </div>
                                <div id="nilaiKategori" style="font-size:0.8rem;font-weight:600;color:rgba(255,255,255,0.8);text-align:right">Isi semua nilai untuk melihat rata-rata</div>
                            </div>

                        </div>
                    </div>
                    <div class="btn-nav">
                        <button type="button" class="btn-prev" onclick="prevStep(1)">← Kembali</button>
                        <button type="button" class="btn-next" onclick="nextStep(1)">Selanjutnya: Tes Minat → </button>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- STEP 3: TES MINAT & BAKAT --}}
                {{-- ============================================================ --}}
                <div class="step-panel" id="step-2">
                    <div class="spk-card">
                        <div class="card-header">
                            <div class="card-header-step">Langkah 3 dari 4</div>
                            <div class="card-header-title">🧠 Tes Minat & Bakat</div>
                            <div class="card-header-sub">Jawab 10 pertanyaan berikut dengan jujur sesuai keadaan dirimu</div>
                        </div>
                        <div class="card-body">

                            <div class="syarat-alert" style="background:#f0fdf4;border-color:#bbf7d0;color:#14532d">
                                💡 <strong>Petunjuk:</strong> Pilih jawaban yang paling mencerminkan minat dan kemampuanmu. Tidak ada jawaban benar atau salah.
                            </div>

                            {{-- Progress bakat --}}
                            <div style="display:flex;justify-content:space-between;font-size:0.72rem;color:#9ca3af;margin-bottom:8px">
                                <span>Progress pertanyaan</span>
                                <span id="bakatProgress">0 / 10 dijawab</span>
                            </div>
                            <div class="progress-track" style="margin-bottom:20px">
                                <div class="progress-fill" id="bakatFill" style="width:0%;background:var(--success)"></div>
                            </div>

                            @php
                                $pertanyaan = [
                                    [
                                        'no' => 1,
                                        'text' => 'Kegiatanmu di waktu luang paling sering...',
                                        'opsi' => ['Membongkar/merakit barang elektronik', 'Menggambar, desain, atau berkreasi', 'Berhitung, membuat anggaran, atau analisa data', 'Memperbaiki kendaraan atau mesin'],
                                        'field' => 'bakat_q1'
                                    ],
                                    [
                                        'no' => 2,
                                        'text' => 'Pelajaran yang paling kamu sukai di sekolah...',
                                        'opsi' => ['Fisika & IPA', 'Seni & Prakarya', 'Matematika & Ekonomi', 'Teknik & Otomotif'],
                                        'field' => 'bakat_q2'
                                    ],
                                    [
                                        'no' => 3,
                                        'text' => 'Kalau ada perangkat elektronik yang rusak di rumah, kamu...',
                                        'opsi' => ['Penasaran dan coba memperbaikinya sendiri', 'Tidak tertarik, serahkan ke ahlinya', 'Cari tutorial di internet', 'Tergantung situasi'],
                                        'field' => 'bakat_q3'
                                    ],
                                    [
                                        'no' => 4,
                                        'text' => 'Cita-cita atau profesi yang paling kamu inginkan...',
                                        'opsi' => ['Insinyur / Teknisi', 'Desainer / Arsitek', 'Pengusaha / Akuntan', 'Mekanik / Teknisi Kendaraan'],
                                        'field' => 'bakat_q4'
                                    ],
                                    [
                                        'no' => 5,
                                        'text' => 'Saat mengerjakan tugas kelompok, kamu lebih suka...',
                                        'opsi' => ['Mengerjakan bagian teknis & logis', 'Mengerjakan desain & presentasi', 'Mengatur keuangan & administrasi', 'Bagian operasional & lapangan'],
                                        'field' => 'bakat_q5'
                                    ],
                                    [
                                        'no' => 6,
                                        'text' => 'Kamu lebih senang bekerja...',
                                        'opsi' => ['Di depan komputer / teknologi', 'Di studio kreatif / lapangan desain', 'Di kantor / administrasi', 'Di bengkel / lapangan teknik'],
                                        'field' => 'bakat_q6'
                                    ],
                                    [
                                        'no' => 7,
                                        'text' => 'Proyek yang paling ingin kamu kerjakan...',
                                        'opsi' => ['Membangun jaringan komputer atau sistem listrik', 'Membuat poster, video, atau animasi', 'Mengelola laporan keuangan bisnis', 'Merakit atau memodifikasi kendaraan/mesin'],
                                        'field' => 'bakat_q7'
                                    ],
                                    [
                                        'no' => 8,
                                        'text' => 'Kemampuan yang menurutmu paling menonjol dalam dirimu...',
                                        'opsi' => ['Analitis & problem solving teknis', 'Kreativitas & estetika visual', 'Teliti & terorganisir dalam data', 'Kuat secara fisik & terampil tangan'],
                                        'field' => 'bakat_q8'
                                    ],
                                    [
                                        'no' => 9,
                                        'text' => 'Jenis konten yang paling sering kamu tonton atau baca...',
                                        'opsi' => ['Tutorial teknologi & elektronik', 'Desain, seni, dan kreasi', 'Bisnis, investasi, dan keuangan', 'Otomotif, modifikasi, dan mesin'],
                                        'field' => 'bakat_q9'
                                    ],
                                    [
                                        'no' => 10,
                                        'text' => 'Setelah lulus SMK, rencana kamu adalah...',
                                        'opsi' => ['Bekerja di bidang IT / Teknik / Industri', 'Bekerja di bidang kreatif / desain / media', 'Kuliah ekonomi / bisnis / administrasi', 'Bekerja di bidang otomotif / manufaktur'],
                                        'field' => 'bakat_q10'
                                    ],
                                ];
                            @endphp

                            @foreach($pertanyaan as $p)
                            <div class="bakat-question" id="bq{{ $p['no'] }}">
                                <div class="bakat-q-num">Pertanyaan {{ $p['no'] }}</div>
                                <div class="bakat-q-text">{{ $p['text'] }}</div>
                                <div class="bakat-options">
                                    @foreach($p['opsi'] as $idx => $opsi)
                                    <label class="bakat-opt" onclick="pilihBakat({{ $p['no'] }}, this)">
                                        <input type="radio" name="{{ $p['field'] }}" value="{{ $idx + 1 }}" required>
                                        {{ $opsi }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="btn-nav">
                        <button type="button" class="btn-prev" onclick="prevStep(2)">← Kembali</button>
                        <button type="button" class="btn-next" onclick="nextStep(2)">Selanjutnya: Review → </button>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- STEP 4: REVIEW & SUBMIT --}}
                {{-- ============================================================ --}}
                <div class="step-panel" id="step-3">
                    <div class="spk-card">
                        <div class="card-header">
                            <div class="card-header-step">Langkah 4 dari 4</div>
                            <div class="card-header-title">✅ Review & Kirim</div>
                            <div class="card-header-sub">Periksa kembali data yang sudah kamu isi sebelum mengirim</div>
                        </div>
                        <div class="card-body">

                            {{-- Review Data Fisik --}}
                            <div class="review-section">
                                <div class="review-title">📏 Data Fisik & Kesehatan</div>
                                <div class="review-grid">
                                    <div class="review-item">
                                        <div class="review-item-label">Tinggi Badan</div>
                                        <div class="review-item-value" id="rev_tinggi">—</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-item-label">Berat Badan</div>
                                        <div class="review-item-value" id="rev_berat">—</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-item-label">Buta Warna</div>
                                        <div class="review-item-value" id="rev_buta">—</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-item-label">Jenis Kelamin</div>
                                        <div class="review-item-value" id="rev_gender">—</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Review Nilai --}}
                            <div class="review-section">
                                <div class="review-title">📊 Nilai Akademik</div>
                                <div class="review-grid">
                                    <div class="review-item"><div class="review-item-label">B. Inggris</div><div class="review-item-value" id="rev_inggris">—</div></div>
                                    <div class="review-item"><div class="review-item-label">B. Indonesia</div><div class="review-item-value" id="rev_indonesia">—</div></div>
                                    <div class="review-item"><div class="review-item-label">Matematika</div><div class="review-item-value" id="rev_mtk">—</div></div>
                                    <div class="review-item"><div class="review-item-label">IPA</div><div class="review-item-value" id="rev_ipa">—</div></div>
                                    <div class="review-item"><div class="review-item-label">IPS</div><div class="review-item-value" id="rev_ips">—</div></div>
                                    <div class="review-item"><div class="review-item-label">Fisika</div><div class="review-item-value" id="rev_fisika">—</div></div>
                                    <div class="review-item"><div class="review-item-label">Biologi</div><div class="review-item-value" id="rev_biologi">—</div></div>
                                    <div class="review-item"><div class="review-item-label">PKN</div><div class="review-item-value" id="rev_pkn">—</div></div>
                                </div>
                                <div style="margin-top:10px;background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:12px;padding:14px 18px;display:flex;justify-content:space-between;align-items:center">
                                    <span style="color:rgba(255,255,255,0.7);font-size:0.75rem;font-weight:600">Rata-rata Nilai</span>
                                    <span id="rev_rata" style="color:var(--accent-light);font-size:1.3rem;font-weight:800">—</span>
                                </div>
                            </div>

                            {{-- Review Minat --}}
                            <div class="review-section">
                                <div class="review-title">🧠 Minat & Bakat</div>
                                <div id="rev_bakat" class="review-grid">
                                    <div class="review-item" style="grid-column:1/-1;text-align:center;color:#9ca3af;font-size:0.78rem">Selesaikan tes bakat terlebih dahulu</div>
                                </div>
                            </div>

                            {{-- Disclaimer --}}
                            <div style="background:#f0f4fa;border-radius:12px;padding:16px;margin-top:4px">
                                <div style="font-size:0.75rem;color:#374151;line-height:1.6">
                                    <strong>📋 Pernyataan:</strong> Dengan mengirim data ini, saya menyatakan bahwa semua informasi yang saya isi adalah <strong>benar dan jujur</strong>. Hasil rekomendasi SPK ini bersifat pendukung keputusan dan tidak mengikat secara hukum.
                                </div>
                                <label style="display:flex;align-items:center;gap:8px;margin-top:12px;cursor:pointer">
                                    <input type="checkbox" id="setuju" name="setuju" value="1" style="width:16px;height:16px;accent-color:var(--primary)" required>
                                    <span style="font-size:0.78rem;font-weight:600;color:#374151">Saya menyetujui pernyataan di atas</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="btn-nav">
                        <button type="button" class="btn-prev" onclick="prevStep(3)">← Kembali</button>
                        <button type="submit" class="btn-submit">
                            🚀 Kirim & Lihat Hasil SPK
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        let currentStep = 0;
        const totalSteps = 4;
        const pct = [25, 50, 75, 100];
        const labels = ['Langkah 1 dari 4', 'Langkah 2 dari 4', 'Langkah 3 dari 4', 'Langkah 4 dari 4'];

        // ===== STEPPER =====
        function updateStepper(step) {
            for (let i = 0; i < totalSteps; i++) {
                const nav = document.getElementById('nav-' + i);
                const circle = nav.querySelector('.step-circle');
                nav.classList.remove('active', 'done');
                if (i < step) {
                    nav.classList.add('done');
                    circle.innerHTML = '✓';
                } else if (i === step) {
                    nav.classList.add('active');
                    circle.innerHTML = i + 1;
                } else {
                    circle.innerHTML = i + 1;
                }
            }
            document.getElementById('progressFill').style.width = pct[step] + '%';
            document.getElementById('progressLabel').textContent = labels[step];
            document.getElementById('progressPct').textContent = pct[step] + '%';
        }

        function showStep(step) {
            document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');
            updateStepper(step);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function nextStep(from) {
            if (!validateStep(from)) return;
            if (from === 3 - 1) updateReview(); // before last step, update review
            currentStep = from + 1;
            if (currentStep === 3) updateReview();
            showStep(currentStep);
        }

        function prevStep(from) {
            currentStep = from - 1;
            showStep(currentStep);
        }

        // ===== VALIDATION =====
        function validateStep(step) {
            if (step === 0) {
                const tinggi = document.getElementById('tinggi_badan').value;
                const berat = document.getElementById('berat_badan').value;
                const buta = document.getElementById('buta_warna').value;
                const gender = document.querySelector('input[name="jenis_kelamin"]:checked');
                if (!tinggi || tinggi < 100 || tinggi > 220) { alert('Masukkan tinggi badan yang valid (100-220 cm)'); return false; }
                if (!berat || berat < 20 || berat > 200) { alert('Masukkan berat badan yang valid (20-200 kg)'); return false; }
                if (!buta) { alert('Pilih status buta warna kamu'); return false; }
                if (!gender) { alert('Pilih jenis kelamin kamu'); return false; }
            }
            if (step === 1) {
                const fields = ['bahasa_inggris','bahasa_indonesia','matematika','ipa','ips','fisika','biologi','pkn'];
                for (let f of fields) {
                    const val = document.getElementById('nilai_' + f).value;
                    if (!val || val < 0 || val > 100) {
                        alert('Pastikan semua nilai diisi dengan benar (0-100)');
                        return false;
                    }
                }
            }
            if (step === 2) {
                for (let i = 1; i <= 10; i++) {
                    const ans = document.querySelector('input[name="bakat_q' + i + '"]:checked');
                    if (!ans) { alert('Jawab semua pertanyaan minat bakat (pertanyaan ' + i + ' belum dijawab)'); return false; }
                }
            }
            return true;
        }

        // ===== BMI CALCULATOR =====
        function calcBMI() {
            const t = parseFloat(document.getElementById('tinggi_badan').value);
            const b = parseFloat(document.getElementById('berat_badan').value);
            if (t > 0 && b > 0) {
                const bmi = (b / ((t/100) * (t/100))).toFixed(1);
                let cat = '', color = '';
                if (bmi < 18.5) { cat = 'Berat Badan Kurang'; color = '#3b82f6'; }
                else if (bmi < 25) { cat = 'Normal / Ideal'; color = '#10b981'; }
                else if (bmi < 30) { cat = 'Berat Badan Lebih'; color = '#f59e0b'; }
                else { cat = 'Obesitas'; color = '#ef4444'; }
                document.getElementById('bmiCard').style.display = 'block';
                document.getElementById('bmiValue').textContent = bmi;
                document.getElementById('bmiCategory').textContent = cat;
                document.getElementById('bmiCategory').style.color = color;
            }
        }
        document.getElementById('tinggi_badan').addEventListener('input', calcBMI);
        document.getElementById('berat_badan').addEventListener('input', calcBMI);

        // ===== BUTA WARNA TOGGLE =====
        function setButaWarna(val) {
            document.getElementById('buta_warna').value = val;
            const ya = document.getElementById('btnButaYa');
            const tidak = document.getElementById('btnButaTidak');
            ya.className = 'toggle-btn' + (val === 'ya' ? ' selected-yes' : '');
            tidak.className = 'toggle-btn' + (val === 'tidak' ? ' selected-no' : '');
            document.getElementById('butaWarnaInfo').style.display = val === 'ya' ? 'block' : 'none';
        }

        // ===== GENDER RADIO =====
        function selectGender(el, val) {
            document.querySelectorAll('.radio-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        // ===== NILAI RATA-RATA =====
        function updateRataRata() {
            const fields = ['bahasa_inggris','bahasa_indonesia','matematika','ipa','ips','fisika','biologi','pkn'];
            let total = 0, count = 0;
            for (let f of fields) {
                const v = parseFloat(document.getElementById('nilai_' + f).value);
                if (!isNaN(v) && v >= 0 && v <= 100) { total += v; count++; }
            }
            const el = document.getElementById('rataRata');
            const kat = document.getElementById('nilaiKategori');
            if (count === fields.length) {
                const avg = (total / count).toFixed(1);
                el.textContent = avg;
                if (avg >= 90) kat.textContent = '⭐ Sangat Baik';
                else if (avg >= 80) kat.textContent = '👍 Baik';
                else if (avg >= 70) kat.textContent = '✅ Cukup';
                else kat.textContent = '📚 Perlu Ditingkatkan';
            } else {
                el.textContent = '—';
                kat.textContent = count + ' dari ' + fields.length + ' nilai terisi';
            }
        }

        // ===== BAKAT QUESTION =====
        let bakatAnswered = 0;
        function pilihBakat(no, el) {
            const container = document.getElementById('bq' + no);
            const opts = container.querySelectorAll('.bakat-opt');
            const wasAnswered = container.classList.contains('answered');
            opts.forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
            if (!wasAnswered) {
                container.classList.add('answered');
                bakatAnswered++;
                updateBakatProgress();
            }
        }
        function updateBakatProgress() {
            document.getElementById('bakatProgress').textContent = bakatAnswered + ' / 10 dijawab';
            document.getElementById('bakatFill').style.width = (bakatAnswered * 10) + '%';
        }

        // ===== REVIEW =====
        function updateReview() {
            // Fisik
            const t = document.getElementById('tinggi_badan').value;
            const b = document.getElementById('berat_badan').value;
            const buta = document.getElementById('buta_warna').value;
            const gender = document.querySelector('input[name="jenis_kelamin"]:checked');
            document.getElementById('rev_tinggi').textContent = t ? t + ' cm' : '—';
            document.getElementById('rev_berat').textContent = b ? b + ' kg' : '—';
            document.getElementById('rev_buta').textContent = buta === 'ya' ? '🔴 Ya, Buta Warna' : buta === 'tidak' ? '🟢 Tidak, Normal' : '—';
            document.getElementById('rev_gender').textContent = gender ? (gender.value === 'laki-laki' ? '👦 Laki-laki' : '👧 Perempuan') : '—';

            // Nilai
            const mapNilai = {inggris:'bahasa_inggris', indonesia:'bahasa_indonesia', mtk:'matematika', ipa:'ipa', ips:'ips', fisika:'fisika', biologi:'biologi', pkn:'pkn'};
            let total = 0, count = 0;
            for (let [rev, field] of Object.entries(mapNilai)) {
                const v = document.getElementById('nilai_' + field).value;
                document.getElementById('rev_' + rev).textContent = v ? v : '—';
                if (v) { total += parseFloat(v); count++; }
            }
            document.getElementById('rev_rata').textContent = count === 8 ? (total/8).toFixed(1) : '—';

            // Bakat
            const bakatMap = ['Teknis/Logis','Kreatif/Visual','Bisnis/Administrasi','Otomotif/Mekanikal'];
            let bakatHtml = '';
            let scores = [0,0,0,0];
            for (let i = 1; i <= 10; i++) {
                const ans = document.querySelector('input[name="bakat_q' + i + '"]:checked');
                if (ans) { scores[parseInt(ans.value)-1]++; }
            }
            const maxScore = Math.max(...scores);
            for (let i = 0; i < 4; i++) {
                const pct = Math.round((scores[i]/10)*100);
                bakatHtml += `<div class="review-item"><div class="review-item-label">${bakatMap[i]}</div><div class="review-item-value">${scores[i]}/10 (${pct}%)</div></div>`;
            }
            document.getElementById('rev_bakat').innerHTML = bakatHtml || '<div class="review-item" style="grid-column:1/-1;text-align:center;color:#9ca3af">Belum ada jawaban</div>';
        }
    </script>

</x-app-layout>