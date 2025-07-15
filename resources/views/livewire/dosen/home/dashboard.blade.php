<div class="p-4">
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(120%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .marquee-text:hover {
            animation-play-state: paused;
            /* Pauses animation on hover */
        }
    </style>

    <div class="overflow-hidden bg-purple-200 shadow-lg rounded-lg p-2 mb-4">
        <p class="inline-block whitespace-nowrap text-md font-semibold text-purple-600 marquee-text"
            style="animation: marquee 15s linear infinite;">
            Selamat Datang di halaman Dosen <span class="text-purple-600">SISTEM INFORMASI AKADEMIK POLITEKNIK PIKSI
                GANESHA INDONESIA</span>.
        </p>
    </div>


    <div class="bg-white shadow-lg p-6 rounded-lg">
        <h4 class="text-xl font-semibold mb-4 text-gray-800">Data Dosen</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Kolom 1 -->
            <div>
                <div class="flex flex-col mb-2">
                    <span class="font-semibold text-gray-700">Nama Dosen</span>
                    <span class="text-gray-900">{{ $dosen->nama_dosen }}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span class="font-semibold text-gray-700">NIDN</span>
                    <span class="text-gray-900">{{ $dosen->nidn }}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span class="font-semibold text-gray-700">Jenis Kelamin</span>
                    <span class="text-gray-900">{{ $dosen->jenis_kelamin }}</span>
                </div>
            </div>

            <!-- Kolom 2 -->
            <div>
                <div class="flex flex-col mb-2">
                    <span class="font-semibold text-gray-700">Jabatan Fungsional</span>
                    <span class="text-gray-900">{{ $dosen->jabatan_fungsional }}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span class="font-semibold text-gray-700">Kepangkatan</span>
                    <span class="text-gray-900">{{ $dosen->kepangkatan }}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span class="font-semibold text-gray-700">Prodi</span>
                    <span class="text-gray-900">{{ $dosen->prodi->nama_prodi }}</span>
                </div>
            </div>

            <!-- Kolom 3 -->
            <div>
                <div class="flex flex-col mb-2">
                    <span class="font-semibold text-gray-700">Email</span>
                    <span class="text-gray-900">{{ $user->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg p-6 rounded-lg mt-4">
        <div class="max-w-6xl mx-auto space-y-4">
            @livewire('component.chart-emonev-dosen', ['x' => $dosen->nidn], key(rand() . $dosen->id))
            <div class=" mt-4 items-stretch">
                <a href="{{ route('dosen.emonev') }}"
                    class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition">
                    Lihat selengkapnya
                </a>
            </div>
        </div>
    </div>

    <div class="flex w-full p-4 bg-white rounded-lg shadow-lg mt-4">
        <div class="flex flex-col w-full">
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success');
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
                @push('scripts')
                    <script>
                        setTimeout(() => {
                            const flashMessage = document.getElementById('flash-message');
                            if (flashMessage) {
                                flashMessage.remove();
                            }
                        }, 1000);
                    </script>
                @endpush
            @endif
            <form wire:submit.prevent="resetpw">
                <span class="mb-6 text-lg font-semibold">Reset Password</span>
                <div class="flex flex-col">
                    <label>Password Lama</label>
                    <div class="flex items-center">
                        <input id="currentPassword" type="password" wire:model="currentPassword"
                            wire:key="currentPassword-{{ now() }}"
                            class="w-1/4 p-2 border border-gray-500 rounded-lg">
                        <button type="button" onclick="togglePassword('currentPassword', this)" class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>

                    <label>Password Baru</label>
                    <div class="flex items-center">
                        <input id="newPassword" type="password" wire:model="newPassword"
                            wire:key="newPassword-{{ now() }}"
                            class="w-1/4 p-2 border border-gray-500 rounded-lg">
                        <button type="button" onclick="togglePassword('newPassword', this)" class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>

                    <label>Konfirmasi Password Baru</label>
                    <div class="flex items-center">
                        <input id="confirmPassword" type="password" wire:model="confirmPassword"
                            wire:key="confirmPassword-{{ now() }}"
                            class="w-1/4 p-2 border border-gray-500 rounded-lg">
                        <button type="button" onclick="togglePassword('confirmPassword', this)" class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button id="submit"
                    class="px-4 py-2 mt-6 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const eyeIcon = button.querySelector('svg');

        if (input.type === "password") {
            input.type = "text";
            // Change to closed eye icon
            eyeIcon.innerHTML = `
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                `; // Closed eye icon with a cross
        } else {
            input.type = "password";
            // Change back to default eye icon
            eyeIcon.innerHTML = `
                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                `; // Default eye icon
        }
    }
</script>
