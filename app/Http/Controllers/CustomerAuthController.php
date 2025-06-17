<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.login'); // Sesuaikan dengan view Anda
    }

    public function login(Request $request)
{
    $request->validate([
        'login' => 'required', // bisa username atau email
        'password' => 'required',
    ]);

    $customer = Customer::where('username', $request->login)
                ->orWhere('email', $request->login)
                ->first();

    if (!$customer) {
        return back()->withErrors(['login' => 'Username/email tidak ditemukan'])->withInput();
    }

    if (!Hash::check($request->password, $customer->password)) {
        return back()->withErrors(['password' => 'Password salah'])->withInput();
    }

    // Login manual dengan session
    $request->session()->regenerate();
    session([
        'customer_logged_in' => true,
        'customer_id' => $customer->id_customer,
        'customer_username' => $customer->username
    ]);

    return redirect()->intended('/customer/dashboard');
}

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

   // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('Customer.register_customer');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_panjang' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tbl_customer,username',
            'email' => 'nullable|email|max:100|unique:tbl_customer,email',
            'tlp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat customer baru (ID otomatis dari model)
        Customer::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'nama_panjang' => $request->nama_panjang,
            'tlp' => $request->tlp,
            'alamat' => $request->alamat,
        ]);

        // Redirect ke halaman sukses
        return redirect()->route('registration.success');
    }

    // Halaman sukses registrasi
    public function registrationSuccess()
    {
        return view('Customer.berhasil_register');
    }
    
}