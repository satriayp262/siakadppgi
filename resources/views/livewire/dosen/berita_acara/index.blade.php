<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <div>
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
                    <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:dosen.berita-acara.create />
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Tanggal</th>
                <th class="px-4 py-2 text-center">Nama Dosen</th>
                <th class="px-4 py-2 text-center">Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Materi</th>
                <th class="px-4 py-2 text-center">Jumlah Mahasiswa</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($beritaAcaras as $acara)
                <tr wire:key="berita_acara-{{ $acara->id_berita_acara }}">
                    <td class="px-4 py-2 text-center">{{ ($beritaAcaras->currentPage() - 1) * $beritaAcaras->perPage() + $loop->iteration }}</td>
                    <td class="px-4 py-2 text-center">{{ $acara->tanggal }}</td>
                    <td class="px-4 py-2 text-center">{{ $acara->dosen->nidn }}</td>
                    <td class="px-4 py-2 text-center">{{ $acara->matakuliah->kode_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $acara->materi }}</td>
                    <td class="px-4 py-2 text-center">{{ $acara->jumlah_mahasiswa }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="flex space-x-2">
                                <livewire:dosen.berita-acara.edit :id_berita_acara="$acara->id_berita_acara"
                                    wire:key="edit-{{ rand() . $acara->id_berita_acara }}" />
                            </div>
                            <button wire:key="delete-{{ $acara->id_berita_acara }}"
                                class="inline-block px-3 py-1 mt-2 text-white bg-red-500 rounded hover:bg-red-700"
                                onclick="confirmDelete({{ $acara->id_berita_acara }}, '{{ $acara->tanggal }}')">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{ $beritaAcaras->links() }}
    </div>

    <script>
        function confirmDelete(id, tanggal) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Berita Acara ${tanggal}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil method Livewire jika konfirmasi diterima
                    @this.call('destroy', id);
                }
            });
        }
    </script>
</div>
