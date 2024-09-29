<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
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
                    }, 1000); // Adjust the time (in milliseconds) as needed
                </script>
            @endpush
        @endif
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:admin.matkul.create />
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Kode Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Nama Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Jenis Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Prodi</th>
                <th class="px-4 py-2 text-center">Metode Pembelajaran</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $iteration = ($matkuls->currentPage() - 1) * $matkuls->perPage();
            @endphp

            @foreach ($matkuls as $matkul)
                <tr class="border-t" wire:key="matkul-{{ $matkul->id_mata_kuliah }}">
                    <td class="px-4 py-2 text-center">{{ ++$iteration }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->kode_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->nama_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->jenis_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->prodi->nama_prodi ?? 'Umum' }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->metode_pembelajaran }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex items-center">
                            <div class="flex space-x-2">
                                <livewire:admin.matkul.edit :id_mata_kuliah="$matkul->id_mata_kuliah"
                                    wire:key="edit-{{ rand() . $matkul->id_mata_kuliah }}" />
                                <button
                                    class="inline-block px-3 py-1 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete({{ $matkul->id_mata_kuliah }}, '{{ $matkul->nama_mata_kuliah }}')">Delete</button>
                            </div>
                            <div class="flex mt-2 space-x-2">
                                <livewire:admin.matkul.selengkapnya :id_mata_kuliah="$matkul->id_mata_kuliah"
                                    wire:key="selengkapnya-{{ rand() . $matkul->id_mata_kuliah }}" />
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="mt-4 text-center">
        {{ $matkuls->links('pagination::tailwind') }}
    </div>
    <script>
        function confirmDelete(id, nama_mata_kuliah) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Mata Kuliah ${nama_mata_kuliah}?`,
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
