@extends('ATemplate.app')

@section('title', 'Daftar Anggota')

@section('main-content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-users me-2"></i>Daftar Anggota
            </h6>
            <div>
                <a href="/pendaftaran" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-plus me-1"></i>Tambah Anggota
                </a>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-filter me-1"></i>Filter
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('Admin.cek_anggota') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari anggota..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Members Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Anggota</th>
                            <th>ID Customer</th>
                            <th>Email</th>
                            <th>Bergabung</th>
                            <th>Telepon</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $index => $customer)
                        <tr>
                            <td>{{ $index + $customers->firstItem() }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->nama_panjang) }}&background=4e73df&color=fff&size=40" 
                                         class="rounded-circle me-2" 
                                         width="40" 
                                         alt="Avatar">
                                    {{ $customer->nama_panjang }}
                                </div>
                            </td>
                            <td>{{ $customer->id_customer }}</td>
                            <td>{{ $customer->email ?? '-' }}</td>
                            <td>{{ $customer->created_at->format('d M Y') }}</td>
                            <td>{{ $customer->tlp }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.customers.show', $customer->id_customer) }}" 
                                   class="btn btn-sm btn-outline-primary me-1" 
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer->id_customer) }}" 
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

            <!-- Pagination -->
           <!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted small">
        Menampilkan {{ $customers->firstItem() }} - {{ $customers->lastItem() }} dari {{ $customers->total() }} anggota
    </div>
    <div>
        @if ($customers->previousPageUrl())
            <a href="{{ $customers->previousPageUrl() }}" class="btn btn-sm btn-outline-primary mr-1">
                <i class="fas fa-chevron-left"></i> Previous
            </a>
        @endif
        @if ($customers->nextPageUrl())
            <a href="{{ $customers->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
                Next <i class="fas fa-chevron-right"></i>
            </a>
        @endif
    </div>
</div>
</div>
        </div>
    </div>
</div>
@endsection