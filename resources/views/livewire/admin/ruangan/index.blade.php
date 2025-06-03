<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between mt-2">
            <div class="flex justify-around space-x-2">
                <livewire:admin.ruangan.create />
                @if ($showDeleteButton)
                    <button id="deleteButton" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                        onclick="confirmDeleteSelected()">
                        Hapus Data Terpilih
                    </button>
                @endif
            </div>
        </div>

        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success');
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

    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <livewire:table.ruangan-table />
        {{-- <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Kode Ruangan</th>
                    <th class="px-4 py-2 text-center">Nama Ruangan</th>
                    <th class="px-4 py-2 text-center">kapasitas</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ruangans as $ruangan)
                    <tr class="border-t" wire:key="ruangan-{{ $ruangan->id_ruangan }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" class="selectRow" wire:model="selectedMahasiswa"
                                value="{{ $ruangan->id_ruangan }}">
                        </td>
                        <td class="px-4 py-2 text-center">
                            {{ ($ruangans->currentPage() - 1) * $ruangans->perPage() + $loop->iteration }}</td>
                        <td class="w-1/4 px-4 py-2 text-center">{{ $ruangan->kode_ruangan }}</td>
                        <td class="w-1/4 px-4 py-2 text-center">{{ $ruangan->nama_ruangan }}</td>
                        <td class="w-1/4 px-4 py-2 text-center">{{ $ruangan->kapasitas }}</td>
                        <td class="w-full max-w-2xl px-4 py-2 mx-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <livewire:admin.ruangan.edit :id_ruangan="$ruangan->id_ruangan"
                                    wire:key="edit-{{ $ruangan->id_ruangan }}" />
                                <button class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $ruangan->id_ruangan }}', '{{ $ruangan->nama_ruangan }}')"><svg
                                        class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
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
            {{ $ruangans->links() }}
        </div> --}}
    </div>

    <script>
        function confirmDelete(id, nama_ruangan) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ruangan ${nama_ruangan}?`,
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

            @this.set('selectedRuangan', isChecked ? [...rowCheckboxes].map(cb => cb.value) : []);
        });

        rowCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                @this.set('selectedRuangan', [...rowCheckboxes].filter(cb => cb.checked).map(cb => cb
                    .value));
            });
        });


        function confirmDeleteSelected() {
            const selectedRuangan = @this.selectedRuangan;

            // console.log(selectedRuangan);

            if (selectedRuangan.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada data yang dipilih!',
                    text: 'Silakan pilih data yang ingin dihapus terlebih dahulu.',
                });
                return;
            }

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${selectedRuangan.length} data Ruangan?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroySelected');
                }
            });
        }
    </script>
</div>
