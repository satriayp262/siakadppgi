<div class="flex flex-col p-4">
    <div class="w-full p-4 mb-6 border border-gray-500 rounded-lg">
        <div class="flex flex-col">
            <span class="mb-6 text-lg font-semibold">
                Data Mahasiswa
            </span>
            <div class="grid grid-cols-3 gap-6">
                <div class="flex flex-col mb-2">
                    <span>NIM</span>
                    <span class="font-bold">{{$nim}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Nama Mahasiswa</span>
                    <span class="font-bold">{{$nama}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Tempat Lahir</span>
                    <span class="font-bold">{{$tempat_lahir}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Tanggal Lahir</span>
                    <span class="font-bold">{{$tanggal_lahir}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Agama</span>
                    <span class="font-bold">{{$agama}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Alamat</span>
                    <span class="font-bold">{{$alamat}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Jalur Pendaftaran</span>
                    <span class="font-bold">{{$jenis_pendaftaran}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Nomor Hp</span>
                    <span class="font-bold">{{$no}}</span>
                </div>
                <div class="flex flex-col mb-2">
                    <span>Prodi</span>
                    <span class="font-bold">{{$prodi}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full p-4 border border-gray-500 rounded-lg">
        @if (session()->has('message'))
            @php
                $messageType = session('message_type', 'success'); // Default to success
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
                    }, 1000); // Adjust the time (in milliseconds) as needed
                </script>
            @endpush
        @endif
        <div class="flex flex-col">
            <form wire:submit.prevent="resetpw">
                <span class="mb-6 text-lg font-semibold">Reset Password</span>
                <div class="flex flex-col">
                    <label>Password Sekarang</label>
                    <div class="flex items-center">
                        <input id="currentPassword" type="password"  wire:model="currentPassword" class="w-1/4 p-2 border border-gray-500 rounded-lg">
                        <button type="button" onclick="togglePassword('currentPassword', this)" class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </button>
                    </div>

                    <label>Password Baru</label>
                    <div class="flex items-center">
                        <input id="newPassword" type="password" wire:model="newPassword" class="w-1/4 p-2 border border-gray-500 rounded-lg">
                        <button type="button" onclick="togglePassword('newPassword', this)" class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </button>
                    </div>

                    <label>Konfirmasi Password Baru</label>
                    <div class="flex items-center">
                        <input id="confirmPassword" type="password" wire:model="confirmPassword" class="w-1/4 p-2 border border-gray-500 rounded-lg">
                        <button type="button" onclick="togglePassword('confirmPassword', this)" class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button id="submit">Reset Password</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(id, button) {
            const input = document.getElementById(id);
            const eyeIcon = button.querySelector('svg');
            const openEyeIcon = `
                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            `;
            const closedEyeIcon = `
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            `;
            
            if (input.type === "password") {
                input.type = "text";
                eyeIcon.innerHTML = closedEyeIcon; // Ganti dengan ikon mata tertutup
            } else {
                input.type = "password";
                eyeIcon.innerHTML = openEyeIcon; // Kembali ke ikon mata terbuka
            }
        }
    </script>
</div>