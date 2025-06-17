@extends('ATemplate.app')

@section('title', 'Edit Data Pelanggan')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit mr-2"></i>Edit Data Pelanggan
        </h1>
        <a href="{{ route('customers.show', $customer->id_customer) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail
        </a>
    </div>

    <!-- Edit Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">
                Form Edit Pelanggan #{{ $customer->id_customer }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('customers.update', $customer->id_customer) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Data Utama -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" 
                                   value="{{ old('username', $customer->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="nama_panjang">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_panjang') is-invalid @enderror" 
                                   id="nama_panjang" name="nama_panjang" 
                                   value="{{ old('nama_panjang', $customer->nama_panjang) }}" required>
                            @error('nama_panjang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $customer->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Data Kontak -->
                        <div class="form-group">
                            <label for="tlp">No. Telepon</label>
                            <input type="text" class="form-control @error('tlp') is-invalid @enderror" 
                                   id="tlp" name="tlp" 
                                   value="{{ old('tlp', $customer->tlp) }}" required>
                            @error('tlp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3">{{ old('alamat', $customer->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_akun">Status Akun</label>
                            <select class="form-control @error('status_akun') is-invalid @enderror" 
                                    id="status_akun" name="status_akun" required>
                                <option value="aktif" {{ old('status_akun', $customer->status_akun) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status_akun', $customer->status_akun) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status_akun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('customers.show', $customer->id_customer) }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </div>
            </form>
            
            <!-- Form Reset Password -->
            <hr>
            <h5 class="mb-3"><i class="fas fa-key mr-2"></i>Reset Password</h5>
            <form  action="{{ route('customers.reset-password', $customer->id_customer) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" name="new_password" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" 
                                   id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-sync-alt mr-2"></i>Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection