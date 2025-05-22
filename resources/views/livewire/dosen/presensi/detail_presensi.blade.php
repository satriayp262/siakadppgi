<div class="mx-5">
    <div class="flex flex-row justify-between mx-4 mt-4 items-center">
        <div class="flex flex-row space-x-4">
            <button type="button" onclick="window.history.back()"
                class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                Kembali
            </button>

            <button wire:click="exportExcel"
                    wire:loading.attr="disabled"
                    wire:loading.class="bg-gray-400"
                    class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path>
                    <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z"></path>
                    <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path>
                    <path fill="#17472a" d="M14 24.005H29V33.055H14z"></path>
                    <g>
                        <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"></path>
                        <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z">
                        <path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"></path>
                        <path fill="#129652" d="M29 24.005H44V33.055H29z"></path>
                    </g>
                    <path fill="#0c7238" d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z"></path>
                    <path fill="#fff" d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z"></path>
                </svg>
                <span wire:loading wire:target="exportExcel">Menyiapkan...</span>
                <span wire:loading.remove wire:target="exportExcel">Export Excel</span>
            </button>
        </div>

        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari mahasiswa..."
                   class="px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full overflow-x-auto">
        <table class="min-w-full mt-4 bg-white text-sm">
            <thead>
                <tr class="bg-customPurple text-white">
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3 text-center">Nama Mahasiswa</th>
                    <th class="px-4 py-3 text-center">NIM</th>
                    <th class="px-4 py-3 text-center">Waktu Presensi</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Keterangan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswaPresensi as $index => $item)
                    <tr class="border-t hover:bg-gray-50" wire:key="mahasiswa-{{ $item['nim'] }}-{{ $index }}">
                        <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-center">{{ $item['nama'] }}</td>
                        <td class="px-4 py-3 text-center">{{ $item['nim'] }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($item['waktu_submit'])
                                {{ \Carbon\Carbon::parse($item['waktu_submit'])->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $item['keterangan'] === 'Hadir' ? 'bg-green-100 text-green-800' :
                                   ($item['keterangan'] === 'Izin' ? 'bg-yellow-100 text-yellow-800' : $item['keterangan'] === 'Sakit' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-red-100 text-red-800') }}">
                                {{ $item['keterangan'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $item['alasan'] ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <livewire:dosen.presensi.edit
                                :nim="$item['nim']"
                                :id_presensi="$item['id_presensi']"
                                :key="'edit-'.$item['nim']" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada data mahasiswa yang ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('updated', (event) => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });

        Livewire.on('error', (message) => {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
</script>
@endpush
