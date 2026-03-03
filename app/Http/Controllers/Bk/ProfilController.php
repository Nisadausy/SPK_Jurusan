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
}