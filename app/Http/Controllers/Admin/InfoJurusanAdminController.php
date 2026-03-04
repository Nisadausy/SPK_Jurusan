<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiJurusan;
use App\Models\ProspekKerja;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class InfoJurusanAdminController extends Controller
{
    public function index()
    {
       $jurusans = Jurusan::withCount(['artikelJurusan', 'prospekKerja'])->orderBy('nama_jurusan')->get();
        return view('pages.admin.infojurusan.index', compact('jurusans'));
    }

    public function edit($jurusanId)
    {
        $jurusan       = Jurusan::findOrFail($jurusanId);
        $info          = InformasiJurusan::firstOrNew(['jurusan_id' => $jurusanId]);
        $prospekUmum   = ProspekKerja::where('jurusan_id', $jurusanId)->where('tipe', 'umum')->get();
        $prospekAlumni = ProspekKerja::where('jurusan_id', $jurusanId)->where('tipe', 'alumni')->get();
        return view('pages.admin.infojurusan.edit', compact('jurusan', 'info', 'prospekUmum', 'prospekAlumni'));
    }

    public function update(Request $request, $jurusanId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);

        InformasiJurusan::updateOrCreate(
            ['jurusan_id' => $jurusanId],
            ['fasilitas' => $request->fasilitas, 'updated_by_user_id' => auth()->id()]
        );

        ProspekKerja::where('jurusan_id', $jurusanId)->where('tipe', 'umum')->delete();
        foreach (array_filter($request->prospek_umum ?? []) as $isi)
            ProspekKerja::create(['jurusan_id' => $jurusanId, 'tipe' => 'umum', 'isi' => $isi]);

        ProspekKerja::where('jurusan_id', $jurusanId)->where('tipe', 'alumni')->delete();
        foreach (array_filter($request->prospek_alumni ?? []) as $isi)
            ProspekKerja::create(['jurusan_id' => $jurusanId, 'tipe' => 'alumni', 'isi' => $isi]);

        return redirect()->route('admin.infojurusan.index')
                         ->with('success', "Info jurusan {$jurusan->nama} berhasil diperbarui!");
    }

    public function destroy($jurusanId)
    {
        InformasiJurusan::where('jurusan_id', $jurusanId)->delete();
        ProspekKerja::where('jurusan_id', $jurusanId)->delete();
        return redirect()->route('admin.infojurusan.index')->with('success', 'Info jurusan berhasil dihapus.');
    }
}
