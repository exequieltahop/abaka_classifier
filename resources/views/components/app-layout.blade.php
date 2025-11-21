<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/build/manifest.webmanifest" />
    <meta name="theme-color" content="#4D179A" />
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/pwa-install.js')
</head>

<body class="bg-whitesmoke">
    {{ $slot }}
</body>

</html>
