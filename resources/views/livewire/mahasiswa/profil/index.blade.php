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
    <div class="flex w-full p-4 border border-gray-500 rounded-lg">
        <!-- Form on the left side -->
        <div class="flex flex-col w-full">
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
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();" class="font-bold text-white">
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
            <form wire:submit.prevent="resetpw">
                <span class="mb-6 text-lg font-semibold">Reset Password</span>
                <div class="flex flex-col">
                    <label>Password Lama</label>
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
                <button id="submit" class="px-4 py-2 mt-6 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    Reset Password
                </button>
            </form>
        </div>
         <!-- SVG Icon on the right side -->
        <div class="relative w-full h-64 svg-container">
            <svg id="moving-svg" xmlns="http://www.w3.org/2000/svg" class="absolute w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M18 17h-.09c.058-.33.088-.665.09-1v-1h1a1 1 0 0 0 0-2h-1.09a5.97 5.97 0 0 0-.26-1H17a2 2 0 0 0 2-2V8a1 1 0 1 0-2 0v2h-.54a6.239 6.239 0 0 0-.46-.46V8a3.963 3.963 0 0 0-.986-2.6l.693-.693A1 1 0 0 0 16 4V3a1 1 0 1 0-2 0v.586l-.661.661a3.753 3.753 0 0 0-2.678 0L10 3.586V3a1 1 0 1 0-2 0v1a1 1 0 0 0 .293.707l.693.693A3.963 3.963 0 0 0 8 8v1.54a6.239 6.239 0 0 0-.46.46H7V8a1 1 0 0 0-2 0v2a2 2 0 0 0 2 2h-.65a5.97 5.97 0 0 0-.26 1H5a1 1 0 0 0 0 2h1v1a6 6 0 0 0 .09 1H6a2 2 0 0 0-2 2v2a1 1 0 1 0 2 0v-2h.812A6.012 6.012 0 0 0 11 21.907V12a1 1 0 0 1 2 0v9.907A6.011 6.011 0 0 0 17.188 19H18v2a1 1 0 0 0 2 0v-2a2 2 0 0 0-2-2Zm-4-8.65a5.922 5.922 0 0 0-.941-.251l-.111-.017a5.52 5.52 0 0 0-1.9 0l-.111.017A5.925 5.925 0 0 0 10 8.35V8a2 2 0 1 1 4 0v.35Z"/>
            </svg>
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

        
        const svg = document.getElementById('moving-svg');
        const container = document.querySelector('.svg-container');

        let xPos = 0;
        let yPos = 0;
        let angle = Math.random() * 90; // Initial random direction

        function moveForward() {
            const speed = 2; // Speed of movement
            const angleChange = (Math.random() - 0.5) * 0.1; // Slight angle adjustment over time

            angle += angleChange; // Change direction slightly
            xPos += Math.cos(angle) * speed;
            yPos += Math.sin(angle) * speed;

            // Keep within bounds of the container
            if (xPos < 0 || xPos + svg.clientWidth > container.clientWidth) {
                angle = 30 - angle; // Reflect direction horizontally
            }

            if (yPos < 0 || yPos + svg.clientHeight > container.clientHeight) {
                angle = -angle; // Reflect direction vertically
            }

            // Apply movement and rotation
            svg.style.transform = `translate(${xPos}px, ${yPos}px) rotate(${angle}deg)`;

            requestAnimationFrame(moveForward); // Continue the animation
        }

        requestAnimationFrame(moveForward);
    </script>

    <style>
        .svg-container {
            position: relative;
            height: 200px;
            border: 1px transparent #ccc;
        }
        
        #moving-svg {
            transition: transform 0.1s linear; /* Smooth transition for movement */
        }
    </style>
</div>