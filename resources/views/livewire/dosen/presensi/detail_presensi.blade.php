<div class="mx-5">

    <div class="flex flex-row justify-between mx-4 mt-4 items-center">
        <button type="button" onclick="window.history.back()"
            class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">
            Kembali
        </button>
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
