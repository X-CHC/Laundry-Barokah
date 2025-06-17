@extends('ATemplate.app')

@section('title', 'Pendaftaran Member')

@section('main-content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-user-plus me-2"></i>Form Pendaftaran Member
            </h6>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form id="registrationForm" method="POST" action="{{ route('customer.register.submit') }}">
                @csrf
                <!-- Personal Data Section -->
                <div class="row mb-1">
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary"><i class="fas fa-id-card me-2"></i>Data Pribadi</h5>
                        
                        <div class="form-group mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
    <div class="col-md-6 form-group mb-3">
        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" 
               id="username" name="username" value="{{ old('username') }}" required>
        @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6 form-group mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 form-group mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi <span class="text-danger">*</span></label>
                <input type="password" class="form-control" 
                    id="password_confirmation" name="password_confirmation" 
                    value="{{ old('password_confirmation') }}" required>
            </div>
        </div>
    </div>
</div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="noHp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('noHp') is-invalid @enderror" id="noHp" name="noHp" value="{{ old('noHp') }}" required>
                                @error('noHp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Service Selection Section -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary"><i class="fas fa-tags me-2"></i>Layanan</h5>
                        
                        <div class="form-group mb-3">
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

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="berat" class="form-label">Berat (kg) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" class="form-control @error('berat') is-invalid @enderror" id="berat" name="berat" min="0.1" value="{{ old('berat', 1) }}" required>
                                @error('berat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="tglPengambilan" class="form-label">Tanggal Pengambilan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tglPengambilan') is-invalid @enderror" id="tglPengambilan" name="tglPengambilan" value="{{ old('tglPengambilan') }}" required>
                                @error('tglPengambilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input @error('payment') is-invalid @enderror" type="radio" 
                                    name="payment" id="cash" value="cash" 
                                    {{ old('payment', 'cash') == 'cash' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cash">Cash</label>
                            </div>
                                                        <div class="form-check">
                                <input class="form-check-input @error('payment') is-invalid @enderror" type="radio" name="payment" id="transfer" value="qris" {{ old('payment') == 'qris' ? 'checked' : '' }}>
                                <label class="form-check-label" for="transfer">Qris</label>
                            </div>
                            @error('payment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Summary & Submit -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="catatan" class="form-label">Catatan Khusus</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3" placeholder="Permintaan khusus...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold">Ringkasan Order</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Harga per kg</td>
                                        <td class="text-end" id="harga-per-kg">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td>Berat</td>
                                        <td class="text-end" id="display-berat">1 kg</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Total</td>
                                        <td class="text-end" id="total-harga">Rp 0</td>
                                    </tr>
                                </table>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i>Submit Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const layananSelect = document.getElementById('layanan');
    const beratInput = document.getElementById('berat');
    const hargaPerKgDisplay = document.getElementById('harga-per-kg');
    const displayBerat = document.getElementById('display-berat');
    const totalHargaDisplay = document.getElementById('total-harga');

    // Set tanggal pengambilan minimal besok
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const tglPengambilanInput = document.getElementById('tglPengambilan');
    tglPengambilanInput.min = tomorrow.toISOString().split('T')[0];

    // Fungsi untuk menghitung total harga
    function calculateTotal() {
        const selectedOption = layananSelect.options[layananSelect.selectedIndex];
        const hargaPerKg = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga')) || 0 : 0;
        const berat = parseFloat(beratInput.value) || 0;

        const totalHarga = hargaPerKg * berat;

        // Update tampilan
        hargaPerKgDisplay.textContent = formatRupiah(hargaPerKg);
        displayBerat.textContent = berat.toFixed(1) + ' kg';
        totalHargaDisplay.textContent = formatRupiah(totalHarga);
    }

    // Format angka ke format Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + angka.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Event listeners
    layananSelect.addEventListener('change', calculateTotal);
    beratInput.addEventListener('input', calculateTotal);

    // Hitung total saat pertama kali load
    calculateTotal();
});
</script>
@endpush