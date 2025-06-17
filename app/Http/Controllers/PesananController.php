<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Customer; 
use App\Models\Layanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
{
    // Query dasar dengan sorting DESC berdasarkan created_at (terbaru ke terlama)
    $query = Pesanan::with(['customer' => function($q) {
                $q->select('id_customer', 'nama_panjang');
            }])
            ->orderBy('created_at', 'DESC'); // Ini yang utama
            
    // Filter tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $request->validate([
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date'
        ]);
        
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }
    
    // Filter metode pembayaran
    if ($request->filled('payment_method')) {
        $query->where('metode_pembayaran', $request->payment_method);
    }
    
    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('id_pesanan', 'like', '%'.$search.'%')
              ->orWhereHas('customer', function($q) use ($search) {
                  $q->where('nama_panjang', 'like', '%'.$search.'%')
                    ->orWhere('id_customer', 'like', '%'.$search.'%');
              });
        });
    }
    
    $orders = $query->paginate(10);
    
    return view('Admin.cek_orderan', compact('orders'));
}
    public function show($id_pesanan)
    {
        $order = Pesanan::with(['customer', 'layanan'])
                    ->findOrFail($id_pesanan);
                    
        return view('Admin.detail_pesanan', compact('order'));
    }
    public function updateStatus(Request $request, $id_pesanan)
{
    $order = Pesanan::where('id_pesanan', $id_pesanan)->firstOrFail();
    
    $request->validate([
        'status' => 'required|in:pending,proses,selesai,diambil'
    ]);

    // Perbaikan syntax update
    $order->update([
        'status' => $request->status,
        'updated_at' => now() // Jika ingin mempertahankan timestamp
    ]);
    
    return back()->with('success', 'Status pesanan berhasil diperbarui');
}

    public function edit($id_pesanan)
    {
        $order = Pesanan::with(['customer', 'layanan'])
                ->where('id_pesanan', $id_pesanan)
                ->firstOrFail();
        
        return view('Admin.edit_pesanan', compact('order'));
    }

    public function update(Request $request, $id_pesanan)
    {
        $order = Pesanan::where('id_pesanan', $id_pesanan)->firstOrFail();
        
        $validated = $request->validate([
            // Sesuaikan validasi dengan field yang ada
            'id_layanan' => 'required',
            'jumlah' => 'required|numeric',
            // tambahkan field lainnya
        ]);
        
        $order->update($validated);
        
        return redirect()->route('orders.index')
                        ->with('success', 'Pesanan berhasil diperbarui');
    }
    // Untuk pembatalan pesanan
public function cancel($id_pesanan)
{
    $order = Pesanan::where('id_pesanan', $id_pesanan)->firstOrFail();
    
    // Validasi status
    if (in_array($order->status, ['selesai', 'diambil'])) {
        return back()->with('error', 'Pesanan tidak bisa dibatalkan karena sudah selesai');
    }

    $order->update(['status' => 'batal']);
    
    return back()->with('success', 'Pesanan berhasil dibatalkan');
    }

    // Untuk konfirmasi pembayaran
public function uploadPayment(Request $request, $id_pesanan)
{
    $request->validate([
        'metode_pembayaran' => 'required|in:cash,qris',
        'bukti_bayar' => 'required_if:metode_pembayaran,qris|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    try {
        $order = Pesanan::where('id_pesanan', $id_pesanan)->firstOrFail();
        
        $data = [
            'metode_pembayaran' => $request->metode_pembayaran
        ];

        if ($request->metode_pembayaran == 'qris') {
            $file = $request->file('bukti_bayar');
            $filename = 'qris_'.time().'_'.$order->id_pesanan.'.'.$file->extension();
            $path = $file->storeAs('bukti_bayar', $filename, 'public');
            $data['bukti_bayar'] = $filename;
        } else {
            $data['bukti_bayar'] = '-';
        }

        $order->update($data);
        
        return back()->with('success', 'Pembayaran berhasil dikonfirmasi');

    } catch (\Exception $e) {
        return back()->with('error', 'Gagal mengupload: '.$e->getMessage());
    }
}
public function create(Customer $customer)
{
    $layanans = Layanan::where('status_layanan', 'aktif')->get();
    return view('Admin.tambah_pesanan', compact('customer', 'layanans'));
}
public function store(Request $request)
{
    $validated = $request->validate([
        'id_customer' => 'required|exists:tbl_customer,id_customer',
        'id_layanan' => 'required|exists:tbl_layanan,id_layanan',
        'berat' => 'required|numeric|min:0.1',
        'tgl_pengambilan' => 'required|date|after_or_equal:today',
        'metode_pembayaran' => 'required|in:cash,transfer,qris',
        'catatan' => 'nullable|string',
    ]);

    $layanan = Layanan::findOrFail($request->id_layanan);

    Pesanan::create([
        'id_customer' => $validated['id_customer'],
        'id_layanan' => $validated['id_layanan'],
        'jumlah' => $validated['berat'],
        'price' => $layanan->harga_per_kg * $validated['berat'],
        'tglPengambilan' => $validated['tgl_pengambilan'],
        'metode_pembayaran' => $validated['metode_pembayaran'],
        'catatan' => $validated['catatan'],
        'status' => 'pending',
    ]);

    return redirect()->route('customers.show', $validated['id_customer'])
                     ->with('success', 'Pesanan baru berhasil dibuat');
}
}