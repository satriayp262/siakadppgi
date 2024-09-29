<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title> {{ $title ?? 'SIAKAD PPGI' }}</title>
    <link rel="icon" href="{!! asset('img/piksi.png') !!}" />
</head>

<body class="flex flex-col w-full z-14">
    <livewire:component.navbar />
    <div class="flex flex-col min-h-screen md:flex-row z-12">
        <aside class="flex-shrink-0 z-11">
            @if (auth()->check())
                @if (auth()->user()->role === 'admin')
                    <livewire:component.sidebar-admin />
                @elseif (auth()->user()->role === 'dosen')
                    <livewire:component.sidebar-dosen />
                @elseif (auth()->user()->role === 'mahasiswa')
                    <livewire:component.sidebar-mahasiswa />
                @elseif (auth()->user()->role === 'staff')
                    <livewire:component.sidebar-staff />
                @endif
            @endif
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
