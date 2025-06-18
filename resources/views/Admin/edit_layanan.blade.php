@extends('ATemplate.app')

@section('title', 'Edit Layanan')

@section('main-content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-edit me-2"></i>Edit Layanan
            </h6>
            <a href="{{ route('admin.layanan.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.layanan.update', $layanan->id_layanan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Nama Layanan -->
                        <div class="form-group mb-3">
                            <label for="nama_layanan" class="form-label">Nama Layanan</label>
                            <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" 
                                   id="nama_layanan" name="nama_layanan" 
                                   value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                            @error('nama_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Harga per Kg -->
                        <div class="form-group mb-3">
                            <label for="harga_per_kg" class="form-label">Harga per Kg</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" 
                                       id="harga_per_kg" name="harga_per_kg" 
                                       value="{{ old('harga_per_kg', $layanan->harga_per_kg) }}" required>
                                @error('harga_per_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Estimasi Durasi -->
                        <div class="form-group mb-3">
                            <label for="estimasi_durasi" class="form-label">Estimasi Durasi (hari)</label>
                            <input type="number" class="form-control @error('estimasi_durasi') is-invalid @enderror" 
                                   id="estimasi_durasi" name="estimasi_durasi" 
                                   value="{{ old('estimasi_durasi', $layanan->estimasi_durasi) }}" required>
                            @error('estimasi_durasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status Layanan -->
                        <div class="form-group mb-3">
                            <label for="status_layanan" class="form-label">Status Layanan</label>
                            <select class="form-select @error('status_layanan') is-invalid @enderror" 
                                    id="status_layanan" name="status_layanan" required>
                                <option value="aktif" {{ old('status_layanan', $layanan->status_layanan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="t_aktif" {{ old('status_layanan', $layanan->status_layanan) == 't_aktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Deskripsi -->
                <div class="form-group mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Layanan</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection