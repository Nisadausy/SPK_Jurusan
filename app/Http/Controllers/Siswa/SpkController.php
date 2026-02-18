<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Tes;
use App\Models\SoalMinat;
use App\Models\JawabanMinat;
use App\Models\Jurusan;
use App\Models\HasilSaw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpkController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)->first();
        if (!$siswa) {
            return redirect()->route('home')->withErrors('Akses ditolak: akun ini bukan siswa.');
        }

        $soal = SoalMinat::where('is_active', true)->orderBy('id')->get();

        $tesTerakhir = Tes::where('siswa_id', $siswa->id)->latest()->first();
        $riwayatHasil = $tesTerakhir
            ? HasilSaw::where('tes_id', $tesTerakhir->id)->orderBy('peringkat')->get()
            : collect();

        return view('pages.siswa.tes', compact('siswa', 'soal', 'tesTerakhir', 'riwayatHasil'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('home')->withErrors('Akses ditolak: akun ini bukan siswa.');
        }

        // === VALIDASI SESUAI FORM BLADE KAMU ===
        $validated = $request->validate([
            'tinggi_badan' => 'required|numeric|min:100|max:220',
            'berat_badan'  => 'required|numeric|min:20|max:200',
            'buta_warna'   => 'required|in:ya,tidak',
            'jenis_kelamin'=> 'required|in:laki-laki,perempuan',

            // nilai mapel
            'nilai_bahasa_inggris'   => 'required|numeric|min:0|max:100',
            'nilai_bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_matematika'       => 'required|numeric|min:0|max:100',
            'nilai_ipa'              => 'required|numeric|min:0|max:100',
            'nilai_ips'              => 'required|numeric|min:0|max:100',
            'nilai_fisika'           => 'required|numeric|min:0|max:100',
            'nilai_biologi'          => 'required|numeric|min:0|max:100',
            'nilai_pkn'              => 'required|numeric|min:0|max:100',

            // tes minat bakat (10 pertanyaan, value 1..4)
            'bakat_q1'  => 'required|integer|min:1|max:4',
            'bakat_q2'  => 'required|integer|min:1|max:4',
            'bakat_q3'  => 'required|integer|min:1|max:4',
            'bakat_q4'  => 'required|integer|min:1|max:4',
            'bakat_q5'  => 'required|integer|min:1|max:4',
            'bakat_q6'  => 'required|integer|min:1|max:4',
            'bakat_q7'  => 'required|integer|min:1|max:4',
            'bakat_q8'  => 'required|integer|min:1|max:4',
            'bakat_q9'  => 'required|integer|min:1|max:4',
            'bakat_q10' => 'required|integer|min:1|max:4',

            // persetujuan di step 4
            'setuju' => 'required|in:1',
        ]);

        // === HITUNG NILAI AKADEMIK (rata2 8 mapel) ===
        $nilaiMapel = [
            $validated['nilai_bahasa_inggris'],
            $validated['nilai_bahasa_indonesia'],
            $validated['nilai_matematika'],
            $validated['nilai_ipa'],
            $validated['nilai_ips'],
            $validated['nilai_fisika'],
            $validated['nilai_biologi'],
            $validated['nilai_pkn'],
        ];
        $nilaiAkademik = round(array_sum($nilaiMapel) / count($nilaiMapel), 2); // 0..100

        // === HITUNG SKOR MINAT BAKAT (dominansi jawaban) ===
        // value 1..4 -> kategori (Teknis/Logis, Kreatif/Visual, Bisnis/Admin, Otomotif/Mekanik)
        $jawabanBakat = [];
        for ($i = 1; $i <= 10; $i++) {
            $jawabanBakat[] = (int)$validated["bakat_q{$i}"];
        }
        $count = [0, 0, 0, 0];
        foreach ($jawabanBakat as $val) {
            $count[$val - 1]++;
        }
        $max = max($count); // 0..10
        $skorMinatBakat = (int) round(($max / 10) * 100); // 0..100

        DB::transaction(function () use ($validated, $siswa, $nilaiAkademik, $skorMinatBakat, $jawabanBakat) {

            // 1) Simpan TES
            $tes = Tes::create([
                'siswa_id' => $siswa->id,
                'nilai_akademik' => $nilaiAkademik,
                'skor_minat_bakat' => $skorMinatBakat,
                'tinggi_badan' => $validated['tinggi_badan'],
                'berat_badan' => $validated['berat_badan'],
                'buta_warna' => ($validated['buta_warna'] === 'ya'),
                // kalau tabel tes kamu tidak punya jenis_kelamin, hapus baris ini
                // 'jenis_kelamin' => $validated['jenis_kelamin'],
            ]);

            // 2) Simpan Jawaban Minat (opsional, sesuai tabel soal_minat)
            // Ambil 10 soal aktif pertama supaya ada relasi soal_minat_id
            $soalAktif = SoalMinat::where('is_active', true)->orderBy('id')->take(10)->get();

            // kalau soalnya ada 10, simpan 1-1
            if ($soalAktif->count() === 10) {
                foreach ($soalAktif as $idx => $soal) {
                    JawabanMinat::create([
                        'tes_id' => $tes->id,
                        'soal_minat_id' => $soal->id,
                        'skor' => $jawabanBakat[$idx], // 1..4
                    ]);
                }
            }

            // 3) Hitung & simpan hasil SAW (contoh sederhana)
            $jurusans = Jurusan::where('is_active', true)->orderBy('id')->get();

            $wAkademik = 0.6;
            $wMinat    = 0.4;

            $rAkademik = min(max($tes->nilai_akademik / 100, 0), 1);
            $rMinat    = min(max($tes->skor_minat_bakat / 100, 0), 1);

            $rows = [];
            foreach ($jurusans as $j) {
                $nilaiPreferensi = ($wAkademik * $rAkademik) + ($wMinat * $rMinat);
                $rows[] = [
                    'jurusan_id' => $j->id,
                    'nilai_preferensi' => round($nilaiPreferensi, 6),
                ];
            }

            usort($rows, fn($a, $b) => $b['nilai_preferensi'] <=> $a['nilai_preferensi']);

            foreach ($rows as $idx => $row) {
                HasilSaw::create([
                    'tes_id' => $tes->id,
                    'jurusan_id' => $row['jurusan_id'],
                    'nilai_preferensi' => $row['nilai_preferensi'],
                    'peringkat' => $idx + 1,
                ]);
            }
        });

        return redirect()->route('siswa.tes.hasil');
    }

    public function hasil()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('home')->withErrors('Akses ditolak: akun ini bukan siswa.');
        }

        $tesTerakhir = Tes::where('siswa_id', $siswa->id)->latest()->first();
        if (!$tesTerakhir) {
            return redirect()->route('siswa.tes.index');
        }

        $hasilList = HasilSaw::where('tes_id', $tesTerakhir->id)
            ->with('jurusan')
            ->orderBy('peringkat')
            ->get();

        if ($hasilList->isEmpty()) {
            return redirect()->route('siswa.tes.index');
        }

        return view('pages.siswa.hasil', compact('siswa', 'tesTerakhir', 'hasilList'));
    }

    // ✅ DITAMBAHKAN — tidak mengubah apapun di atas
    public function cetakPdf()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) abort(403);

        $tesTerakhir = Tes::where('siswa_id', $siswa->id)->latest()->first();
        if (!$tesTerakhir) abort(404);

        $hasilList = HasilSaw::where('tes_id', $tesTerakhir->id)
            ->with('jurusan')
            ->orderBy('peringkat')
            ->get();

        return view('pages.siswa.hasil-pdf', compact('siswa', 'tesTerakhir', 'hasilList'));
    }
}