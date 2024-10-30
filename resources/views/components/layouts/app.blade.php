<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <title> {{ $title ?? 'SIAKAD PPGI' }}</title>
    <link rel="icon" href="{!! asset('img/piksi.png') !!}" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
        .spinner {
                border: 5px solid rgba(0, 0, 0, 0.2);
                /* Light border for background */
                border-radius: 50%;
                border-top: 5px solid #3498db;
                /* Blue border for spinner */
                width: 36px;
                /* Increased size for visibility */
                height: 36px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
    </style>
</head>

<body class="flex flex-col w-full z-14">
    <livewire:component.navbar/>
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
            <main class="flex-1 bg-gray-200">
                {{ $slot }}
            </main>
            <livewire:component.footer />
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS untuk memperkecil ukuran modal -->
    <style>
        .small-swal {
            font-size: 0.8rem;
            /* Ukuran font lebih kecil */
            padding: 1.5rem;
            /* Mengurangi padding modal */
            width: 300px;
            /* Mengurangi lebar modal */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('updated', event => {
                Swal.fire({
                    title: 'Success!',
                    text: event.detail[0].message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Dispatch the modal-closed event to close the modal
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('created', event => {
                Swal.fire({
                    title: 'Success!',
                    text: event.detail[0].message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Dispatch the modal-closed event to close the modal
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('destroyed', event => {
                Swal.fire({
                    title: 'Success!',
                    text: event.detail[0].message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Dispatch the modal-closed event to close the modal
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });
    </script>
    @livewireScripts
</body>

</html>
