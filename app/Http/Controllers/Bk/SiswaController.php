<?php
namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\{Siswa, Tes};

class SiswaController extends Controller
{
    public function index()
    {
        $query = Siswa::with([
            'user',
            'tes' => fn($q) => $q->latest()->with('rekomendasiTeratas.jurusan', 'minatJurusan1', 'minatJurusan2'),
        ]);

        if (request('search')) {
            $query->whereHas('user', fn($q) => $q->where('nama', 'like', '%'.request('search').'%'));
        }

        $siswas = $query->paginate(15);
        return view('pages.bk.siswa.index', compact('siswas'));
    }

    public function show($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $riwayatTes = Tes::where('siswa_id', $id)
            ->with([
                'rekomendasiTeratas.jurusan',
                'minatJurusan1', 'minatJurusan2',
                'hasilSaw' => fn($q) => $q->orderBy('peringkat')->with('jurusan'),
            ])->latest()->get();

        return view('pages.bk.siswa.show', compact('siswa', 'riwayatTes'));
    }
}