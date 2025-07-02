<div class="mx-5">
    <div class="flex flex-row justify-between mx-4 mt-4 items-center">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <a wire:navigate.hover href="{{ route('dosen.presensi') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
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
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
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
        <div class="flex justify-between items-center space-x-2 mt-2">
            <livewire:dosen.presensi.create-token :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
            <a href="{{ route('dosen.rekap_presensi', ['id_mata_kuliah' => $id_mata_kuliah, 'id_kelas' => $id_kelas]) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Rekap
            </a>
        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
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

        document.addEventListener('DOMContentLoaded', function() {
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
                    console.log(`Livewire event [${eventType}] received:`, data);

                    const message = (Array.isArray(data) && data[0]?.message) || data?.message ||
                        'Terjadi kesalahan.';

                    Swal.fire({
                        title: config.title,
                        text: message,
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
