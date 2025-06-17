<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $search = request('search');
        
        $query = Layanan::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_layanan', 'like', "%{$search}%")
                  ->orWhere('id_layanan', 'like', "%{$search}%");
            });
        }
        
        $layanans = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('Admin.daftar_layanan', compact('layanans'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('Admin.layanan.create');
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_layanan' => 'required|string|max:6|unique:layanans',
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_durasi' => 'required|integer|min:1',
            'status_layanan' => 'required|in:aktif,t_aktif',
        ]);

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    /**
     * Display the specified service.
     */
    public function show($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('Admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('Admin.edit_layanan', compact('layanan'));
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_durasi' => 'required|integer|min:1',
            'status_layanan' => 'required|in:aktif,t_aktif',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui');
    }

    /**
     * Remove the specified service.
     */
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus');
    }
}