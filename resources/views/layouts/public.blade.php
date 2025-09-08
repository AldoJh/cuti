<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Pengajuan Cuti') }}</title>
  @vite('resources/css/app.css') {{-- pastikan Tailwind aktif --}}
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  {{-- Navbar --}}
  <nav class="bg-blue-700 text-white flex justify-between items-center px-6 py-3 shadow-md">
    <a href="{{ route('home') }}" class="flex items-center space-x-2">
      <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-8 w-8 object-cover rounded-full">
      <span class="font-bold text-lg">Cuti Online</span>
    </a>
    <a href="{{ route('login') }}" class="bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition duration-200">
      Login
    </a>
  </nav>

  {{-- Konten --}}
  <main class="flex-grow flex items-center justify-center px-4 py-12">
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-xl w-full text-center">
      @yield('content')
    </div>
  </main>

  {{-- Footer --}}
  <footer class="bg-white text-gray-500 text-sm text-center p-4 shadow-inner">
    &copy; {{ date('Y') }} Pengadilan Lhokseumawe - Sistem Cuti
  </footer>

</body>
</html>
