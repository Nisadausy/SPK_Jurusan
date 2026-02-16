<?php

namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\JawabanMinat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SpkController extends Controller
{
    private array $kriteria = [
        ['id' => 'ipa', 'nama' => 'Nilai IPA'],
        ['id' => 'ips', 'nama' => 'Nilai IPS'],
        ['id' => 'b_indonesia', 'nama' => 'Nilai Bahasa Indonesia'],
        ['id' => 'pkn', 'nama' => 'Nilai PKN'],
        ['id' => 'b_inggris', 'nama' => 'Nilai Bahasa Inggris'],
        ['id' => 'biologi', 'nama' => 'Nilai Biologi'],
        ['id' => 'fisika', 'nama' => 'Nilai Fisika'],
    ];

        public function index()
        {
            $siswa = Auth::guard('siswa')->user();

            // 🔒 PENGAMAN (INI YANG KURANG)
            if (!$siswa) {
                return redirect()->route('login')
                    ->withErrors('Silakan login sebagai siswa');
            }

            $riwayat = HasilSaw::whereHas('tes', function ($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->id);
                })
                ->orderByDesc('created_at')
                ->first();

            return view('siswa.tes', compact('siswa', 'riwayat'));
        }




    public function store(Request $request)
    {
        $siswa = Auth::user(); // ✅ WAJIB ADA

        $request->validate([
            'jawaban' => 'required|array|min:10',
            'jawaban.*' => 'required|integer|min:1|max:5',
            'nilai' => 'required|array',
            'bobot' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $siswa) {

            JawabanMinat::where('siswa_id', $siswa->id)->delete();

            foreach ($request->jawaban as $kode => $nilai) {
                JawabanMinat::create([
                    'siswa_id' => $siswa->id,
                    'kode_pernyataan' => $kode,
                    'nilai' => $nilai,
                ]);
            }

            HasilSaw::where('siswa_id', $siswa->id)->delete();

            HasilSaw::create([
                'siswa_id' => $siswa->id,
                'ranking' => 1,
                'alternatif_id' => 'teknik',
                'alternatif_nama' => 'Teknik',
                'skor' => 1,
            ]);
        });

        return redirect()->route('siswa.tes.hasil');
    }

    public function hasil()
    {
        $siswa = Auth::guard('siswa')->user();

        $hasilList = HasilSaw::where('siswa_id', $siswa->id)
            ->orderBy('ranking')
            ->get();

        if ($hasilList->isEmpty()) {
            return redirect()->route('siswa.tes.index');
        }

        return view('siswa.hasil', compact('siswa', 'hasilList'));
    }
}
