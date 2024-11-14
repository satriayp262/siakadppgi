<div class="flex flex-col p-4">
    <div class="w-full">
        <div x-data="{ open: false }" class="flex flex-col">
            <div class="rounded-lg bg-white px-4 py-8 mb-6">
                <span class="mb-6 text-lg font-semibold">
                    Data Mahasiswa
                </span>
                <div class="grid grid-cols-3 gap-6">
                    @foreach (['NIM' => 'NIM', 'NIK' => 'NIK', 'nama' => 'Nama Mahasiswa', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'jenis_kelamin' => 'Jenis Kelamin', 'mulai_semester' => 'Mulai Semester', 'kode_prodi' => 'Prodi', 'agama' => 'Agama', 'alamat' => 'Alamat', 'jalur_pendaftaran' => 'Jalur Pendaftaran', 'kewarganegaraan' => 'Kewarganegaraan', 'jenis_pendaftaran' => 'Jenis Pendaftaran', 'tanggal_masuk_kuliah' => 'Tanggal Masuk Kuliah', 'jenis_tempat_tinggal' => 'Jenis Tempat Tinggal', 'telp_rumah' => 'Telp Rumah', 'no_hp' => 'No HP', 'email' => 'Email', 'terima_kps' => 'Terima KPS', 'no_kps' => 'No KPS', 'jenis_transportasi' => 'Jenis Transportasi', 'kode_pt_asal' => 'Kode PT Asal', 'nama_pt_asal' => 'Nama PT Asal', 'kode_prodi_asal' => 'Kode Prodi Asal', 'nama_prodi_asal' => 'Nama Prodi Asal', 'jenis_pembiayaan' => 'Jenis Pembiayaan', 'jumlah_biaya_masuk' => 'Jumlah Biaya Masuk'] as $field => $label)
                        <div class="flex flex-col mb-2 {{ $loop->index >= 3 ? 'hidden' : '' }} mahasiswa-item">
                            <label for="{{ $field }}"
                                class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <p class="text-sm text-gray-500">
                                @php
                                    $value = match ($field) {
                                        'jenis_kelamin' => $mahasiswa->getJenisKelamin(),
                                        'agama' => $mahasiswa->getAgama(),
                                        'jalur_pendaftaran' => $mahasiswa->getJalurPendaftaran(),
                                        'jenis_pendaftaran' => $mahasiswa->getJenisPendaftaran(),
                                        'jenis_tempat_tinggal' => $mahasiswa->getJenisTempatTinggal(),
                                        'jenis_transportasi' => $mahasiswa->getJenisTransportasi(),
                                        'jenis_pembiayaan' => $mahasiswa->getJenisPembiayaan(),
                                        'mulai_semester' => $mahasiswa->semester->nama_semester,
                                        'terima_kps' => $mahasiswa->terima_kps === '1' ? 'Ya' : 'Tidak',
                                        'jumlah_biaya_masuk' => $mahasiswa->jumlah_biaya_masuk
                                            ? number_format($mahasiswa->jumlah_biaya_masuk, 2, ',', '.')
                                            : 'Data Belum Ada',
                                        'tanggal_masuk_kuliah' => $mahasiswa->tanggal_masuk_kuliah
                                            ? \Carbon\Carbon::parse($mahasiswa->tanggal_masuk_kuliah)->format('d-m-Y')
                                            : 'Data Belum Ada',

                                        default => $mahasiswa->$field ?? 'Data Belum Ada',
                                    };
                                @endphp
                                {{ $value }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <!-- Show More / Show Less button -->
                <button id="toggleButton" class="text-blue-500 mt-4">Show More</button>
            </div>

            <script>
                document.getElementById('toggleButton').addEventListener('click', function() {
                    const hiddenItems = document.querySelectorAll('.mahasiswa-item.hidden');
                    const isHidden = hiddenItems.length > 0;

                    // Toggle visibility of items
                    hiddenItems.forEach(item => item.classList.remove('hidden'));

                    // Change button text depending on the state
                    if (isHidden) {
                        this.textContent = 'Show Less';
                    } else {
                        // Hide the extra items and change button text
                        document.querySelectorAll('.mahasiswa-item').forEach((item, index) => {
                            if (index >= 3) item.classList.add('hidden');
                        });
                        this.textContent = 'Show More';
                    }
                });
            </script>

            <div class="rounded-lg bg-white px-4 py-8 mb-6">
                <h1 class="my-4 text-xl font-bold text-left">Data Orang tua Wali</h1>
                <div class="grid grid-cols-3 gap-6">
                    @php
                        $parentData = [
                            'Nama Ayah' => $mahasiswa->orangtuaWali->nama_ayah ?? 'Data Belum Ada',
                            'Nama Ibu' => $mahasiswa->orangtuaWali->nama_ibu ?? 'Data Belum Ada',
                            'Nama Wali' => $mahasiswa->orangtuaWali->nama_wali ?? 'Data Belum Ada',

                            'NIK Ayah' => $mahasiswa->orangtuaWali->NIK_ayah ?? 'Data Belum Ada',
                            'NIK Ibu' => $mahasiswa->orangtuaWali->NIK_ibu ?? 'Data Belum Ada',
                            'NIK Wali' => $mahasiswa->orangtuaWali->NIK_wali ?? 'Data Belum Ada',

                            'Pendidikan Ayah' =>
                                $mahasiswa->orangtuaWali->pendidikanAyah->nama_pendidikan_terakhir ?? 'Data Belum Ada',
                            'Pendidikan Ibu' =>
                                $mahasiswa->orangtuaWali->pendidikanIbu->nama_pendidikan_terakhir ?? 'Data Belum Ada',
                            'Pendidikan Wali' =>
                                $mahasiswa->orangtuaWali->pendidikanWali->nama_pendidikan_terakhir ?? 'Data Belum Ada',

                            'Pekerjaan Ayah' => $mahasiswa->orangtuaWali->getPekerjaanAyah() ?? 'Data Belum Ada',
                            'Pekerjaan Ibu' => $mahasiswa->orangtuaWali->getPekerjaanIbu() ?? 'Data Belum Ada',
                            'Pekerjaan Wali' => $mahasiswa->orangtuaWali->getPekerjaanWali() ?? 'Data Belum Ada',

                            'Penghasilan Ayah' => $mahasiswa->orangtuaWali->getPenghasilanAyah() ?? 'Data Belum Ada',
                            'Penghasilan Ibu' => $mahasiswa->orangtuaWali->getPenghasilanIbu() ?? 'Data Belum Ada',
                            'Penghasilan Wali' => $mahasiswa->orangtuaWali->getPenghasilanWali() ?? 'Data Belum Ada',
                        ];
                    @endphp
                    @foreach ($parentData as $label => $value)
                        <div class="flex flex-col mb-2 {{ $loop->index >= 3 ? 'hidden' : '' }} parent-item">
                            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <p class="text-sm text-gray-500">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
                <button id="toggleButton2" class="text-blue-500 mt-4">Show More</button>
            </div>
            <script>
                document.getElementById('toggleButton2').addEventListener('click', function() {
                    const hiddenItems = document.querySelectorAll('.parent-item.hidden');
                    const isHidden = hiddenItems.length > 0;

                    // Toggle visibility of items
                    hiddenItems.forEach(item => item.classList.remove('hidden'));

                    // Change button text depending on the state
                    if (isHidden) {
                        this.textContent = 'Show Less';
                    } else {
                        // Hide the extra items and change button text
                        document.querySelectorAll('.parent-item').forEach((item, index) => {
                            if (index >= 3) item.classList.add('hidden');
                        });
                        this.textContent = 'Show More';
                    }
                });
            </script>

        </div>
    </div>
    <div class="flex w-full p-4 bg-white rounded-lg shadow-lg">
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
        <!-- SVG Icon on the right side -->
        <div class="relative w-full h-64 svg-container">
            <svg id="moving-svg" xmlns="http://www.w3.org/2000/svg" class="absolute w-12 h-12" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path
                    d="M18 17h-.09c.058-.33.088-.665.09-1v-1h1a1 1 0 0 0 0-2h-1.09a5.97 5.97 0 0 0-.26-1H17a2 2 0 0 0 2-2V8a1 1 0 1 0-2 0v2h-.54a6.239 6.239 0 0 0-.46-.46V8a3.963 3.963 0 0 0-.986-2.6l.693-.693A1 1 0 0 0 16 4V3a1 1 0 1 0-2 0v.586l-.661.661a3.753 3.753 0 0 0-2.678 0L10 3.586V3a1 1 0 1 0-2 0v1a1 1 0 0 0 .293.707l.693.693A3.963 3.963 0 0 0 8 8v1.54a6.239 6.239 0 0 0-.46.46H7V8a1 1 0 0 0-2 0v2a2 2 0 0 0 2 2h-.65a5.97 5.97 0 0 0-.26 1H5a1 1 0 0 0 0 2h1v1a6 6 0 0 0 .09 1H6a2 2 0 0 0-2 2v2a1 1 0 1 0 2 0v-2h.812A6.012 6.012 0 0 0 11 21.907V12a1 1 0 0 1 2 0v9.907A6.011 6.011 0 0 0 17.188 19H18v2a1 1 0 0 0 2 0v-2a2 2 0 0 0-2-2Zm-4-8.65a5.922 5.922 0 0 0-.941-.251l-.111-.017a5.52 5.52 0 0 0-1.9 0l-.111.017A5.925 5.925 0 0 0 10 8.35V8a2 2 0 1 1 4 0v.35Z" />
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
        let angle = 90; // Initial angle (facing to the right)
        const moveDistance = 100.; // Distance to move in each direction
        const rotationAngle = 90; // Rotation angle after each movement
        const delayTime = 500; // Delay in milliseconds (1 second)

        let sequence = 1

        function moveInSequence() {
            setTimeout(() => {
                if (sequence === 1) {
                    xPos += moveDistance;
                    sequence = 2;
                } else if (sequence === 2) {
                    xPos += moveDistance;
                    sequence = 3;
                } else if (sequence === 3) {
                    xPos += moveDistance;
                    sequence = 4;
                } else if (sequence === 4) {
                    xPos += moveDistance;
                    sequence = 5;
                } else if (sequence === 5) {
                    angle = (angle + rotationAngle) % 360;
                    sequence = 6;
                } else if (sequence === 6) {
                    yPos += moveDistance;
                    sequence = 7;
                } else if (sequence === 7) {
                    yPos += moveDistance;
                    sequence = 8;
                } else if (sequence === 8) {
                    angle = (angle + rotationAngle) % 360;
                    sequence = 9;
                } else if (sequence === 9) {
                    xPos -= moveDistance;
                    sequence = 10;
                } else if (sequence === 10) {
                    xPos -= moveDistance;
                    sequence = 11;
                } else if (sequence === 11) {
                    xPos -= moveDistance;
                    sequence = 12;
                } else if (sequence === 12) {
                    xPos -= moveDistance;
                    sequence = 13;
                } else if (sequence === 13) {
                    angle = (angle + rotationAngle) % 360;
                    sequence = 14
                } else if (sequence === 14) {
                    yPos -= moveDistance;
                    sequence = 15
                } else if (sequence === 15) {
                    yPos -= moveDistance;
                    sequence = 16
                } else if (sequence === 16) {
                    angle = (angle + rotationAngle) % 360;
                    sequence = 1
                }

                // Update the SVG's position and rotation
                svg.style.transform = `translate(${xPos}px, ${yPos}px) rotate(${angle}deg)`;

                // Update the angle for the next movement (rotate 90 degrees clockwise)

                // Continue the sequence
                moveInSequence();
            }, delayTime); // Delay each movement
        }

        moveInSequence();

        // const svg = document.getElementById('moving-svg');
        // const container = document.querySelector('.svg-container');

        // let xPos = 0;
        // let yPos = 0;
        // let angle = Math.random() * 90; // Direction

        // function moveForward() {
        //     const speed = 5; // Speed
        //     const angleChange = (Math.random() - 0.5) * 0.1; // Change direction

        //     angle += angleChange;
        //     xPos += Math.cos(angle) * speed;
        //     yPos += Math.sin(angle) * speed;

        //     // Container
        //     if (xPos < 0 || xPos + svg.clientWidth > container.clientWidth) {
        //         angle = 30 - angle; // Reflect direction horizontally
        //     }

        //     if (yPos < 0 || yPos + svg.clientHeight > container.clientHeight) {
        //         angle = -angle; // Reflect direction vertically
        //     }

        //     // Apply movement and rotation
        //     svg.style.transform = translate(${xPos}px, ${yPos}px) rotate(${angle}deg);

        //     requestAnimationFrame(moveForward); // Continue the animation
        // }
    </script>

    <style>
        .svg-container {
            position: relative;
            height: 200px;
            border: 1px transparent #ccc;
        }

        #moving-svg {
            transition: transform 0.1s linear;
            /* Smooth transition for movement */
        }
    </style>
</div>
