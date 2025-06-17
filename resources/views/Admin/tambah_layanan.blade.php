@extends('ATemplate.app')

@section('title', 'Tambah Layanan')

@section('main-content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-plus-circle me-2"></i>Tambah Layanan Baru
            </h6>
            <a href="{{ route('admin.layanan.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.layanan.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Nama Layanan -->
                        <div class="form-group mb-3">
                            <label for="nama_layanan" class="form-label">Nama Layanan</label>
                            <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" 
                                   id="nama_layanan" name="nama_layanan" 
                                   value="{{ old('nama_layanan') }}" required>
                            @error('nama_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Harga per Kg -->
                        <div class="form-group mb-3">
                            <label for="harga_per_kg" class="form-label">Harga per Kg</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" 
                                       id="harga_per_kg" name="harga_per_kg" 
                                       value="{{ old('harga_per_kg') }}" required min="0">
                                @error('harga_per_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Estimasi Durasi -->
                        <div class="form-group mb-3">
                            <label for="estimasi_durasi" class="form-label">Estimasi Durasi (hari)</label>
                            <input type="number" class="form-control @error('estimasi_durasi') is-invalid @enderror" 
                                   id="estimasi_durasi" name="estimasi_durasi" 
                                   value="{{ old('estimasi_durasi') }}" required min="1">
                            @error('estimasi_durasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Status (hidden karena default aktif) -->
                        <input type="hidden" name="status_layanan" value="aktif">
                    </div>
                </div>
                
                <!-- Deskripsi -->
                <div class="form-group mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Layanan</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection