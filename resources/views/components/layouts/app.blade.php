<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title> {{ $title ?? 'SIAKAD PPGI' }}</title>
    <link rel="icon" href="{!! asset('img/piksi.png') !!}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @livewireStyles
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

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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

<body x-data="{ showSidebar: false }" @toggle-sidebar.window="showSidebar = !showSidebar" class="flex flex-col w-full z-14">
    <livewire:component.navbar />

    <div class="flex flex-col min-h-screen md:flex-row z-12">
        <aside :class="showSidebar ? 'translate-x-0' : '-translate-x-full'"
            class="fixed z-20 left-0 w-64 min-h-screen bg-customPurple transform transition-transform duration-300 md:relative md:translate-x-0">
            @auth
                @if (auth()->user()->role === 'admin')
                    <livewire:component.sidebar-admin />
                @elseif (auth()->user()->role === 'dosen')
                    <livewire:component.sidebar-dosen />
                @elseif (auth()->user()->role === 'mahasiswa')
                    <livewire:component.sidebar-mahasiswa />
                @elseif (auth()->user()->role === 'staff')
                    <livewire:component.sidebar-staff />
                @endif
            @endauth
        </aside>

        <div class="flex flex-col flex-1">
            <main class="flex-1 bg-gray-200">
                <div wire:loading class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
                    <div class="spinner loading-spinner"></div>
                </div>
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
                if (!event.detail[0]?.message) return;
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
                if (!event.detail[0]?.message) return;
                Swal.fire({
                    title: 'Success!',
                    text: event.detail[0].message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Dispatch the modal-closed event to close the modal
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                    if (event.detail[0].link) {
                        window.location.href = event.detail[0].link;
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('destroyed', event => {
                if (!event.detail[0]?.message) return;
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
            window.addEventListener('warning', event => {
                if (!event.detail[0]?.message) return;
                Swal.fire({
                    title: 'Error!',
                    text: event.detail[0].message,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Dispatch the modal-closed event to close the modal
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('BobotUpdate', event => {
                if (!event.detail[0]?.message) return;
                Swal.fire({
                    title: 'Success!',
                    text: event.detail[0].message,
                    icon: 'success',
                }).then(() => {
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                    window.location.href = event.detail[0].link;
                });
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @livewireScripts
    <script src="{{ asset('vendor/pharaonic/pharaonic.select2.min.js') }}"></script>
</body>

</html>
