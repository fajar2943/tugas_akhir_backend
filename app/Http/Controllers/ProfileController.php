<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user();
        return view('auth.profile', compact('profile'));
    }
    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => [
                'required',
                'different:old_password',
                'confirmed',
                'min:8',
                'max:25',
                // 'regex:/[a-z]/',
                // 'regex:/[A-Z]/',
            ],
        ], [
            'new_password.different' => 'Isian kata sandi baru tidak boleh sama dengan kata sandi lama',
            'new_password.min'       => 'Isian kata sandi baru harus minimal 8 karakter.',
            'new_password.max'       => 'Isian kata sandi baru harus maksimal 25 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok',
            // 'new_password.regex'     => 'Format kata sandi harus mengandung setidaknya 1 huruf kapital',
        ]);
        if (\Hash::check($request->old_password, \Auth::user()->password) === false) {
            return back()->withErrors('Kata sandi lama salah');
        }

        User::find(\Auth::id())->update(['password' => $request->new_password]);
        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
