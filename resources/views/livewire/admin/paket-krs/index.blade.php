<div class="mx-5">
    <div class="flex justify-between mb-4 mt-4 items-center mx-4">
        <div class="flex justify-between items-center space-x-4">
            <a href="{{ route('admin.paketkrs.create') }}"
                class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                <svg class="w-6 h-6 mr-2 font-black text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                        d="M5 12h14m-7 7V5" />
                </svg>
                Tambah
            </a>
        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">Nama Kelas</th>
                    <th class="px-4 py-2 text-center">Semester</th>
                    <th class="px-4 py-2 text-center">Mulai</th>
                    <th class="px-4 py-2 text-center">Selesai</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paketKRS as $item)
                    <tr class="border-t">

                        <td class="px-4 py-2 text-center">{{ $item->kelas->nama_kelas }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->semester->nama_semester }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->tanggal_mulai }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->tanggal_selesai }}</td>
                        <td class="px-4 py-2 text-center">
                            <button wire:key="delete-{{ $item->id_kelas }}"
                                class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                onclick="confirmDelete({{ $item->id_paket_krs }}, '{{ $item->kelas->nama_kelas }}', '{{ $item->semester->nama_semester }}')"><svg
                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4 mb-4 text-center">
            {{ $paketKRS->links() }}
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, nama_kelas, semester) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus Paket KRS untuk ${nama_kelas} ${semester}?`,
            text: "KRS yang sudah diajukan oleh mahasiswa tidak akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#28a745',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', id);
            }
        });
    }
</script>
