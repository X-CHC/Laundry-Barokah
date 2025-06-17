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
    DB::beginTransaction();
    
    try {
        // Validasi customer
        $customerData = $request->validate([
            'nama' => 'required|string|max:100',
            'noHp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100|unique:tbl_customer,email',
            'alamat' => 'nullable|string',
            'username' => 'required|string|max:50|unique:tbl_customer,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Validasi pesanan
        $orderData = $request->validate([
            'layanan' => 'required|exists:tbl_layanan,id_layanan',
            'berat' => 'required|numeric|min:0.1',
            'tglPengambilan' => 'required|date|after_or_equal:today',
            'payment' => 'required|in:cash,qris',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // JANGAN set id_customer disini, biarkan model yang handle
        $customer = Customer::create([
            'username' => $customerData['username'],
            'password' => Hash::make($customerData['password']),
            'email' => $customerData['email'] ?? null,
            'nama_panjang' => $customerData['nama'],
            'tlp' => $customerData['noHp'],
            'alamat' => $customerData['alamat'] ?? null,
            'status_akun' => 'aktif',
            // id_customer tidak perlu diset manual
        ]);

        // Buat pesanan
        $layanan = Layanan::findOrFail($orderData['layanan']);
        
        $pesananData = [
            'id_customer' => $customer->id_customer, // Gunakan id yang sudah digenerate
            'id_layanan' => $orderData['layanan'],
            'jumlah' => $orderData['berat'],
            'price' => $layanan->harga_per_kg * $orderData['berat'],
            'tglPengambilan' => $orderData['tglPengambilan'],
            'metode_pembayaran' => $orderData['payment'],
            'catatan' => $orderData['catatan'] ?? null,
            'status' => 'pending',
            'bukti_bayar' => null, // Default null
        ];

        // Handle bukti bayar jika ada
        if ($request->hasFile('bukti_bayar')) {
            $filename = 'payment_'.time().'.'.$request->file('bukti_bayar')->extension();
            $path = $request->file('bukti_bayar')->storeAs('bukti_bayar', $filename, 'public');
            $pesananData['bukti_bayar'] = $filename;
        }

        Pesanan::create($pesananData);

        DB::commit();

        return redirect()->back()
            ->with('success', 'Registrasi dan pemesanan berhasil!')
            ->withInput($request->except('password', 'password_confirmation'));

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: '.$e->getMessage())
            ->withInput($request->all());
    }
}
    
    
}