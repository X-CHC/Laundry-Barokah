<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | Laundry</title>
  <!-- CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

</head>

<body>
  <!-- Include Header -->
  @include('CTemplate.header')

  <!-- Dynamic Content -->
  <div class="container mt-4">
    @yield('main-content')
  </div>

  <!-- Include Footer -->
  @include('CTemplate.footer')

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
  @stack('scripts')
</body>
</html>