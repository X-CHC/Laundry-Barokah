<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function dashboard()
{
    // Cek session login
    if (!Session::get('customer_logged_in')) {
        return redirect('/customer/login');
    }

    // Ambil data customer dari session
    $customer = Customer::find(Session::get('customer_id'));
    
    // Ambil pesanan customer dengan eager loading layanan
    $orders = Pesanan::with('layanan')
                  ->where('id_customer', Session::get('customer_id'))
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);
    
    return view('customer.dashboard', compact('customer', 'orders'));
}

    public function editProfile()
    {
        if (!Session::get('customer_logged_in')) {
            return redirect('/customer/login');
        }

        $customer = Customer::find(Session::get('customer_id'));
        return view('customer.edit-profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        if (!Session::get('customer_logged_in')) {
            return redirect('/customer/login');
        }

        $customer = Customer::find(Session::get('customer_id'));
        
        $validated = $request->validate([
            'nama_panjang' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:customer,username,'.$customer->id_customer.',id_customer',
            'email' => 'nullable|email|max:255|unique:customer,email,'.$customer->id_customer.',id_customer',
            'tlp' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);
        
        $customer->update($validated);
        
        // Update session jika username berubah
        if ($customer->username !== Session::get('customer_username')) {
            Session::put('customer_username', $customer->username);
        }
        
        return redirect()->route('customer.dashboard')->with('success', 'Profil berhasil diperbarui');
    }
    
}