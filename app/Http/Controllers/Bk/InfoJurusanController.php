<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\{InformasiJurusan, ProspekKerja, Jurusan};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfoJurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::with(['informasiJurusan', 'prospekKerja'])
            ->orderBy('nama_jurusan')
            ->get();

        return view('pages.bk.infojurusan.index', compact('jurusans'));
    }

   public function edit($id)
{
    $jurusan = Jurusan::with(['informasiJurusan', 'prospekKerja'])
        ->findOrFail($id);

    $info = $jurusan->informasiJurusan;

    $prospekUmum = $jurusan->prospekKerja
        ->where('tipe', 'umum')
        ->pluck('isi');

    $prospekAlumni = $jurusan->prospekKerja
        ->where('tipe', 'alumni')
        ->pluck('isi');

    return view('pages.bk.infojurusan.edit', compact(
        'jurusan',
        'info',
        'prospekUmum',
        'prospekAlumni'
    ));
}

    public function update(Request $request, $jurusanId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);

        InformasiJurusan::updateOrCreate(
            ['jurusan_id' => $jurusanId],
            [
                'fasilitas' => $request->fasilitas,
                'updated_by_user_id' => Auth::id()
            ]
        );

        ProspekKerja::where('jurusan_id', $jurusanId)
            ->where('tipe', 'umum')
            ->delete();

        foreach (array_filter($request->prospek_umum ?? []) as $isi) {
            ProspekKerja::create([
                'jurusan_id' => $jurusanId,
                'tipe' => 'umum',
                'isi' => $isi
            ]);
        }

        ProspekKerja::where('jurusan_id', $jurusanId)
            ->where('tipe', 'alumni')
            ->delete();

        foreach (array_filter($request->prospek_alumni ?? []) as $isi) {
            ProspekKerja::create([
                'jurusan_id' => $jurusanId,
                'tipe' => 'alumni',
                'isi' => $isi
            ]);
        }

        return redirect()->route('bk.infojurusan.index')
            ->with('success', "Informasi jurusan {$jurusan->nama_jurusan} berhasil diperbarui!");
    }
}