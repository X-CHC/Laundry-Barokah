<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

use App\Models\Admin; // Gunakan Model

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Admin.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required', // Sesuaikan dengan name di form
        'password' => 'required',
    ]);

    $admin = \DB::table('tbl_admin')
              ->where('username_admin', $credentials['username'])
              ->first();

    if (!$admin) {
        return back()->withErrors(['username' => 'Username tidak ditemukan'])->withInput();
    }

    if (!\Hash::check($credentials['password'], $admin->password_admin)) {
        return back()->withErrors(['password' => 'Password salah'])->withInput();
    }

    // Buat session lebih aman
    $request->session()->regenerate();
    session([
        'admin_logged_in' => true,
        'admin_id' => $admin->id_admin,
        'admin_username' => $admin->username_admin
    ]);

    return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
}

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin');
    }
}