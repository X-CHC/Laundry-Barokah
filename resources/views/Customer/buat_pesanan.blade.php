<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - LaundryKu</title>
    <!-- Load CSS dari CDN sebagai fallback -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Load local assets -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 56px; /* Untuk navbar fixed */
        }
        .form-container {
            max-width: 800px;
            margin: 30px auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-submit {
            min-width: 150px;
        }
        @media (max-width: 768px) {
            .form-container {
                margin: 15px auto;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">LaundryKu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.dashboard') }}"><i class="fas fa-home me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('customer.orders.create') }}"><i class="fas fa-plus-circle me-1"></i> Buat Pesanan</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link"><i class="fas fa-user me-1"></i> {{ $customer->nama_panjang }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container form-container py-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Form Pemesanan Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.orders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">

    <label class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('layanan') is-invalid @enderror" id="layanan" name="layanan" required>
                                <option selected disabled value="">Pilih Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id_layanan }}" data-harga="{{ $service->harga_per_kg }}" {{ old('layanan') == $service->id_layanan ? 'selected' : '' }}>
                                        {{ $service->nama_layanan }} ({{ $service->estimasi_durasi }} hari) - Rp{{ number_format($service->harga_per_kg, 0, ',', '.') }}/kg
                                    </option>
                                @endforeach
                            </select>
                            @error('layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

</div>
                        <div class="col-md-6 mb-3">
                            <label for="jumlah" class="form-label">Jumlah (kg)</label>
                            <input type="number" step="0.1" min="0.1" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="" selected disabled>-- Pilih Pembayaran --</option>
                                <option value="cash">Cash</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" id="buktiBayarContainer" style="display:none;">
                            <label for="bukti_bayar" class="form-label">Upload Bukti Bayar</label>
                            <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Khusus</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Contoh: Jangan pakai pewangi, ada baju khusus, dll."></textarea>
                    </div>

                    <div class="alert alert-info mb-4">
                        <strong>Total Harga:</strong> 
                        <span id="totalHarga">Rp 0</span>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            &copy; {{ date('Y') }} LaundryKu - All Rights Reserved
        </div>
    </footer>

    <!-- Load JavaScript -->
    <!-- JQuery dulu, kemudian Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        // Pastikan DOM sudah fully loaded
        $(document).ready(function() {
            // Hitung total harga otomatis
            $('#id_layanan, #jumlah').on('change input', calculateTotal);
            
            // Tampilkan field bukti bayar jika pilih QRIS
            $('#metode_pembayaran').change(function() {
                $('#buktiBayarContainer').toggle(this.value === 'qris');
                if(this.value === 'qris') {
                    $('#bukti_bayar').prop('required', true);
                } else {
                    $('#bukti_bayar').prop('required', false);
                }
            });

            function calculateTotal() {
                const layananSelect = $('#id_layanan');
                const jumlahInput = $('#jumlah');
                const totalSpan = $('#totalHarga');
                
                if (layananSelect.val() && jumlahInput.val()) {
                    const harga = layananSelect.find('option:selected').data('harga');
                    const total = harga * jumlahInput.val();
                    totalSpan.text('Rp ' + total.toLocaleString('id-ID'));
                } else {
                    totalSpan.text('Rp 0');
                }
            }

            // Set tanggal minimal ke hari ini
            const today = new Date().toISOString().split('T')[0];
            $('#tanggal_pesan').attr('min', today);
        });
    </script>
</body>
</html>