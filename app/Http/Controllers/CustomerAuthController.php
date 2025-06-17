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
        return redirect('/customer/login');
    }
}