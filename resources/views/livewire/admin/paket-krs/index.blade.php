<div class="mx-5">
    <div wire:loading wire:target="destroySelected,destroy"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
    <div class="spinner loading-spinner"></div>
</div>
    <div class="flex justify-between mb-4 mt-4 items-center mx-4">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <a wire:navigate.hover href="{{ route('admin.paketkrs') }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Anggota Kelas</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex justify-between items-center space-x-4">
            <a wire:navigate.hover href="{{ route('admin.paketkrs.create') }}"
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
        <livewire:table.paker-krstable />
        {{-- <table class="min-w-full mt-4 bg-white text-[8px] md:text-[16px]  border border-gray-200">
            <thead>
                <tr class="items-center w-full text-[8px] md:text-[16px]  text-white align-middle bg-customPurple">
                    <th class="md:px-4 py-2 text-center">Nama Kelas</th>
                    <th class="md:px-4 py-2 text-center">Semester</th>
                    <th class="px-5 md:px-4 py-2 text-center">Mulai</th>
                    <th class="px-5 md:px-4 py-2 text-center">Selesai</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paketKRS as $item)
                    <tr class="border-t">

                        <td class="px-4 py-2 text-center">{{ $item->kelas->nama_kelas }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->semester->nama_semester }}</td>
                        <td class="px-4 py-2 text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 text-center">
                            <button wire:key="delete-{{ $item->id_kelas }}"
                                class="inline-block px-2 sm:px-4 py-1 sm:py-2 text-white bg-red-500 rounded hover:bg-red-700"
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
        </div> --}}
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
    window.addEventListener('bulkDelete.alert.paker-k-r-s-table-th1jhx-table', (event) => {
        const ids = event.detail[0].ids;

        // console.log(event.detail[0].ids);
        if (!ids || ids.length === 0) return;

        Swal.fire({
            title: `Apakah anda yakin ingin menghapus ${ids.length} data User?`,
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                // Livewire.find(
                //     document.querySelector('[wire\\:id]').getAttribute('wire:id')
                // ).call('destroySelected', ids);
                @this.call('destroySelected', ids);
            }
        });
    });

    function isMovingToDropdown(event) {
        const target = event.relatedTarget; // Elemen tujuan kursor
        return target && (target.closest('.relative') !== null);
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('destroyed', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Dispatch the modal-closed event to close the modal
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('deletedPaketKRS', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail[0].message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
