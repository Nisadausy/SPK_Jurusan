<?php
namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\GuruBk;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $guruBk = GuruBk::with('jurusan')->where('user_id', $user->id)->firstOrFail();
        return view('pages.bk.profil', compact('user', 'guruBk'));
    }

    public function update(Request $request)
{
    $user = Auth::user();
    $request->validate([
        'nama'  => 'required|string|max:120',
        'email' => 'required|email|unique:users,email,'.$user->id,
    ]);
    $user->update([
        'nama'        => $request->nama,
        'email'       => $request->email,
        'no_telepon'  => $request->no_telepon,
    ]);
    return redirect()->route('bk.profil')->with('success', 'Profil berhasil diperbarui!');
}
}