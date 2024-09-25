<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SIAKAD {{ $title ?? 'PPGI' }}</title>
</head>

<body class="flex flex-col w-full">
    <livewire:component.navbar />
    <div class="flex flex-col flex-1 md:flex-row">
        <livewire:component.sidebar />

        <div class="flex flex-col flex-1">
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
    <livewire:component.footer />
</body>

</html>
