<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Pengajuan Cuti') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-h-screen">
            {{-- Navbar --}}
            @include('layouts.navbar')

            {{-- Content --}}
            <main class="flex-1 p-6 sm:p-8 lg:p-10">
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
