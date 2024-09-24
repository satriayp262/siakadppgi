<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>SIAKAD {{ $title ?? 'PPGI' }}</title>
</head>

<body class="flex flex-col min-h-screen">
    <livewire:component.navbar />
    <div class="flex flex-col flex-1 md:flex-row">
        <livewire:component.sidebar />

        <div class="flex flex-col flex-1">
            <main class="flex-1 mb-16">
                {{ $slot }}
            </main>
            <livewire:component.footer />
        </div>
    </div>
</body>

</html>
