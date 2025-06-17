@extends('ATemplate.app')

@section('title', 'Detail Pesanan Laundry')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-invoice mr-2"></i>Detail Pesanan
        </h1>
        <a href="{{ route('orders.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pesanan
        </a>
    </div>

    <!-- Detail Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">
                Informasi Pesanan #{{ $order->id_pesanan }}
                <span class="badge badge-light ml-2">{{ strtoupper($order->metode_pembayaran) }}</span>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Kode Pesanan</th>
                                <td>{{ $order->id_pesanan }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengambilan</th>
                                <td>{{ $order->tglPengambilan->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Layanan</th>
                                <td>
                                    <strong>{{ $order->layanan->nama_layanan ?? '-' }}</strong>
                                    <div class="text-muted small">
                                        Rp {{ number_format($order->layanan->harga_per_kg ?? 0, 0, ',', '.') }}/kg
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah (kg)</th>
                                <td>{{ $order->jumlah }} kg</td>
                            </tr>
                            <tr>
                                <th>Total Harga</th>
                                <td class="font-weight-bold">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="2" class="bg-light">Informasi Pelanggan</th>
                            </tr>
                            <tr>
                                <th width="40%">Nama Pelanggan</th>
                                <td>{{ $order->customer->nama_panjang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $order->customer->tlp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $order->customer->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $order->catatan ?? 'Tidak ada catatan' }}</td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($order->bukti_bayar)
                                                <span class="badge badge-success">Lunas</span>
                                                <small class="text-muted ml-2">
                                                    ({{ $order->metode_pembayaran == 'cash' ? 'Tunai' : 'QRIS' }})
                                                </small>
                                            @else
                                                <span class="badge badge-warning">Belum Lunas</span>
                                            @endif
                                        </div>
                                        @if(!$order->bukti_bayar)
                                            <button class="btn btn-sm btn-primary ml-2" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#paymentModal">
                                                <i class="fas fa-credit-card mr-1"></i> Konfirmasi
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran hanya untuk QRIS -->
            @if($order->bukti_bayar && $order->metode_pembayaran == 'qris')
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-receipt mr-2"></i>Bukti Pembayaran QRIS</h5>
                    <div class="text-center">
                        <img src="{{ asset('storage/bukti_bayar/'.$order->bukti_bayar) }}" 
                             class="img-fluid rounded border" 
                             style="max-height: 200px;">
                        <div class="mt-2">
                            <a href="{{ asset('storage/bukti_bayar/'.$order->bukti_bayar) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary">
                               <i class="fas fa-expand mr-1"></i> Lihat Full Size
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="card-footer text-right">
            <!-- Button trigger -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                <i class="fas fa-times-circle mr-1"></i>Batalkan Pesanan
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('orders.upload-payment', $order->id_pesanan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select" required id="paymentMethodSelect">
              <option value="cash">Tunai (Bayar di Tempat)</option>
              <option value="qris">QRIS</option>
            </select>
          </div>
          
          <div class="mb-3" id="buktiBayarGroup" style="display:none">
            <label class="form-label">Upload Bukti Transfer</label>
            <input type="file" name="bukti_bayar" class="form-control" accept="image/*">
            <small class="text-muted">Format: JPG/PNG, maks 2MB</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Pembatalan -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Konfirmasi Pembatalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin membatalkan pesanan #{{ $order->id_pesanan }}?
                <div class="alert alert-warning mt-2">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Status pesanan akan diubah menjadi "Dibatalkan" dan tidak dapat dikembalikan!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('orders.cancel', $order->id_pesanan) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban mr-1"></i>Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle field upload bukti bayar
    const paymentMethod = document.getElementById('paymentMethodSelect');
    const buktiGroup = document.getElementById('buktiBayarGroup');
    
    paymentMethod.addEventListener('change', function() {
        buktiGroup.style.display = this.value === 'qris' ? 'block' : 'none';
    });
});
</script>
@endpush
@endsection