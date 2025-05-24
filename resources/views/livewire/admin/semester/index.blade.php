<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-2">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.semester.create />
                @if ($showDeleteButton)
                    <button id="deleteButton" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                        onclick="confirmDeleteSelected()">
                        Hapus Data Terpilih
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        @livewire('table.semester-table')
        {{-- <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="py-2 px-4"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
                    <th class="px-4 py-2 text-center">Nama Semester</th>
                    <th class="px-4 py-2 text-center">Status</th>
                    <th class="px-4 py-2 text-center">Bulan Mulai</th>
                    <th class="px-4 py-2 text-center">Bulan Selesai </th>
                    <th class="px-4 py-2 text-center">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($semesters as $semester)
                    <tr class="border-t" wire:key="semester-{{ $semester->id_semester }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" class="selectRow" wire:model.live="selectedSemester"
                                value="{{ $semester->id_semester }}">
                        </td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $semester->nama_semester }}</td>
                        <td class="px-4 py-2 text-center w-1/4">
                            @php
                                $activedsemester = [
                                    '1' => 'bg-violet-400 ',
                                    '0' => 'bg-red-400',
                                ];
                                $is_active = $activedsemester[$semester->is_active] ?? 'bg-gray-500';
                            @endphp
                            <span class="px-2.5  me-2 p-0.5 rounded-full text-xs text-white  {{ $is_active }}"
                                style="width: 80px;">
                                {{ $semester->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $semester->bulan_mulai }}</td>
                        <td class="px-4 py-2 text-center w-1/4">{{ $semester->bulan_selesai }}</td>
                        <td class="px-4 py-2 text-center w-full max-w-2xl">
                            <div class="flex justify-center space-x-2">

                                @if (!$semester->is_active)
                                    <button
                                        class="inline-block px-4 py-1 text-white bg-green-500 rounded hover:bg-green-700"
                                        onclick="confirmActive({{ $semester->id_semester }})">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>

                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
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
                confirmButtonColor: '#6f42c1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Aktifkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('active', id);
                }
            });
        }

        window.addEventListener('bulkDelete.alert.semester-table-4jkmt3-table', (event) => {
            const ids = event.detail[0].ids;

            if (!ids || ids.length === 0) return;

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${ids.length} data Semester?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroySelected', ids);
                }
            });
        });
    </script>
</div>
