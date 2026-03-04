<?php
namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\{ArtikelJurusan, Jurusan, Upload};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Storage};

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = ArtikelJurusan::with(['jurusan', 'gambarUpload', 'fileUpload'])
            ->where('created_by_user_id', Auth::id())->latest()->paginate(12);
        return view('pages.bk.artikel.index', compact('artikels'));
    }

    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('pages.bk.artikel.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'judul'      => 'required|string|max:200',
            'deskripsi'  => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg|max:8192',
            'file'       => 'nullable|mimes:pdf,mp4|max:51200',
        ]);

        ArtikelJurusan::create([
            'jurusan_id'         => $request->jurusan_id,
            'judul'              => $request->judul,
            'deskripsi'          => $request->deskripsi,
            'gambar_upload_id'   => $this->simpanUpload($request, 'gambar', 'artikel/gambar'),
            'file_upload_id'     => $this->simpanUpload($request, 'file', 'artikel/file'),
            'created_by_user_id' => Auth::id(),
        ]);

        return redirect()->route('bk.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $artikel  = ArtikelJurusan::with(['jurusan', 'gambarUpload', 'fileUpload'])->findOrFail($id);
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('pages.bk.artikel.edit', compact('artikel', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $artikel = ArtikelJurusan::findOrFail($id);
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'judul'      => 'required|string|max:200',
            'deskripsi'  => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg|max:8192',
            'file'       => 'nullable|mimes:pdf,mp4|max:51200',
        ]);

        $data = ['jurusan_id' => $request->jurusan_id, 'judul' => $request->judul, 'deskripsi' => $request->deskripsi];

        if ($request->hasFile('gambar')) {
            $this->hapusUpload($artikel->gambar_upload_id);
            $data['gambar_upload_id'] = $this->simpanUpload($request, 'gambar', 'artikel/gambar');
        }
        if ($request->hasFile('file')) {
            $this->hapusUpload($artikel->file_upload_id);
            $data['file_upload_id'] = $this->simpanUpload($request, 'file', 'artikel/file');
        }

        $artikel->update($data);
        return redirect()->route('bk.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $artikel = ArtikelJurusan::findOrFail($id);
        $this->hapusUpload($artikel->gambar_upload_id);
        $this->hapusUpload($artikel->file_upload_id);
        $artikel->delete();
        return redirect()->route('bk.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function simpanUpload(Request $request, string $input, string $folder): ?int
{
    if (!$request->hasFile($input)) return null;

    $file = $request->file($input);

    // Tentukan ext berdasarkan mime
    $mime = $file->getMimeType();
    if (str_contains($mime, 'pdf'))       $ext = 'PDF';
    elseif (str_contains($mime, 'mp4'))   $ext = 'MP4';
    elseif (str_contains($mime, 'jpeg'))  $ext = 'JPG';
    else                                  $ext = 'JPG';

    $upload = Upload::create([
        'uploader_user_id' => auth()->id(),
        'file_name'        => $file->getClientOriginalName(),
        'ext'              => $ext,
        'mime_type'        => $mime,
        'size_mb'          => round($file->getSize() / 1048576, 2),
        'storage_path'     => $file->store($folder, 'public'),
    ]);

    return $upload->id;
}

    private function hapusUpload(?int $uploadId): void
    {
        if (!$uploadId) return;
        $u = Upload::find($uploadId);
        if ($u) { Storage::disk('public')->delete($u->path); $u->delete(); }
    }
}