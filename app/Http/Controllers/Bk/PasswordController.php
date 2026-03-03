<?php
namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class PasswordController extends Controller
{
    public function index()
    {
        return view('pages.bk.password');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', function ($attr, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password_hash)) {
                    $fail('Password lama tidak sesuai.');
                }
            }],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password_hash'        => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('bk.dashboard')->with('success', 'Password berhasil diubah!');
    }
}