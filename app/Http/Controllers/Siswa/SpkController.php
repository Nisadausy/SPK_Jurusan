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
use Illuminate\Support\Facades\Storage;
use App\Models\Upload;
use App\Models\TesPdf;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;


class SpkController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $siswa = Siswa::with('user')->where('user_id', $user->id)->first();
        if (!$siswa) {
            return redirect()->route('landing.home')->withErrors('Akses ditolak: akun ini bukan siswa.');
        }

        // ✅ Soal dinamis dari DB (admin bisa edit)
        $soal = SoalMinat::where('is_active', true)
            ->orderBy('id')
            ->take(10)
            ->get();

        // (opsional) kalau soal kurang dari 10, tampilkan info
        if ($soal->count() < 10) {
            session()->flash('info', 'Soal minat aktif belum mencapai 10 butir. Hubungi admin untuk melengkapi.');
        }

        $tesTerakhir = Tes::where('siswa_id', $siswa->id)->latest()->first();
        $riwayatHasil = $tesTerakhir
            ? HasilSaw::where('tes_id', $tesTerakhir->id)->orderBy('peringkat')->get()
            : collect();

        $jurusan = Jurusan::where('is_active', true)->orderBy('nama_jurusan')->get();

        return view('pages.siswa.tes', compact('siswa', 'soal', 'tesTerakhir', 'riwayatHasil', 'jurusan'));
    }

    public function store(Request $request)
    {
        $user  = Auth::user();
        $siswa = Siswa::with('user')->where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('landing.home')->withErrors('Akses ditolak: akun ini bukan siswa.');
        }

        // ✅ Ambil soal aktif (dinamis) untuk disimpan ke jawaban_minat
        $soalAktif = SoalMinat::where('is_active', true)
            ->orderBy('id')
            ->take(10)
            ->get();

        if ($soalAktif->count() < 10) {
            return back()->withErrors('Soal minat aktif belum mencapai 10. Hubungi admin.')->withInput();
        }

        // ===== VALIDASI =====
        $validated = $request->validate([
            'jurusan_pilihan_1' => 'required|exists:jurusan,id',
            'jurusan_pilihan_2' => 'required|exists:jurusan,id|different:jurusan_pilihan_1',

            'tinggi_badan'  => 'required|numeric|min:100|max:220',
            'berat_badan'   => 'required|numeric|min:20|max:200',
            'buta_warna'    => 'required|in:ya,tidak',
            // ✅ jenis_kelamin tetap ada di profil, tapi ini untuk TES masih dipakai di form kamu.
            // Kalau nanti kamu mau hilangkan dari tes, itu step berikutnya.

            'nilai_bahasa_inggris'   => 'required|numeric|min:0|max:100',
            'nilai_bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_matematika'       => 'required|numeric|min:0|max:100',
            'nilai_ipa'              => 'required|numeric|min:0|max:100',
            'nilai_ips'              => 'required|numeric|min:0|max:100',
            'nilai_fisika'           => 'required|numeric|min:0|max:100',
            'nilai_biologi'          => 'required|numeric|min:0|max:100',
            'nilai_pkn'              => 'required|numeric|min:0|max:100',

            // ✅ tetap pakai bakat_q1..bakat_q10 agar cocok dengan blade kamu
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

        // ===== HITUNG NILAI AKADEMIK =====
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

        // ===== HITUNG SKOR MINAT BAKAT: BOBOT SAMA =====
        $jawabanBakat = [];
        for ($i = 1; $i <= 10; $i++) {
            $jawabanBakat[] = (int) $validated["bakat_q{$i}"];
        }

        // skala 1..4 => max total = 10*4=40
        $sumSkor = array_sum($jawabanBakat);
        $skorMinatBakat = (int) round(($sumSkor / (10 * 4)) * 100); // 0..100

        DB::transaction(function () use ($validated, $siswa, $nilaiAkademik, $skorMinatBakat, $jawabanBakat, $soalAktif) {

            // ===== SIMPAN TES =====
            $tes = Tes::create([
                'siswa_id'           => $siswa->id,
                'nilai_akademik'     => $nilaiAkademik,
                'skor_minat_bakat'   => $skorMinatBakat,
                'tinggi_badan'       => $validated['tinggi_badan'],
                'berat_badan'        => $validated['berat_badan'],
                'buta_warna'         => ($validated['buta_warna'] === 'ya'),

                // DB FIX kamu sudah punya minat_jurusan_1_id dan minat_jurusan_2_id
                'minat_jurusan_1_id' => $validated['jurusan_pilihan_1'],
                'minat_jurusan_2_id' => $validated['jurusan_pilihan_2'],
            ]);

            // ===== SIMPAN JAWABAN MINAT (DINAMIS DARI DB) =====
            foreach ($soalAktif as $idx => $soal) {
                JawabanMinat::create([
                    'tes_id'        => $tes->id,
                    'soal_minat_id' => $soal->id,
                    'skor'          => $jawabanBakat[$idx], // idx 0..9
                ]);
            }

            // ===== PERHITUNGAN SAW (sesuai versi sederhana yang kamu pakai) =====
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

            $ok = $this->generateAndStorePdf($tes);

            if (!$ok) {
                // jangan rollback hasil SAW; cukup simpan warning agar user tahu
                // (kalau kamu mau rollback semua, harus throw exception)
                Log::warning('PDF gagal dibuat saat store tes', ['tes_id' => $tes->id]);
            }
        });

        return redirect()->route('siswa.tes.hasil');
    }

    public function hasil()
    {
        $user  = Auth::user();
        $siswa = Siswa::with('user')->where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('landing.home')->withErrors('Akses ditolak: akun ini bukan siswa.');
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

        $skorPilihan1 = $tesTerakhir->minat_jurusan_1_id
            ? $hasilList->firstWhere('jurusan_id', $tesTerakhir->minat_jurusan_1_id)
            : null;

        $skorPilihan2 = $tesTerakhir->minat_jurusan_2_id
            ? $hasilList->firstWhere('jurusan_id', $tesTerakhir->minat_jurusan_2_id)
            : null;

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

        $tes = Tes::where('siswa_id', $siswa->id)->latest()->first();
        if (!$tes) abort(404);

        // ambil record pdf
        $tesPdf = TesPdf::with('upload')->where('tes_id', $tes->id)->first();

        // ✅ Kalau belum ada PDF di DB, coba generate dulu
        if (!$tesPdf || !$tesPdf->upload) {
            $ok = $this->generateAndStorePdf($tes);

            if (!$ok) {
                return redirect()
                    ->route('siswa.tes.hasil')
                    ->withErrors('Gagal membuat PDF. Cek konfigurasi Chrome/Puppeteer pada laptop ini (lihat log).');
            }

            // refresh data pdf setelah generate
            $tesPdf = TesPdf::with('upload')->where('tes_id', $tes->id)->first();
        }

        if (!$tesPdf || !$tesPdf->upload) {
            return redirect()
                ->route('siswa.tes.hasil')
                ->withErrors('PDF belum tersedia. Silakan coba lagi.');
        }

        $filePath = storage_path('app/public/' . $tesPdf->upload->storage_path);

        if (!file_exists($filePath)) {
            return redirect()
                ->route('siswa.tes.hasil')
                ->withErrors('File PDF tidak ditemukan di server: ' . $tesPdf->upload->storage_path);
        }

        return response()->download($filePath, 'hasil_tes_' . $tes->id . '.pdf');
    }

    private function generateAndStorePdf($tes): bool
    {
        $hasilList = HasilSaw::where('tes_id', $tes->id)
            ->with('jurusan')
            ->orderBy('peringkat')
            ->get();

        $siswa = $tes->siswa()->with('user')->first();

        $html = view('pages.siswa.hasil-pdf', [
            'siswa'       => $siswa,
            'tesTerakhir' => $tes,
            'hasilList'   => $hasilList,
        ])->render();

        $fileName     = 'hasil_tes_' . $tes->id . '.pdf';
        $relativePath = 'hasil_pdf/' . $fileName;
        $absolutePath = storage_path('app/public/' . $relativePath);

        $dir = dirname($absolutePath);
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        // ✅ ambil dari CONFIG (anti masalah config cache)
        $chromePath = config('browsershot.chrome_path');

        try {
            $b = Browsershot::html($html)
                ->format('A4')
                ->margins(10, 10, 10, 10)
                ->showBackground()
                ->emulateMedia('screen')
                ->noSandbox();

            // ✅ paksa chrome lokal kalau ada
            if ($chromePath && file_exists($chromePath)) {
                $b->setChromePath($chromePath);
            } else {
                Log::warning('BROWSERSHOT_CHROME_PATH tidak valid / tidak ditemukan', [
                    'chromePath' => $chromePath,
                ]);
            }

            $b->save($absolutePath);

            if (!file_exists($absolutePath) || filesize($absolutePath) === 0) {
                Log::error('PDF tidak terbentuk / 0 byte', ['path' => $absolutePath]);
                return false;
            }

        } catch (\Throwable $e) {
            if (file_exists($absolutePath)) @unlink($absolutePath);

            Log::error('Browsershot gagal generate PDF', [
                'chromePath' => $chromePath,
                'message'    => $e->getMessage(),
            ]);

            return false;
        }

        $sizeBytes = filesize($absolutePath) ?: 0;
        $sizeMb = round($sizeBytes / 1024 / 1024, 2);

        $upload = Upload::create([
            'uploader_user_id' => $siswa->user_id,
            'file_name'        => $fileName,
            'ext'              => 'pdf',
            'mime_type'        => 'application/pdf',
            'size_mb'          => $sizeMb,
            'storage_path'     => $relativePath,
        ]);

        TesPdf::updateOrCreate(
            ['tes_id' => $tes->id],
            ['upload_id' => $upload->id, 'generated_at' => now()]
        );

        return true;
    }

    public function history()
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();

        if (!$siswa) {
            return view('pages.siswa.history', ['histories' => collect()]);
        }

        $histories = Tes::where('siswa_id', $siswa->id)
            ->with(['hasilSaw.jurusan', 'tesPDF.upload'])
            ->latest()
            ->paginate(10);

        return view('pages.siswa.history', compact('histories'));
    }

    public function hasilByTes(Tes $tes)
    {
        $user  = Auth::user();
        $siswa = Siswa::with('user')->where('user_id', $user->id)->first();
        if (!$siswa) abort(403);

        // pastikan tes milik siswa ini
        if ($tes->siswa_id !== $siswa->id) abort(403);

        $hasilList = HasilSaw::where('tes_id', $tes->id)
            ->with('jurusan')
            ->orderBy('peringkat')
            ->get();

        if ($hasilList->isEmpty()) {
            return redirect()->route('siswa.tes.index')->withErrors('Hasil tes ini belum tersedia.');
        }

        $jurusanPilihan1 = Jurusan::find($tes->minat_jurusan_1_id);
        $jurusanPilihan2 = Jurusan::find($tes->minat_jurusan_2_id);

        $skorPilihan1 = $tes->minat_jurusan_1_id
            ? $hasilList->firstWhere('jurusan_id', $tes->minat_jurusan_1_id)
            : null;

        $skorPilihan2 = $tes->minat_jurusan_2_id
            ? $hasilList->firstWhere('jurusan_id', $tes->minat_jurusan_2_id)
            : null;

        // pakai view hasil yang sama, tapi tes-nya bukan latest
        return view('pages.siswa.hasil', [
            'siswa' => $siswa,
            'tesTerakhir' => $tes,          // biar blade kamu tetap kompatibel
            'hasilList' => $hasilList,
            'jurusanPilihan1' => $jurusanPilihan1,
            'jurusanPilihan2' => $jurusanPilihan2,
            'skorPilihan1' => $skorPilihan1,
            'skorPilihan2' => $skorPilihan2,
        ]);
    }

    public function cetakPdfByTes(Tes $tes)
    {
        $user  = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        if (!$siswa) abort(403);

        // pastikan tes milik siswa ini
        if ($tes->siswa_id !== $siswa->id) abort(403);

        $tesPdf = TesPdf::with('upload')
            ->where('tes_id', $tes->id)
            ->first();

        if (!$tesPdf || !$tesPdf->upload) {
            return back()->withErrors('File PDF untuk tes ini belum tersedia.');
        }

        $filePath = storage_path('app/public/' . $tesPdf->upload->storage_path);

        if (!file_exists($filePath)) {
            return back()->withErrors('File PDF tidak ditemukan di server.');
        }

        // kasih nama download yang rapi
        $downloadName = 'hasil_tes_' . $tes->id . '.pdf';

        return response()->download($filePath, $downloadName);
    }
}
