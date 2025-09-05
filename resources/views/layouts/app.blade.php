<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ config('app.name', 'Pengajuan Cuti') }}</title>

  <!-- Stisla CSS -->
  <link rel="stylesheet" href="{{ asset('stisla/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/css/components.css') }}">
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      
      {{-- Navbar --}}
      @include('layouts.navbar')

      {{-- Sidebar --}}
      @include('layouts.sidebar')

      {{-- Content --}}
      <div class="main-content">
        @yield('content')
      </div>

      {{-- Footer --}}
      @include('layouts.footer')

    </div>
  </div>

  <!-- Stisla JS -->
  <script src="{{ asset('stisla/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('stisla/assets/modules/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('stisla/assets/js/stisla.js') }}"></script>
  <script src="{{ asset('stisla/assets/js/scripts.js') }}"></script>
</body>
</html>
