<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan - LaundryKu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('boostrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('fontsawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login_customer.css') }}" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-left" style="justify-content: flex-start; padding-top: 3rem;">
                <div class="brand-logo">
                    <i class="fas fa-cloud-sun"></i> Laundry Barokah
                </div>
                <h2 class="mb-3 mt-4">Laundry Kita <br>Tanpa Ribet!</h2>
                <p class="lead">Cuci, Setrika, dan Antar Jemput</p>
                
                <div class="feature-list mt-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <h5>Hemat Tenaga</h5>
                            <p class="mb-0">Proses dengan teknologi modern</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <h5>Kualitas Premium</h5>
                            <p class="mb-0">Deterjen hypoallergenic & pewangi pilihan</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h5>Gratis Antar-Jemput</h5>
                            <p class="mb-0">Area dalam radius 5 km</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="login-right">
                <!-- Login Form Area -->
                <div class="login-section">
                    <h4 class="mb-3">Sudah Punya Akun?</h4>
                    <p class="text-muted mb-3">Masuk untuk melihat riwayat order dan status laundry</p>
                    
                    <form method="POST" action="{{ route('customer.login.submit') }}">
                        @csrf
                        
                        <div class="mb-3">
    <div class="input-group">
        <span class="input-group-text bg-light">
            <i class="fas fa-user text-muted"></i>
        </span>
        <input type="text" 
               class="form-control @error('login') is-invalid @enderror" 
               name="login" 
               placeholder="Email/Username" 
               value="{{ old('login') }}"
               required>
        @error('login')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password"
                                       name="password" 
                                       placeholder="Password" 
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-sign-in-alt me-2"></i>MASUK
                        </button>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/customer/register" class="small text-primary">Daftar Akun</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/login_customer.js') }}"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>
    <script src="{{ asset('boostrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>