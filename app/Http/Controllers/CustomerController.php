<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Layanan;
use App\Models\Pesanan;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $search = request('search');
        
        $query = Customer::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_panjang', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('tlp', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->orderBy('created_at', 'asc')->paginate(10);
                          
        return view('Admin.cek_anggota', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('Admin.create_customer');
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:tbl_customer,username|max:50',
            'password' => 'required|min:8|max:255|confirmed',
            'email' => 'required|email|unique:tbl_customer,email|max:100',
            'nama_panjang' => 'required|max:100',
            'tlp' => 'required|max:20',
            'alamat' => 'nullable',
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        Customer::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'email' => $validated['email'],
            'nama_panjang' => $validated['nama_panjang'],
            'tlp' => $validated['tlp'],
            'alamat' => $validated['alamat'],
            'status_akun' => $validated['status_akun'],
        ]);

        return redirect()->route('customers.index')
                         ->with('success', 'Anggota baru berhasil ditambahkan');
    }

    /**
     * Display the specified customer.
     */
    public function show($id_customer)
    {
        $customer = Customer::with('orders.layanan')->findOrFail($id_customer);
        return view('Admin.detail_anggota', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit($id_customer)
    {
        $customer = Customer::findOrFail($id_customer);
        return view('Admin.edit_anggota', compact('customer'));
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, $id_customer)
    {
        $customer = Customer::findOrFail($id_customer);

        $validated = $request->validate([
            'username' => 'required|max:50|unique:tbl_customer,username,'.$id_customer.',id_customer',
            'email' => 'required|email|max:100|unique:tbl_customer,email,'.$id_customer.',id_customer',
            'nama_panjang' => 'required|max:100',
            'tlp' => 'required|max:20',
            'alamat' => 'nullable',
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.show', $id_customer)
                         ->with('success', 'Data anggota berhasil diperbarui');
    }

    /**
     * Remove the specified customer.
     */
    public function destroy($id_customer)
    {
        $customer = Customer::findOrFail($id_customer);
        $customer->delete();

        return redirect()->route('customers.index')
                         ->with('success', 'Anggota berhasil dihapus');
    }

    /**
     * Reset customer password.
     */
    public function resetPassword(Request $request, $id_customer)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        $customer = Customer::findOrFail($id_customer);
        $customer->password = Hash::make($request->new_password);
        $customer->save();

        return back()->with('success', 'Password berhasil direset');
    }

    /**
     * Show registration form for new customer with order.
     */
    public function tampilFormPendaftaran()
    {
        $services = Layanan::where('status_layanan', 'aktif')->get();
        return view('Admin.pendaftaran', compact('services'));
    }

    /**
     * Register new customer with order.
     */
    public function register(Request $request)
    {
        // Validasi data customer
        $validatedCustomer = $request->validate([
            'nama' => 'required|string|max:100',
            'noHp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100|unique:tbl_customer,email',
            'alamat' => 'nullable|string',
            'username' => 'required|string|max:50|unique:tbl_customer,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Validasi data order
        $validatedOrder = $request->validate([
            'layanan' => 'required|exists:tbl_layanan,id_layanan',
            'berat' => 'required|numeric|min:0.1',
            'tglPengambilan' => 'required|date|after_or_equal:today',
            'payment' => 'required|in:cash,qris',
            'catatan' => 'nullable|string',
        ]);

        // Buat Customer
        $customer = Customer::create([
            'username' => $validatedCustomer['username'],
            'password' => Hash::make($validatedCustomer['password']),
            'email' => $validatedCustomer['email'] ?? null,
            'nama_panjang' => $validatedCustomer['nama'],
            'tlp' => $validatedCustomer['noHp'],
            'alamat' => $validatedCustomer['alamat'] ?? null,
            'status_akun' => 'aktif',
        ]);

        // Buat Pesanan
        $layanan = Layanan::findOrFail($validatedOrder['layanan']);
        
        Pesanan::create([
            'id_customer' => $customer->id_customer,
            'id_layanan' => $validatedOrder['layanan'],
            'jumlah' => $validatedOrder['berat'],
            'price' => $layanan->harga_per_kg * $validatedOrder['berat'],
            'tglPengambilan' => $validatedOrder['tglPengambilan'],
            'metode_pembayaran' => $validatedOrder['payment'],
            'catatan' => $validatedOrder['catatan'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Registrasi dan pemesanan berhasil!')
            ->withInput($request->except('password', 'password_confirmation'));
    }
    
    
}