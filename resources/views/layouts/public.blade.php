<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ config('app.name', 'Pengajuan Cuti') }}</title>
  <link rel="stylesheet" href="{{ asset('stisla/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/assets/css/components.css') }}">
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      
      {{-- Navbar Publik --}}
      <nav class="navbar navbar-expand-lg main-navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Cuti Online</a>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
          </li>
        </ul>
      </nav>

      {{-- Konten --}}
      <div class="main-content">
        @yield('content')
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          &copy; {{ date('Y') }} Pengadilan Lhokseumawe
        </div>
      </footer>

    </div>
  </div>
</body>
</html>
