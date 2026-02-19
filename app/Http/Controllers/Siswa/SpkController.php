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

        $jurusan = Jurusan::where('is_active', true)->orderBy('nama_jurusan')->get();

        return view('pages.siswa.tes', compact('siswa', 'soal', 'tesTerakhir', 'riwayatHasil', 'jurusan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('home')->withErrors('Akses ditolak: akun ini bukan siswa.');
        }

        $validated = $request->validate([
            'jurusan_pilihan_2' => 'required|exists:jurusan,id',

            'tinggi_badan'  => 'required|numeric|min:100|max:220',
            'berat_badan'   => 'required|numeric|min:20|max:200',
            'buta_warna'    => 'required|in:ya,tidak',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',

            'nilai_bahasa_inggris'   => 'required|numeric|min:0|max:100',
            'nilai_bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_matematika'       => 'required|numeric|min:0|max:100',
            'nilai_ipa'              => 'required|numeric|min:0|max:100',
            'nilai_ips'              => 'required|numeric|min:0|max:100',
            'nilai_fisika'           => 'required|numeric|min:0|max:100',
            'nilai_biologi'          => 'required|numeric|min:0|max:100',
            'nilai_pkn'              => 'required|numeric|min:0|max:100',

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

            'setuju' => 'required|in:1',
        ]);

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
        $nilaiAkademik = round(array_sum($nilaiMapel) / count($nilaiMapel), 2);

        $jawabanBakat = [];
        for ($i = 1; $i <= 10; $i++) {
            $jawabanBakat[] = (int)$validated["bakat_q{$i}"];
        }
        $count = [0, 0, 0, 0];
        foreach ($jawabanBakat as $val) {
            $count[$val - 1]++;
        }
        $max = max($count);
        $skorMinatBakat = (int) round(($max / 10) * 100);

        DB::transaction(function () use ($validated, $siswa, $nilaiAkademik, $skorMinatBakat, $jawabanBakat) {

            $tes = Tes::create([
                'siswa_id'           => $siswa->id,
                'nilai_akademik'     => $nilaiAkademik,
                'skor_minat_bakat'   => $skorMinatBakat,
                'tinggi_badan'       => $validated['tinggi_badan'],
                'berat_badan'        => $validated['berat_badan'],
                'buta_warna'         => ($validated['buta_warna'] === 'ya'),
                'minat_jurusan_1_id' => $validated['jurusan_pilihan_1'],
                'minat_jurusan_2_id' => $validated['jurusan_pilihan_2'],
            ]);

            $soalAktif = SoalMinat::where('is_active', true)->orderBy('id')->take(10)->get();
            if ($soalAktif->count() === 10) {
                foreach ($soalAktif as $idx => $soal) {
                    JawabanMinat::create([
                        'tes_id'        => $tes->id,
                        'soal_minat_id' => $soal->id,
                        'skor'          => $jawabanBakat[$idx],
                    ]);
                }
            }

            $jurusans  = Jurusan::where('is_active', true)->orderBy('id')->get();
            $wAkademik = 0.6;
            $wMinat    = 0.4;
            $rAkademik = min(max($tes->nilai_akademik / 100, 0), 1);
            $rMinat    = min(max($tes->skor_minat_bakat / 100, 0), 1);

            $rows = [];
            foreach ($jurusans as $j) {
                $nilaiPreferensi = ($wAkademik * $rAkademik) + ($wMinat * $rMinat);
                $rows[] = [
                    'jurusan_id'       => $j->id,
                    'nilai_preferensi' => round($nilaiPreferensi, 6),
                ];
            }

            usort($rows, fn($a, $b) => $b['nilai_preferensi'] <=> $a['nilai_preferensi']);

            foreach ($rows as $idx => $row) {
                HasilSaw::create([
                    'tes_id'           => $tes->id,
                    'jurusan_id'       => $row['jurusan_id'],
                    'nilai_preferensi' => $row['nilai_preferensi'],
                    'peringkat'        => $idx + 1,
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

        $jurusanPilihan1 = Jurusan::find($tesTerakhir->minat_jurusan_1_id);
        $jurusanPilihan2 = Jurusan::find($tesTerakhir->minat_jurusan_2_id);
        $skorPilihan1    = $hasilList->firstWhere('jurusan_id', $tesTerakhir->minat_jurusan_1_id);
        $skorPilihan2    = $hasilList->firstWhere('jurusan_id', $tesTerakhir->minat_jurusan_2_id);

        return view('pages.siswa.hasil', compact(
            'siswa',
            'tesTerakhir',
            'hasilList',
            'jurusanPilihan1',
            'jurusanPilihan2',
            'skorPilihan1',
            'skorPilihan2'
        ));
    }

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

    public function history()
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();

        if (!$siswa) {
            return view('pages.siswa.history', ['histories' => collect()]);
        }

        $histories = Tes::where('siswa_id', $siswa->id)
            ->with(['hasilSaw.jurusan'])
            ->latest()
            ->paginate(10);

        return view('pages.siswa.history', compact('histories'));
    }
}