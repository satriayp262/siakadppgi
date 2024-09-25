<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
    </style>
    @vite('resources/css/app.css')
    <title>SIAKAD {{ $title ?? 'PPGI' }}</title>
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

</head>

<body class="flex flex-col min-h-screen bg-gray-200">

                {{ $slot }}
    @livewireScripts
</body>

</html>
