<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Pengajuan Cuti') }}</title>
    @vite('resources/css/app.css') {{-- Pastikan Tailwind aktif --}}
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-red-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            {{-- Logo & Nama Aplikasi --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/logopnrm.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold tracking-wide">Sistem Cuti Online</span>
            </a>

            {{-- Tombol Login --}}
            <a href="{{ route('login') }}"
               class="bg-white text-red-700 font-semibold px-5 py-2 rounded-lg shadow hover:bg-gray-100 transition duration-300 ease-in-out">
                Login
            </a>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="bg-white shadow-xl rounded-2xl p-10 max-w-xl w-full text-center border border-gray-100">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-50 border-t border-gray-200 text-gray-500 text-sm text-center py-4">
        &copy; {{ date('Y') }} <span class="font-semibold text-gray-700">Pengadilan Negeri Lhokseumawe</span> — Sistem Cuti Pegawai
    </footer>

</body>
</html>
