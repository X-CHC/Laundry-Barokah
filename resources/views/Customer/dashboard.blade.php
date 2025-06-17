<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - LaundryKu</title>
    <link href="{{ asset('boostrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fontsawesome/css/all.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .order-card {
            transition: transform 0.3s;
        }
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">LaundryKu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('customer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.orders.create') }}">Buat Pesanan</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">Halo, {{ $customer->nama_panjang }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar Profil (Kiri di desktop, Atas di mobile) -->
            <div class="col-lg-4 sidebar">
                <div class="card profile-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Profil Saya</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-user text-white" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Nama Lengkap</h6>
                            <p class="mb-0">{{ $customer->nama_panjang }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Username</h6>
                            <p class="mb-0">{{ $customer->username }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Email</h6>
                            <p class="mb-0">{{ $customer->email ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Telepon</h6>
                            <p class="mb-0">{{ $customer->tlp }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Alamat</h6>
                            <p class="mb-0">{{ $customer->alamat ?? '-' }}</p>
                        </div>
                        
                        <a href="{{ route('customer.profile.edit') }}" class="btn btn-outline-primary w-100 mt-2">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Konten Utama (Kanan di desktop, Bawah di mobile) -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Pesanan Terakhir</h5>
                            <a href="{{ route('customer.orders.create') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah Pesanan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($orders->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada pesanan</p>
                                <a href="{{ route('customer.orders.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Buat Pesanan Pertama
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
    <tr>
        <th>No</th> <!-- Ubah header dari ID Pesanan menjadi No -->
        <th>Tanggal</th>
        <th>Layanan</th>
        <th>Status</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @foreach($orders as $order)
    <tr>
        <td>{{ $loop->iteration }}</td> <!-- Gunakan nomor urut -->
        <td>{{ $order->created_at->format('d M Y') }}</td>
        <td>{{ $order->layanan->nama_layanan ?? 'Layanan tidak ditemukan' }}</td>
        <td>
            <span class="badge 
                @if($order->status == 'selesai') bg-success
                @elseif($order->status == 'proses') bg-warning text-dark
                @elseif($order->status == 'pending') bg-primary
                @else bg-secondary
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </td>
        <td>Rp {{ number_format($order->price, 0, ',', '.') }}</td>
        <td>
            <a href="{{ route('customer.orders.show', ['id_pesanan' => $order->id_pesanan]) }}" class="btn btn-sm btn-outline-primary">
                <span class="badge badge-warning">Cetak</span>
            </a>
        </td>
    </tr>
    @endforeach
</tbody>
                                </table>
                            </div>
                            
                            <div class="d-flex justify-content-center mt-3">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Statistik Ringkas -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title">Total Pesanan</h6>
                                <h3 class="mb-0">{{ $orders->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6 class="card-title">Pesanan Selesai</h6>
                                <h3 class="mb-0">{{ $orders->where('status', 'selesai')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h6 class="card-title">Dalam Proses</h6>
                                <h3 class="mb-0">{{ $orders->where('status', 'proses')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            &copy; {{ date('Y') }} LaundryKu - All Rights Reserved
        </div>
    </footer>

    <script src="{{ asset('boostrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Script untuk tampilan responsif
        function adjustLayout() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.col-lg-8');
            
            if (window.innerWidth < 992) {
                sidebar.parentNode.insertBefore(mainContent, sidebar);
            } else {
                sidebar.parentNode.insertBefore(sidebar, mainContent);
            }
        }
        
        window.addEventListener('resize', adjustLayout);
        document.addEventListener('DOMContentLoaded', adjustLayout);
    </script>
</body>
</html>









