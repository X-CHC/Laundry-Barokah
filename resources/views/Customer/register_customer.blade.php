<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - LaundryKu</title>
    <link href="{{ asset('boostrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fontsawesome/css/all.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .register-card {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .register-left {
            flex: 1;
            padding: 40px;
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .register-right {
            flex: 1;
            padding: 40px;
        }
        .brand-logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }
        .feature-list {
            margin-top: 2rem;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .feature-icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Bagian kiri dengan promo -->
            <div class="register-left">
                <div class="brand-logo">
                    <i class="fas fa-cloud-sun"></i> Laundry Barokah
                </div>
                <h2 class="mb-3">Laundry Kita <br>Tanpa Ribet!</h2>
                <p class="lead">Cuci, Setrika, dan Antar Jemput</p>
                
                <!-- Daftar fitur -->
                <div class="feature-list">
                    <div class="feature-item">
                        <span class="feature-icon"><i class="fas fa-check-circle"></i></span>
                        <span>Proses Cepat dan Higienis</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon"><i class="fas fa-check-circle"></i></span>
                        <span>Layanan Antar Jemput</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon"><i class="fas fa-check-circle"></i></span>
                        <span>Harga Terjangkau</span>
                    </div>
                </div>
            </div>
            
            <!-- Bagian kanan dengan form -->
            <div class="register-right">
                <h4 class="form-title">Daftar Akun Baru</h4>
                <p class="form-subtitle">Isi form berikut untuk membuat akun pelanggan</p>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('customer.register.submit') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_panjang" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_panjang" name="nama_panjang" 
                               value="{{ old('nama_panjang') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="{{ old('username') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" 
                               name="password_confirmation" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tlp" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="tlp" name="tlp" 
                               value="{{ old('tlp') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2">DAFTAR SEKARANG</button>
                    
                    <div class="text-center mt-3">
                        <p>Sudah punya akun? <a href="{{ route('customer.login') }}">Masuk di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('boostrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>