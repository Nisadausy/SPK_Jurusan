<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hasil SPK - {{ $siswa->nama ?? '' }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; background: #fff; color: #1a2540; font-size: 13px; }

        .pdf-wrapper { max-width: 800px; margin: 0 auto; padding: 32px 36px; }

        /* HEADER */
        .pdf-header { display: flex; align-items: center; gap: 20px; border-bottom: 3px solid #1a3c6e; padding-bottom: 16px; margin-bottom: 24px; }
        .pdf-logo { width: 60px; height: 60px; background: linear-gradient(135deg,#1a3c6e,#2a5298); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; font-weight: 900; flex-shrink: 0; }
        .pdf-school { flex: 1; }
        .pdf-school-name { font-size: 16px; font-weight: 800; color: #1a3c6e; line-height: 1.2; }
        .pdf-school-sub  { font-size: 11px; color: #6b7a8d; margin-top: 2px; }
        .pdf-title-box { text-align: right; }
        .pdf-title-box h2 { font-size: 15px; font-weight: 800; color: #1a3c6e; }
        .pdf-title-box p  { font-size: 10px; color: #6b7a8d; margin-top: 2px; }

        /* REKOMENDASI UTAMA */
        .rec-box {
            background: linear-gradient(135deg, #1a3c6e, #2a5298);
            border-radius: 12px; padding: 20px 24px; margin-bottom: 20px;
            color: white; text-align: center;
        }
        .rec-box .rec-label { font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.6); margin-bottom: 6px; }
        .rec-box .rec-name  { font-size: 22px; font-weight: 900; color: #f4b942; margin-bottom: 6px; }
        .rec-box .rec-score { font-size: 13px; color: rgba(255,255,255,.8); }
        .rec-box .rec-badge { display: inline-block; background: rgba(244,185,66,.2); border: 1px solid rgba(244,185,66,.4); border-radius: 100px; padding: 4px 16px; font-size: 12px; font-weight: 700; color: #f4b942; margin-top: 8px; }

        /* INFO GRID */
        .section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #1a3c6e; border-bottom: 2px solid #e8a020; padding-bottom: 5px; margin-bottom: 12px; margin-top: 20px; }
        .info-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 4px; }
        .info-item { background: #f0f4fa; border-radius: 8px; padding: 9px 12px; }
        .info-item-label { font-size: 9px; color: #6b7a8d; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 3px; }
        .info-item-value { font-size: 13px; font-weight: 800; color: #1a2540; }

        /* RANKING TABLE */
        .ranking-table { width: 100%; border-collapse: collapse; margin-top: 4px; }
        .ranking-table th { background: #1a3c6e; color: white; padding: 9px 12px; text-align: left; font-size: 11px; font-weight: 700; }
        .ranking-table td { padding: 9px 12px; border-bottom: 1px solid #e8edf5; font-size: 12px; }
        .ranking-table tr:nth-child(even) td { background: #f8fafc; }
        .ranking-table tr.best td { background: #fff8e7; color: #7c5c10; font-weight: 700; }
        .ranking-table .rank-num { width: 36px; height: 36px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; }
        .rank-1 { background: linear-gradient(135deg,#f4b942,#e8a020); color: #111; }
        .rank-2 { background: #c0c0c0; color: #111; }
        .rank-3 { background: #cd7f32; color: white; }
        .rank-n { background: #e5eaf3; color: #6b7a8d; }

        /* BAR */
        .bar-wrap { background: #e5eaf3; border-radius: 100px; height: 8px; overflow: hidden; width: 100px; display: inline-block; vertical-align: middle; margin-right: 6px; }
        .bar-fill { height: 100%; border-radius: 100px; background: linear-gradient(90deg,#f4b942,#e07b54); }

        /* FOOTER */
        .pdf-footer { margin-top: 32px; padding-top: 14px; border-top: 1px solid #e5eaf3; display: flex; justify-content: space-between; font-size: 10px; color: #9ca3af; }

        /* PRINT */
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .pdf-wrapper { padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="pdf-wrapper">

    {{-- TOMBOL CETAK (hanya di browser, hilang saat print) --}}
    <div class="no-print" style="text-align:right;margin-bottom:16px">
        <button onclick="window.print()" style="background:#1a3c6e;color:white;border:none;padding:10px 22px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer">
            🖨 Cetak / Save PDF
        </button>
        <a href="{{ route('siswa.tes.hasil') }}" style="margin-left:10px;color:#6b7a8d;font-size:12px;text-decoration:none">← Kembali</a>
    </div>

    {{-- HEADER --}}
    <div class="pdf-header">
        <div class="pdf-logo">S2J</div>
        <div class="pdf-school">
            <div class="pdf-school-name">SMK Negeri 2 Jember</div>
            <div class="pdf-school-sub">Sistem Pendukung Keputusan Pemilihan Jurusan</div>
        </div>
        <div class="pdf-title-box">
            <h2>Hasil Tes SPK</h2>
            <p>Metode Simple Additive Weighting (SAW)</p>
            <p>{{ now()->format('d F Y') }}</p>
        </div>
    </div>

    {{-- INFO SISWA --}}
    <div class="section-title">Data Siswa</div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-item-label">Nama Siswa</div>
            <div class="info-item-value">{{ $siswa->nama ?? Auth::user()->name }}</div>
        </div>
        <div class="info-item">
            <div class="info-item-label">Tanggal Tes</div>
            <div class="info-item-value">{{ $tesTerakhir->created_at->format('d M Y') }}</div>
        </div>
        <div class="info-item">
            <div class="info-item-label">Nilai Akademik</div>
            <div class="info-item-value">{{ number_format($tesTerakhir->nilai_akademik, 1) }}</div>
        </div>
        <div class="info-item">
            <div class="info-item-label">Skor Minat Bakat</div>
            <div class="info-item-value">{{ $tesTerakhir->skor_minat_bakat }}%</div>
        </div>
    </div>

    {{-- REKOMENDASI UTAMA --}}
    @php $rekomendasi = $hasilList->first(); @endphp
    <div class="section-title">Rekomendasi Jurusan</div>
    <div class="rec-box">
        <div class="rec-label">🏆 Jurusan Terbaik Untukmu</div>
        <div class="rec-name">{{ $rekomendasi->jurusan->nama_jurusan ?? '-' }}</div>
        <div class="rec-score">Nilai Preferensi SAW Tertinggi</div>
        <div class="rec-badge">Skor: {{ number_format($rekomendasi->nilai_preferensi * 100, 2) }}%</div>
    </div>

    {{-- RANKING TABLE --}}
    <div class="section-title">Ranking Semua Jurusan (SAW)</div>
    <table class="ranking-table">
        <thead>
            <tr>
                <th style="width:50px">Rank</th>
                <th>Nama Jurusan</th>
                <th style="width:160px">Visualisasi Skor</th>
                <th style="width:120px">Nilai Preferensi</th>
                <th style="width:80px">Skor (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasilList as $i => $hasil)
            @php
                $rankClass = $i === 0 ? 'best' : '';
                $numClass  = $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-n'));
                $barPct    = round(($hasil->nilai_preferensi / $hasilList->first()->nilai_preferensi) * 100);
            @endphp
            <tr class="{{ $rankClass }}">
                <td style="text-align:center">
                    <span class="rank-num {{ $numClass }}">{{ $hasil->peringkat }}</span>
                </td>
                <td>{{ $hasil->jurusan->nama_jurusan ?? '-' }}</td>
                <td>
                    <div class="bar-wrap">
                        <div class="bar-fill" style="width:{{ $barPct }}%"></div>
                    </div>
                    {{ $barPct }}%
                </td>
                <td style="font-weight:700">{{ number_format($hasil->nilai_preferensi, 6) }}</td>
                <td style="font-weight:800;color:{{ $i===0 ? '#7c5c10' : '#374151' }}">
                    {{ number_format($hasil->nilai_preferensi * 100, 2) }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="pdf-footer">
        <span>SMK Negeri 2 Jember — Sistem Pendukung Keputusan Pemilihan Jurusan</span>
        <span>Dicetak: {{ now()->format('d F Y, H:i') }} WIB</span>
    </div>

</div>
</body>
</html>