<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        {{-- <h1 class="text-2xl font-bold ">Prodi Table</h1> --}}
        <h1>Semester saat ini:
            {{ $semesters->firstWhere('is_active', true)->nama_semester ?? 'Tidak ada semester aktif' }}</h1>
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
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>

                </div>
            @endif
        </div>

        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.semester.create />
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
                <th class="px-4 py-2 text-center">Nama Semester</th>
                <th class="px-4 py-2 text-center">Semester Aktif</th>
                <th class="px-4 py-2 text-center">Aksi</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($semesters as $semester)
                <tr class="border-t" wire:key="semester-{{ $semester->id_semester }}">
                    <td class="px-4 py-2 text-center">
                        <input type="checkbox" class="selectRow" wire:model="selectedSemester"
                            value="{{ $semester->id_semester }}">
                    </td>
                    <td class="px-4 py-2 text-center w-1/4">{{ $semester->nama_semester }}</td>
                    <td class="px-4 py-2 text-center w-1/4">
                        @php
                            $activedsemester = [
                                '1' => 'bg-blue-400 ',
                                '0' => 'bg-red-400',
                            ];
                            $is_active = $activedsemester[$semester->is_active] ?? 'bg-gray-500';
                        @endphp
                        <span class="px-2.5  me-2 p-0.5 rounded-full text-xs text-white  {{ $is_active }}"
                            style="width: 80px;">
                            {{ $semester->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center w-1/2">
                        <div class="flex justify-center space-x-2">
                            {{-- <livewire:admin.semester.edit :id_semester="$semester->id_semester" wire:key="edit-{{ $semester->id_semester }}" /> --}}
                            @if (!$semester->is_active)
                                <button
                                    class="inline-block px-4 py-1 text-white bg-green-500 rounded hover:bg-green-700"
                                    onclick="confirmActive({{ $semester->id_semester }})">
                                    Aktifkan Semester
                                </button>
                            @endif

                            {{-- <button class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                onclick="confirmDelete('{{ $semester->id_semester }}', '{{ $semester->nama_semester }}')"><svg
                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button> --}}
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

    <script>
        function confirmDelete(id, nama_semester) {
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
                confirmButtonColor: '#d33',
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
