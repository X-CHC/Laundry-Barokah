@extends('ATemplate.app')

@section('title', 'Daftar Layanan')

@section('main-content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-concierge-bell me-2"></i>Daftar Layanan
            </h6>
            <div>
                <a href="{{ route('admin.layanan.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Layanan
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('admin.layanan.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari layanan..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Services Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>ID Layanan</th>
                            <th>Nama Layanan</th>
                            <th>Harga per Kg</th>
                            <th>Estimasi Durasi</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($layanans as $index => $layanan)
                        <tr>
                            <td>{{ $index + $layanans->firstItem() }}</td>
                            <td>{{ $layanan->id_layanan }}</td>
                            <td>{{ $layanan->nama_layanan }}</td>
                            <td>Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}</td>
                            <td>{{ $layanan->estimasi_durasi }} hari</td>
                            <td class="text-center">
                                <a href="{{ route('admin.layanan.edit', $layanan->id_layanan) }}" 
                                   class="btn btn-sm btn-outline-warning"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Corrected Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $layanans->firstItem() }} - {{ $layanans->lastItem() }} dari {{ $layanans->total() }} layanan
                </div>
                <div>
                    @if ($layanans->previousPageUrl())
                        <a href="{{ $layanans->previousPageUrl() }}" class="btn btn-sm btn-outline-primary mr-1">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif
                    @if ($layanans->nextPageUrl())
                        <a href="{{ $layanans->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection