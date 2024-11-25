<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <!-- Modal Form -->
        <div class="flex justify-end mt-2">
            {{-- <livewire:dosen.presensi.create-token /> --}}
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 py-2 border border-gray-300 rounded-lg">
        </div>
        <div>
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
                    class="flex items-center justify-between p-2 mx-2 mt-2 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1"
                        onclick="document.getElementById('flash-message').style.display='none'">&times;</button>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Kode Mata Kuliah</th>
                    <th class="px-4 py-2 text-center">Mata Kuliah</th>
                    <th class="px-4 py-2 text-center">Nama Dosen</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($beritaAcaraByMatkul as $index => $mataKuliah)
                    <tr class="text-center border-b border-gray-200">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $mataKuliah->kode_mata_kuliah }}</td>
                        <td class="px-4 py-2">{{ $mataKuliah->nama_mata_kuliah }}</td>
                        <td class="px-4 py-2">{{ $mataKuliah->dosen->nama_dosen }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('dosen.berita_acara.detail_matkul', ['id_mata_kuliah' => $mataKuliah->id_mata_kuliah]) }}"
                                class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                 Detail
                             </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">Tidak ada data mata kuliah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">
            {{ $beritaAcaraByMatkul->links() }}
        </div>
    </div>

    <script>
        function confirmDelete(id_berita_acara) {
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus Berita Acara ini?',
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id_berita_acara);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const events = ['updated', 'created', 'destroyed'];
            events.forEach(eventType => {
                window.addEventListener(eventType, event => {
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
        });
    </script>

</div>
