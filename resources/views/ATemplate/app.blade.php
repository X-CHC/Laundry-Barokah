<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | Laundry</title>
  <!-- CSS -->
    <link href="{{ asset('boostrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table_anggota.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table_orderan.css') }}" rel="stylesheet">
    <style>
    
</style>
</head>

<body>
  <!-- Include Header -->
  @include('ATemplate.header')

  <!-- Dynamic Content -->
  <div class="container mt-4">
    @yield('main-content')
  </div>

  <!-- Include Footer -->
  @include('ATemplate.footer')
  <script src="{{ asset('boostrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Pastikan jQuery dan Bootstrap JS sudah di-load -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
  @stack('scripts')
</body>
</html>