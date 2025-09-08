<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pengadilan Negeri')</title>
    @vite('resources/css/app.css')
</head>
<body class="@yield('body-class', 'bg-gray-100')">
    @yield('content')
    @vite('resources/js/app.js')
</body>
</html>
