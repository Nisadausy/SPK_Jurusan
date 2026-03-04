<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtikelJurusan;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelAdminController extends Controller
{
    public function index()
    {
        $artikels = ArtikelJurusan::with(['jurusan', 'gambarUpload', 'creator'])
                                  ->latest()->paginate(12);
        return view('pages.admin.artikel.index', compact('artikels'));
    }

    public function edit($id)
    {
        $artikel  = ArtikelJurusan::with(['jurusan', 'gambarUpload', 'fileUpload'])->findOrFail($id);
        $jurusans = \App\Models\Jurusan::orderBy('nama')->get();
        return view('pages.admin.artikel.edit', compact('artikel', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $artikel = ArtikelJurusan::findOrFail($id);
        $request->validate([
            'judul'      => 'required|string|max:200',
            'deskripsi'  => 'required|string',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);
        $artikel->update($request->only('judul', 'deskripsi', 'jurusan_id'));
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $artikel = ArtikelJurusan::findOrFail($id);
        foreach ([$artikel->gambar_upload_id, $artikel->file_upload_id] as $uploadId) {
            if ($uploadId) {
                $u = Upload::find($uploadId);
                if ($u) { Storage::disk('public')->delete($u->path); $u->delete(); }
            }
        }
        $artikel->delete();
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}