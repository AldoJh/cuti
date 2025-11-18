<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Pengajuan Cuti') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- Sidebar (fixed) --}}
    @include('layouts.sidebar')

    {{-- Navbar (fixed) --}}
    @include('layouts.navbar')

    {{-- Content wrapper (scrollable + footer di bawah) --}}
<div class="pt-16 lg:ml-64 min-h-screen flex flex-col">

    {{-- area isi yang bisa scroll --}}
    <div class="flex-1 overflow-y-auto p-6 sm:p-8 lg:p-10">
        @yield('content')
    </div>

    {{-- Footer selalu di bawah --}}
    <footer class="bg-[#FF9900]  text-center text-sm text-gray-600">
        @include('layouts.footer')
    </footer>

</div>

    @vite('resources/js/app.js')

    <script>
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger');
        const overlay = document.getElementById('sidebar-overlay');

        hamburger?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html>
