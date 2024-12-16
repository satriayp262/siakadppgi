<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        {{-- <h1 class="text-2xl font-bold ">Prodi Table</h1> --}}
        <!-- Modal Form -->
        <div class="flex justify-end mt-2 space-x-4">
            <h1>Dosen : <span class="text-xl font-bold text-purple2">{{ $kelas->matkul->dosen->nama_dosen }}</span></h1>
            <h1>Kelas : <span class="text-xl font-bold text-purple2">{{ $kelas->nama_kelas }}</span></h1>
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Kode Prodi</th>
                    <th class="px-4 py-2 text-center">Nama Prodi</th>
                    <th class="px-4 py-2 text-center">Jenjang</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($prodis as $prodi)
                    <tr class="border-t" wire:key="prodi-{{ $prodi->id_prodi }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" class="selectRow" wire:model="selectedProdi"
                                value="{{ $prodi->id_prodi }}">
                        </td>
                        <td class="px-4 py-2 text-center">
                            {{ ($prodis->currentPage() - 1) * $prodis->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $prodi->kode_prodi }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $prodi->nama_prodi }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $prodi->jenjang }}</td>
                        <td class="px-4 py-2 text-center w-1/2">
                            <div class="flex justify-center space-x-2">
                                <livewire:admin.prodi.edit :id_prodi="$prodi->id_prodi" wire:key="edit-{{ $prodi->id_prodi }}" />
                                <button class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $prodi->id_prodi }}', '{{ $prodi->nama_prodi }}')"><svg
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
                @endforeach --}}
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 mb-4 text-center">
            {{-- {{ $prodis->links('') }} --}}
        </div>
    </div>

    {{-- <script>
        function confirmDelete(id, nama_prodi) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Prodi ${nama_prodi}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id);
                }
            });
        }
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.selectRow');

        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;

            rowCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });

            @this.set('selectedProdi', isChecked ? [...rowCheckboxes].map(cb => cb.value) : []);
        });

        rowCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                @this.set('selectedProdi', [...rowCheckboxes].filter(cb => cb.checked).map(cb => cb.value));
            });
        });


        function confirmDeleteSelected() {
            const selectedProdi = @this.selectedProdi; // Dapatkan data dari Livewire

            console.log(selectedProdi); // Tambahkan log untuk memeriksa nilai

            if (selectedProdi.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada data yang dipilih!',
                    text: 'Silakan pilih data yang ingin dihapus terlebih dahulu.',
                });
                return;
            }

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${selectedProdi.length} data Prodi?`,
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
    </script> --}}
</div>
