@extends('ATemplate.app')

@section('title', 'Buat Pesanan Baru')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle mr-2"></i>Buat Pesanan Baru
        </h1>
        <div>
            <a href="{{ route('customers.show', $customer->id_customer) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Informasi Pelanggan -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user mr-2"></i>Informasi Pelanggan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">ID Pelanggan</th>
                                <td>{{ $customer->id_customer }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $customer->nama_panjang }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $customer->tlp }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $customer->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Total Pesanan</th>
                                <td>{{ $customer->orders->count() }} pesanan</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Pesanan -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-success">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-concierge-bell mr-2"></i>Form Pesanan Laundry
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_customer" value="{{ $customer->id_customer }}">

                        <div class="form-group">
                            <label for="id_layanan">Layanan</label>
                            <select class="form-control @error('id_layanan') is-invalid @enderror" 
                                    id="id_layanan" name="id_layanan" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id_layanan }}" 
                                        {{ old('id_layanan') == $layanan->id_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}/kg)
                                    </option>
                                @endforeach
                            </select>
                            @error('id_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="berat">Berat (kg)</label>
                                    <input type="number" step="0.1" min="0.1" 
                                           class="form-control @error('berat') is-invalid @enderror" 
                                           id="berat" name="berat" 
                                           value="{{ old('berat') }}" required>
                                    @error('berat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_pengambilan">Tanggal Pengambilan</label>
                                    <input type="date" 
                                           class="form-control @error('tgl_pengambilan') is-invalid @enderror" 
                                           id="tgl_pengambilan" name="tgl_pengambilan" 
                                           value="{{ old('tgl_pengambilan') }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('tgl_pengambilan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
    <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
    <div class="row align-items-center">
        <div class="col-md-8">
            <select class="form-select @error('metode_pembayaran') is-invalid @enderror" 
                    id="metode_pembayaran" name="metode_pembayaran" required>
                <option value="">-- Pilih Pembayaran --</option>
                <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="qris" {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
            @error('metode_pembayaran')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4" id="qris-scan-container" style="display: none;">
            <button type="button" class="btn btn-outline-primary w-100" 
                    onclick="window.open('{{ asset('qrcode/barcode.jpg') }}', '_blank')">
                <i class="fas fa-qrcode me-1"></i> Scan QRIS
            </button>
        </div>
    </div>
</div>




                        <div class="form-group">
                            <label for="catatan">Catatan (Opsional)</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                      id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                Total harga akan dihitung otomatis setelah memilih layanan dan memasukkan berat
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Simpan Pesanan
                            </button>
                            <a href="{{ route('customers.show', $customer->id_customer) }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script untuk menghitung total harga otomatis
    document.addEventListener('DOMContentLoaded', function() {
        const layananSelect = document.getElementById('id_layanan');
        const beratInput = document.getElementById('berat');
        const hargaPerKg = {};
        
        // Isi data harga per kg dari layanan
        @foreach($layanans as $layanan)
            hargaPerKg['{{ $layanan->id_layanan }}'] = {{ $layanan->harga_per_kg }};
        @endforeach
        
        // Fungsi untuk update info harga
        function updateHargaInfo() {
            const selectedLayanan = layananSelect.value;
            const berat = parseFloat(beratInput.value) || 0;
            
            if (selectedLayanan && berat > 0) {
                const total = hargaPerKg[selectedLayanan] * berat;
                document.querySelector('.alert-info').innerHTML = `
                    <i class="fas fa-calculator mr-2"></i>
                    Total Harga: Rp ${total.toLocaleString('id-ID')} 
                    (${berat} kg × Rp ${hargaPerKg[selectedLayanan].toLocaleString('id-ID')}/kg)
                `;
            } else {
                document.querySelector('.alert-info').innerHTML = `
                    <i class="fas fa-info-circle mr-2"></i>
                    Total harga akan dihitung otomatis setelah memilih layanan dan memasukkan berat
                `;
            }
        }
        
        // Event listeners
        layananSelect.addEventListener('change', updateHargaInfo);
        beratInput.addEventListener('input', updateHargaInfo);
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.getElementById('metode_pembayaran');
    const qrisScanContainer = document.getElementById('qris-scan-container');

    // Fungsi untuk menampilkan/menyembunyikan tombol scan
    function toggleQrisButton() {
        if (paymentMethod.value === 'qris') {
            qrisScanContainer.style.display = 'block';
        } else {
            qrisScanContainer.style.display = 'none';
        }
    }

    // Event listener untuk perubahan select
    paymentMethod.addEventListener('change', toggleQrisButton);
    
    // Jalankan sekali saat halaman dimuat
    toggleQrisButton();
});
</script>
@section('scripts')


@endsection
