<div class="mx-5">

    <div class="flex flex-row justify-between mx-4 mt-4 items-center">
        <div class="flex flex-row space-x-1">
            <button type="button" onclick="window.history.back()"
                class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                Kembali
            </button>
            <button wire:click="exportExcel"
                class="flex items-center py-2 pr-4 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 48 48">
                    <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path>
                    <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z">
                    </path>
                    <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path>
                    <path fill="#17472a" d="M14 24.005H29V33.055H14z"></path>
                    <g>
                        <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"></path>
                        <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z"><path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"></path>
                        <path fill="#129652" d="M29 24.005H44V33.055H29z"></path>
                    </g>
                    <path fill="#0c7238"
                        d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                    </path>
                    <path fill="#fff"
                        d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                    </path>
                </svg>
                Export
            </button>
        </div>
        <input type="text" wire:model.live="search" placeholder="   Search"
            class="px-2 py-2 ml-4 border border-gray-300 rounded-lg">
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
    <table class="min-w-full mt-4 bg-white text-sm">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                <th class="px-4 py-2 text-center">NIM</th>
                <th class="px-4 py-2 text-center">Waktu</th>
                <th class="px-4 py-2 text-center">Keterangan</th>
                <th class="px-4 py-2 text-center">Alasan</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($mahasiswaPresensi->isEmpty())
                <tr>
                    <td colspan="5" class="px-2 py-4 text-center">Tidak ada data</td>
                </tr>
            @endif
            @foreach ($mahasiswaPresensi as $key => $item)
                <tr class="border-t" wire:key="mahasiswa-{{ $item['id_presensi'] }}">
                    <td class="px-2 py-2 text-center">{{ $key + 1 }}</td>
                    <td class="px-2 py-2 text-center">{{ $item['nama'] }}</td>
                    <td class="px-2 py-2 text-center">{{ $item['nim'] }}</td>
                    <td class="px-2 py-2 text-center">
                        {{ $item['waktu_submit'] ? \Carbon\Carbon::parse($item['waktu_submit'])->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="px-2 py-2 text-center">{{ $item['keterangan'] }}</td>
                    <td class="px-2 py-2 text-center">{{ $item['alasan'] ?? '-' }}</td>
                    <td class="px-2 py-2 text-center">
                        <livewire:dosen.presensi.edit :nim="$item['nim']" :id_presensi="$item['id_presensi']"
                            wire:key="'edit-' . $item['id_presensi']" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('updated', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Dispatch the modal-closed event to close the modal
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
