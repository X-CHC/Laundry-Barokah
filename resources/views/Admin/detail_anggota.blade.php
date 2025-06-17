@extends('ATemplate.app')

@section('title', 'Detail Pelanggan')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user mr-2"></i>Detail Pelanggan
        </h1>
        <div>
            <a href="{{ route('customers.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
            <a href="{{ route('customers.edit', $customer->id_customer) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit mr-2"></i>Edit Data
            </a>
            <a href="{{ route('orders.create', $customer->id_customer) }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ml-2">
                <i class="fas fa-plus mr-2"></i>Buat Pesanan
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">
                Informasi Pelanggan #{{ $customer->id_customer }}
                <span class="badge badge-light ml-2">{{ $customer->status_akun }}</span>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri - Data Utama -->
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">ID Pelanggan</th>
                                <td>{{ $customer->id_customer }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $customer->username }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $customer->nama_panjang }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $customer->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $customer->tlp }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Kolom Kanan - Data Tambahan -->
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Alamat</th>
                                <td>{{ $customer->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status Akun</th>
                                <td>
                                    <span class="badge {{ $customer->status_akun == 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($customer->status_akun) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Pesanan</th>
                                <td>{{ $customer->orders->count() }} pesanan</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Daftar Pesanan -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-list-alt mr-2"></i>Riwayat Pesanan</h5>
                    
                    @if($customer->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Layanan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders as $order)
                                <tr>
                                    <td>{{ $order->id_pesanan }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $order->layanan->nama_layanan ?? '-' }}</td>
                                    <td>Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $order->status == 'selesai' ? 'badge-success' : 
                                               ($order->status == 'proses' ? 'badge-primary' : 
                                               ($order->status == 'pending' ? 'badge-warning' : 'badge-secondary')) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('orders.show', $order->id_pesanan) }}" class="btn btn-sm btn-info">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('customer.orders.print', ['id_pesanan' => $order->id_pesanan]) }}" 
           class="btn btn-sm btn-secondary ml-2" 
           target="_blank">
            <i class="fas fa-print"></i>
        </a>
    </div>
</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>Pelanggan ini belum memiliki pesanan.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection