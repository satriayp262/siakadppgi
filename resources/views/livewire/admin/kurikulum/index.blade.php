<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-2">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                {{-- <livewire:admin.semester.create /> --}}
                <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                    onclick="confirmDeleteSelected()">
                    Hapus Data Terpilih
                </button>
            </div>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success'); // Default to success
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : (($messageType === 'warning'
                                    ? 'bg-yellow-500'
                                    : $messageType === 'update')
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-2 mx-2 mt-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>

                </div>
            @endif
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
                </tr>
            </thead>
            <tbody>
                @foreach ($kurikulums as $kurikulum)
                    <tr class="border-t" wire:key="kurikulum-{{ $kurikulum->id_kurikulum }}">
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->nama_kurikulum }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->semester->nama_semester }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->jumlah_sks_lulus }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->jumlah_sks_wajib }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->jumlah_sks_pilihan }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $kurikulum->prodi->nama_prodi }}</td>
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
        function confirmDelete(id, nama_kurikulum) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Semester ${nama}?`,
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

        function confirmActive(id) {
            Swal.fire({
                title: `Apakah anda yakin ingin mengaktifkan Semester ini?`,
                text: "Semester yang telah diaktifkan tidak dapat dikembalikan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6f42c1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Aktifkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('active', id);
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
            @this.set('selectedSemester', isChecked ? [...rowCheckboxes].map(cb => cb.value) : []);
        });


        function confirmDeleteSelected() {
            const selectedSemester = @this.selectedSemester; // Dapatkan data dari Livewire

            console.log(selectedSemester); // Tambahkan log untuk memeriksa nilai

            if (selectedSemester.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada data yang dipilih!',
                    text: 'Silakan pilih data yang ingin dihapus terlebih dahulu.',
                });
                return;
            }

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${selectedSemester.length} data Semester?`,
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
