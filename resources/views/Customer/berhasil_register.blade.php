<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - LaundryKu</title>
    <link href="{{ asset('boostrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="mb-3">Registrasi Berhasil!</h2>
                        <p class="mb-4">Terima kasih telah mendaftar di LaundryKu. Akun Anda telah berhasil dibuat.</p>
                        <a href="{{ route('customer.login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>