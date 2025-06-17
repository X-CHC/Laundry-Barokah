<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Layanan;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Pesanan::where('id_customer', $customer->id_customer)
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
        
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Menampilkan form pembuatan pesanan baru
     */
    public function create()
{
    $customer = Customer::find(Session::get('customer_id'));
    $services = Layanan::where('status_layanan', 'aktif')->get();
    return view('Customer.buat_pesanan', compact('services', 'customer'));
}

public function store(Request $request)
{
    // Validasi
    $validated = $request->validate([
        'id_layanan' => 'required|exists:tbl_layanan,id_layanan',
        'jumlah' => 'required|numeric|min:0.1|max:100',
        'metode_pembayaran' => 'required|in:cash,qris',
        'bukti_bayar' => 'required_if:metode_pembayaran,qris|image|mimes:jpeg,png,jpg|max:2048',
        'catatan' => 'nullable|string|max:500'
    ]);

    // Dapatkan ID customer dari auth
    $customerId = auth()->guard('customer')->id();
    
    // Hitung total harga
    $layanan = Layanan::findOrFail($validated['id_layanan']);
    $totalHarga = $layanan->harga * $validated['jumlah'];

    // Buat pesanan
    $pesanan = Pesanan::create([
        'id_pesanan' => 'P' . Str::upper(Str::random(5)),
        'id_customer' => $customerId,
        'id_layanan' => $validated['id_layanan'],
        'jumlah' => $validated['jumlah'],
        'price' => $totalHarga,
        'metode_pembayaran' => $validated['metode_pembayaran'],
        'bukti_bayar' => $validated['metode_pembayaran'] == 'qris' 
            ? $request->file('bukti_bayar')->store('bukti_bayar', 'public')
            : null,
        'catatan' => $validated['catatan'],
        'status' => 'pending',
        'tglPengambilan' => now()->addDays(3)
    ]);

    return redirect()->route('customer.dashboard')
                   ->with('success', 'Pesanan #'.$pesanan->id_pesanan.' berhasil dibuat');
}

    /**
     * Menampilkan detail pesanan
     */
    public function show($id_pesanan)
{
    $customer = Auth::guard('customer')->user();
    $order = Pesanan::where('id_pesanan', $id_pesanan)
                 ->where('id_customer', $customer->id_customer)
                 ->firstOrFail();
    
    return view('customer.orders.show', [
        'order' => $order,
        'customer' => $customer // Pastikan kirim customer ke view
    ]);
}
}