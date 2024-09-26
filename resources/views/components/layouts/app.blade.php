<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SIAKAD {{ $title ?? 'PPGI' }}</title>
</head>

<body class="flex flex-col w-full z-14">
    <livewire:component.navbar />
    <div class="flex flex-col min-h-screen md:flex-row z-12">
        <aside class="h-full z-11">
            <livewire:component.sidebar />
        </aside>
        <div class="flex flex-col flex-1">
            <main class="flex-1">
                {{ $slot }}
            </main>
            <livewire:component.footer />
        </div>
    </div>
</body>

</html>
