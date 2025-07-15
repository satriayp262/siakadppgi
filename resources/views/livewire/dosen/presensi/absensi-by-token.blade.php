<div class="mx-5">
    <div class="flex flex-row items-center justify-between mx-4 mt-4">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <a wire:navigate.hover href="{{ route('dosen.presensi') }}"
                        class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                        E-Presensi
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a wire:navigate.hover
                            href="{{ route('dosen.presensiByKelas', ['id_mata_kuliah' => $matkul->id_mata_kuliah]) }}"
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                            {{ $matkul->nama_mata_kuliah }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $kelas->nama_kelas }} /
                            {{ $kelas->kode_prodi }} /
                            {{ substr($kelas->Semester->nama_semester, 3, 2) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex items-center justify-between mt-2 space-x-2">
            @php
                use Carbon\Carbon;

                $sekarang = Carbon::now('Asia/Jakarta');
                $disabled = true;

                if ($jadwal) {
                    $hariIni = $sekarang->translatedFormat('l'); // "Senin", "Selasa", dst
                    $jamMulai = Carbon::createFromFormat('H:i:s', $jadwal->jam_mulai);
                    $jamSelesai = Carbon::createFromFormat('H:i:s', $jadwal->jam_selesai);

                    if (
                        strtolower($jadwal->hari) === strtolower($hariIni) &&
                        $sekarang->between($jamMulai, $jamSelesai)
                    ) {
                        $disabled = false;
                    }
                }
            @endphp

            @if (!$disabled)
                {{-- Komponen Livewire aktif hanya jika jadwal dan waktu sesuai --}}
                <livewire:dosen.presensi.create-token :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
            @else
                {{-- Tombol dummy jika tidak boleh membuat token --}}
                <button disabled class="px-4 py-2 text-white bg-gray-400 rounded cursor-not-allowed opacity-70">
                    Buat Token
                </button>
            @endif

            <a href="{{ route('dosen.rekap_presensi', ['id_mata_kuliah' => $id_mata_kuliah, 'id_kelas' => $id_kelas]) }}"
                class="px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600">
                Rekap
            </a>
        </div>
    </div>

    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <livewire:table.token-table :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
    </div>

    <script>
        function copyToken(token) {
            navigator.clipboard.writeText(token).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Token berhasil disalin!',
                    text: 'Token: ' + token,
                    showConfirmButton: false,
                    timer: 2000
                });
            }, function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyalin token',
                    text: 'Terjadi kesalahan saat menyalin token.',
                    showConfirmButton: true
                });
                console.error('Error copying text: ', err);
            });
        }

        document.addEventListener('livewire:navigated', function() {
            const eventMap = {
                createdTokenSuccess: {
                    title: 'Sukses!',
                    icon: 'success',
                    button: 'OK'
                },
                createdTokenFailed: {
                    title: 'Gagal!',
                    icon: 'error',
                    button: 'OK'
                },
                created: {
                    title: 'Berhasil!',
                    icon: 'success',
                    button: 'OK'
                }
            };

            Object.entries(eventMap).forEach(([eventType, config]) => {
                Livewire.on(eventType, (data) => {
                    console.log(`Livewire event [${eventType}] received:`, data.params.message);
                    const message = (Array.isArray(data) && data[0]?.message) || data?.message;

                    Swal.fire({
                        title: config.title,
                        text: data.params.message,
                        icon: config.icon,
                        confirmButtonText: config.button
                    }).then(() => {
                        window.dispatchEvent(new CustomEvent('modal-closed'));
                    });
                });
            });
        });
    </script>

</div>
