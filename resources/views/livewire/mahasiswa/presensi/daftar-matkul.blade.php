<div class="mx-5">
    <div class="flex flex-col justify-between mt-4 ">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Presensi</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </div>
                    </li>
                </ol>
            </nav>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 py-2 border border-gray-300 rounded-lg">
        </div>
    </div>

    @forelse ($matkuls as $index => $mataKuliah)
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <div class="flex flex-row justify-between items-center">
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-purple2">
                        {{ $mataKuliah->nama_mata_kuliah }}
                        @if (!empty($mataKuliah->grup))
                            - Grup {{ $mataKuliah->grup }}
                        @endif
                    </span>

                    <span class="text-sm font-bold text-gray-400">Kode Mata Kuliah :
                        {{ $mataKuliah->kode_mata_kuliah }}</span>
                    <div class="flex space-x-2">
                        <span>{{ $mataKuliah->jam_mulai }}</span>
                        <span>-</span>
                        <span>{{ $mataKuliah->jam_selesai }}</span>
                    </div>
                </div>
                <div class="flex justify-center">
                    @php
                        $isDisabled = \Carbon\Carbon::parse($mataKuliah->jam_selesai)->lt(
                            \Carbon\Carbon::now('Asia/Jakarta'),
                        );
                    @endphp


                    <div class="flex justify-center">
                        <livewire:mahasiswa.presensi :id_mata_kuliah="$mataKuliah->id_mata_kuliah" :isDisabled="$isDisabled"
                            :wire:key="'presensi-' . rand() . '-' . $mataKuliah->id_mata_kuliah" />
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white text-center font-bold mx-4 my-4 rounded-lg p-4">
            <span>Tidak ada jadwal hari ini.</span>
        </div>
    @endforelse
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('error', function(eventData) {
            Swal.fire({
                icon: 'error',
                title: eventData.message,
                text: 'Terjadi kesalahan saat proses presensi.',
                confirmButtonText: 'OK'
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('created', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
