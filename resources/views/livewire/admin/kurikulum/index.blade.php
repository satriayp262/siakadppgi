<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-2">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.kurikulum.create />
                @if ($showDeleteButton)
                    <button id="deleteButton" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                        onclick="confirmDeleteSelected()">
                        Hapus Data Terpilih
                    </button>
                @endif
            </div>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="py-2 px-4"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
                    <th class="px-4 py-2 text-center">Nama Kurikulum</th>
                    <th class="px-4 py-2 text-center">Mulai Berlaku</th>
                    <th class="px-4 py-2 text-center">Jumlah SKS Lulus</th>
                    <th class="px-4 py-2 text-center">Jumlah SKS Wajib</th>
                    <th class="px-4 py-2 text-center">Jumlah SKS Pilihan</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kurikulums as $kurikulum)
                    <tr class="border-t" wire:key="kurikulum-{{ $kurikulum->id_kurikulum }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" class="selectRow" wire:model.live="selectedKurikulum"
                                value="{{ $kurikulum->id_kurikulum }}">
                        </td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->nama_kurikulum }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->semester->nama_semester }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->jumlah_sks_lulus }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->jumlah_sks_wajib }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->jumlah_sks_pilihan }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->prodi->nama_prodi }}</td>
                        <td class="px-4 py-2 text-center w-1/4">
                            <div class="flex justify-center space-x-2">
                                <livewire:admin.kurikulum.edit :id_kurikulum="$kurikulum->id_kurikulum"
                                    wire:key="edit-{{ rand() . $kurikulum->id_kurikulum }}" />
                                <button class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $kurikulum->id_kurikulum }}', '{{ $kurikulum->nama_kurikulum }}')"><svg
                                        class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 mb-4 text-center">
            {{-- {{ $prodis->links('') }} --}}
        </div>
    </div>

    <script>
        function confirmDelete(id_kurikulum, nama_kurikulum) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus kurikulum ${nama_kurikulum}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id_kurikulum);
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
            @this.set('selectedKurikulum', isChecked ? [...rowCheckboxes].map(cb => cb.value) : []);
        });


        function confirmDeleteSelected() {
            const selectedKurikulum = @this.selectedKurikulum; // Dapatkan data dari Livewire

            console.log(selectedKurikulum); // Tambahkan log untuk memeriksa nilai

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${selectedKurikulum.length} data Kurikulum?`,
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
