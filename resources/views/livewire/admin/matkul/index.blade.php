<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-2">
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
                    class="flex items-center justify-between p-4 mx-12 mt-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();">&times;</button>
                </div>
            @endif
        </div>
        <div>
            @if (session()->has('message2'))
                @php
                    $messageType2 = session('message_type2', 'success'); // Default to success for message2
                    $bgColor2 =
                        $messageType2 === 'error'
                            ? 'bg-red-500'
                            : ($messageType2 === 'warning'
                                ? 'bg-yellow-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message2"
                    class="flex items-center justify-between p-4 mx-12 mt-4 mb-4 text-white {{ $bgColor2 }} rounded">
                    <span>{!! session('message2') !!}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message2').remove();">&times;</button>
                </div>
            @endif
        </div>

        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.matkul.create />
                <livewire:admin.matkul.import />
                <button wire:click="downloadTemplate"
                    class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700">
                    Unduh Template Excel
                </button>
                <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                    onclick="confirmDeleteSelected()">
                    Hapus Data Terpilih
                </button>
            </div>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="py-2 px-4"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
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
                    <td class="px-4 py-2 text-center">
                        <input type="checkbox" class="selectRow" wire:model="selectedMatkul"
                            value="{{ $matkul->id_mata_kuliah }}">
                    </td>
                    <td class="px-4 py-2 text-center">{{ ++$iteration }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->kode_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->nama_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->jenis_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->prodi->nama_prodi ?? 'Umum' }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->metode_pembelajaran }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-row">
                            <div class="flex justify-center space-x-2">
                                <livewire:admin.matkul.selengkapnya :id_mata_kuliah="$matkul->id_mata_kuliah"
                                    wire:key="selengkapnya-{{ rand() . $matkul->id_mata_kuliah }}" />
                                <livewire:admin.matkul.edit :id_mata_kuliah="$matkul->id_mata_kuliah"
                                    wire:key="edit-{{ $matkul->id_mata_kuliah }}" />
                                <button
                                    class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete({{ $matkul->id_mata_kuliah }}, '{{ $matkul->nama_mata_kuliah }}')">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="mt-4 mb-4 text-center">
        {{ $matkuls->links('') }}
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

        // Ambil elemen checkbox di header
        const selectAllCheckbox = document.getElementById('selectAll');

        // Ambil semua checkbox di baris
        const rowCheckboxes = document.querySelectorAll('.selectRow');

        // Event listener untuk checkbox di header
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;

            // Iterasi semua checkbox di row dan ubah status checked sesuai header
            rowCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked; // Update status checkbox di baris
            });

            // Jika Anda menggunakan Livewire, Anda bisa memanggil update pada model
            @this.set('selectedMatkul', isChecked ? [...rowCheckboxes].map(cb => cb.value) : []);
        });


        function confirmDeleteSelected() {
            const selectedMatkul = @this.selectedMatkul; // Dapatkan data dari Livewire

            console.log(selectedMatkul); // Tambahkan log untuk memeriksa nilai

            if (selectedMatkul.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada data yang dipilih!',
                    text: 'Silakan pilih data yang ingin dihapus terlebih dahulu.',
                });
                return;
            }

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${selectedMatkul.length} data mata kuliah?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil method Livewire untuk menghapus data terpilih
                    @this.call('destroySelected');
                }
            });
        }
    </script>
</div>
