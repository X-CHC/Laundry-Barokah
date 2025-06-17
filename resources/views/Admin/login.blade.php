<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin LaundryKu</title>

    <link href="{{ asset('boostrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontsawesome/css/all.min.css') }}">

</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="brand-logo">
                    <i class="fas fa-cloud-sun me-2"></i>Laundry Barokah
                </div>
                <p class="mb-0">Administrator System</p>
            </div>
            
            <!-- Login Form -->
            <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                            id="username" name="username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            id="password" name="password" required>
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
                
                <button type="submit" class="btn btn-login btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('boostrap/js/bootstrap.bundle.min.js') }}"></script>
    
</body>
</html>