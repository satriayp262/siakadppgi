<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <a wire:navigate.hover href="{{ route('admin.anggota') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Anggota Kelas</span>
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a wire:navigate.hover
                                href="{{ route('admin.anggota.show', ['nama_kelas' => str_replace('/', '-', $nama_kelas)]) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                <span
                                    class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ str_replace('-', '/', $nama_kelas) }}</span>
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
            <H2 class="px-4 font-bold text-[32px] text-purple2">
                {{ str_replace('-', '/', $nama_kelas) }}
            </H2>
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
        <div class="flex justify-between mt-1">
            @if ($nama_kelas !== 'Tanpa kelas')
                <livewire:admin.anggota.edit :$nama_kelas />
            @endif
            <div></div>
        </div>
        <div class="overflow-x-auto mt-4 mb-4">
            <table class="min-w-full bg-white shadow-lg rounded-lg">
                <thead class="bg-purple2 text-white">
                    <tr>
                        <th class="px-4 py-2 text-center">NIM</th>
                        <th class="px-4 py-2 text-center">Nama</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2 border text-center font-bold text-purple2">{{ $item->NIM }}</td>
                            <td class="px-4 py-2 border text-center text-gray-600">{{ $item->nama }}</td>
                            <td class="px-4 py-2 border text-center">
                                <button wire:key="delete-{{ $item->id_kelas }}"
                                    class="inline-flex items-center justify-center px-3 py-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $item->id_mahasiswa }}', '{{ $item->nama }}', '{{ str_replace('-', '/', $nama_kelas) }}')">
                                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 7h14M10 11v6m4-6v6M9 4h6a1 1 0 011 1v2H8V5a1 1 0 011-1zm-3 3h12v12a1 1 0 01-1 1H7a1 1 0 01-1-1V7z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="py-4 text-center">
                @if (!$mahasiswa->isEmpty())
                    {{ $mahasiswa->links('') }}
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id, nama, nama_kelas) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus ${nama} dari Kelas ${nama_kelas}?`,
            text: " ",
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
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('AnggotaUpdated', event => {
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
        window.addEventListener('AnggotaDestroyed', event => {
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
</script>
