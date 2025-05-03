<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.periode.create />
            </div>
        </div>
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <h2 class=" text-base font-semibold text-customPurple">Periode Pengisian Emonev</h2>
            <table class="min-w-full mt-4 bg-white border border-gray-200 overflow-hidden text-sm">
                <thead>
                    <tr class="text-white bg-customPurple text-xs sm:text-sm">
                        <th class="px-4 py-3 text-center">No.</th>
                        <th class="px-4 py-3 text-center">Semester</th>
                        <th class="px-4 py-3 text-center">Periode</th>
                        <th class="px-4 py-3 text-center">Sesi</th>
                        <th class="px-4 py-3 text-center">Tanggal Mulai</th>
                        <th class="px-4 py-3 text-center">Tanggal Selesai</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($periode as $item)
                        <tr class="border-t hover:bg-gray-50 transition duration-150"
                            wire:key="periode-{{ $item->id_periode }}">
                            <td class="px-4 py-2 text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center align-middle text-nowrap">
                                {{ $item->semester->nama_semester }}</td>
                            <td class="px-4 py-2 text-center align-middle">{{ $item->nama_periode }}</td>
                            <td class="px-4 py-2 text-center align-middle">{{ $item->sesi }}</td>
                            <td class="px-4 py-2 text-center align-middle text-nowrap">{{ $item->tanggal_mulai }}</td>
                            <td class="px-4 py-2 text-center align-middle text-nowrap">{{ $item->tanggal_selesai }}</td>
                            <td class="px-4 py-2 text-center align-middle">
                                <div class="flex justify-center items-center space-x-2">
                                    <button
                                        class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                        onclick="confirmDelete('{{ $item->id_periode }}', '{{ $item->semester->nama_semester . '-' . $item->sesi }}')"><svg
                                            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
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
                {{ $periode->links('') }}
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id_periode, sesi) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus Periode ${sesi}?`,
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', id_periode);
            }
        });
    }
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
