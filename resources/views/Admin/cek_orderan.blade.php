@extends('ATemplate.app')

@section('title', 'Daftar Orderan Laundry')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list mr-2"></i>Daftar Orderan Laundry
            </h6>
            <div>
                <button class="btn btn-sm btn-success mr-2">
                    <i class="fas fa-file-excel mr-1"></i>Export Excel
                </button>
                <button class="btn btn-sm btn-primary" id="filterButton" data-toggle="modal" data-target="#filterModal">
    <i class="fas fa-filter mr-1"></i>Filter
</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Order</th>
                            <th>Pelanggan</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Pengambilan</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Metode Pembayaran</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->id_pesanan }}</td>
                            <td>{{ $order->customer->nama_panjang ?? 'Pelanggan Tidak Diketahui' }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ $order->tglPengambilan->format('d/m/Y') }}</td>
                            <td>{{ $order->jumlah }} kg</td>
                            <td>Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                            <td>
                                @if($order->metode_pembayaran == 'cash')
                                    Tunai
                                @else
                                    QRIS
                                @endif
                            </td>
                            <td class="text-center">
                                <!-- Button Detail -->
                                <a href="{{ route('orders.show', $order->id_pesanan) }}" 
                                class="btn btn-sm btn-circle btn-info mr-1"
                                title="Detail Pesanan">
                                <i class="fas fa-eye"></i>
                                </a>
                                
                               <!-- Button Ubah Status -->
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
    </form> <!-- Tag penutup form yang sebelumnya hilang -->
@endif
                                
                                <!-- Badge Status -->
                                <div class="mt-1">
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge badge-primary">Baru</span>
                                            @break
                                        @case('proses')
                                            <span class="badge badge-warning">Proses</span>
                                            @break
                                        @case('selesai')
                                            <span class="badge badge-success">Selesai</span>
                                            @break
                                        @case('batal')
                                            <span class="badge text-bg-danger">Cancel</span>
                                            @break
                                    @endswitch
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted small">
        Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} entri
    </div>
    <div>
        @if ($orders->previousPageUrl())
            <a href="{{ $orders->previousPageUrl() }}" class="btn btn-sm btn-outline-primary mr-1">
                <i class="fas fa-chevron-left"></i> Previous
            </a>
        @endif
        @if ($orders->nextPageUrl())
            <a href="{{ $orders->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
                Next <i class="fas fa-chevron-right"></i>
            </a>
        @endif
    </div>
</div>
        </div>
    </div>
</div>



<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="GET" action="{{ route('orders.index') }}" id="filterForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select class="form-control" name="payment_method">
                            <option value="">Semua Metode</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                            <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cari (Nama/Kode)</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" 
                               placeholder="Nama pelanggan atau kode order">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Submit form filter saat tombol diklik
        $('#filterForm').on('submit', function(e) {
            $('#filterModal').modal('hide');
        });
        
        // Tampilkan parameter filter yang aktif
        function checkActiveFilters() {
            let hasFilters = false;
            const params = new URLSearchParams(window.location.search);
            
            if (params.has('start_date') || params.has('end_date') || 
                params.has('payment_method') || params.has('search')) {
                hasFilters = true;
            }
            
            if (hasFilters) {
                $('#filterButton').addClass('btn-warning').removeClass('btn-primary')
                    .html('<i class="fas fa-filter mr-1"></i>Filter Aktif');
            }
        }
        
        checkActiveFilters();
    });
</script>
@endsection