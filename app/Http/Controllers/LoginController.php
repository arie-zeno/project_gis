<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Alert::success('Berhasil', 'Selamat datang, ' . $user->name . '!');
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('mahasiswa.home');
        }

        Alert::error('Gagal', 'Email atau password salah.');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::info('Logout', 'Anda berhasil keluar.');
        return redirect('/');
    }
}
