@extends('ATemplate.app')

@section('title', 'Dashboard')

@section('main-content')
<div class="container-fluid py-4">

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary mb-1">
                                Orderan Hari Ini</div>
                            <div class="h5 mb-0 fw-bold">{{ $todayOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-basket-shopping fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success mb-1">
                                Selesai Orderan</div>
                            <div class="h5 mb-0 fw-bold">{{ $completedOrders }}</div>
                            <div class="progress mt-2" style="height: 5px">
                                @php
                                    $completionPercentage = $todayOrders > 0 ? ($completedOrders / $todayOrders) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-success" style="width: {{ $completionPercentage }}%"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning mb-1">
                                Dalam Pekerjaan</div>
                            <div class="h5 mb-0 fw-bold">{{ $inProgressOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-danger border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-danger mb-1">
                                Orderan Dibatalkan</div>
                            <div class="h5 mb-0 fw-bold">{{ $canceledOrders }}</div>
                            <div class="progress mt-2" style="height: 5px">
                                @php
                                    $cancelPercentage = $todayOrders > 0 ? ($canceledOrders / $todayOrders) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-danger" style="width: {{ $cancelPercentage }}%"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-list me-2"></i>Riwayat Orderan Terbaru
            </h6>
            <a href="/cek-orderan" class="btn btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Order</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->id_pesanan }}</td>
                            <td>{{ $order->customer->nama_panjang ?? 'Pelanggan Tidak Diketahui' }}</td>
                            <td>{{ $order->layanan->nama_layanan ?? '-' }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-primary">Baru</span>
                                        @break
                                    @case('proses')
                                        <span class="badge bg-warning">Proses</span>
                                        @break
                                    @case('selesai')
                                        <span class="badge bg-success">Selesai</span>
                                        @break
                                    @case('batal')
                                        <span class="badge bg-danger">Cancel</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="text-center">
                                <a href="{{ route('orders.show', $order->id_pesanan) }}" 
                                   class="btn btn-sm btn-circle btn-info mr-1"
                                   title="Detail Pesanan">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($order->status == 'proses')
                                <form action="{{ route('orders.update-status', $order->id_pesanan) }}" 
                                    method="POST" 
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ubah status pesanan ini menjadi selesai?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" 
                                            class="btn btn-sm btn-circle btn-success"
                                            title="Tandai Selesai">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @elseif($order->status == 'pending')
                                <form action="{{ route('orders.update-status', $order->id_pesanan) }}" 
                                    method="POST" 
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ubah status pesanan ini menjadi proses?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="proses">
                                    <button type="submit" 
                                            class="btn btn-sm btn-circle btn-warning"
                                            title="Tandai Proses">
                                        <i class="fas fa-spinner"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection