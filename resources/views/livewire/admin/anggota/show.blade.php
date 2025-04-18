<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <a href="{{ route('admin.anggota') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Anggota Kelas</span>
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.anggota.show', ['nama_kelas' => str_replace('/', '-', $nama_kelas)]) }}"
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
    <div class="flex justify-between mt-1">
        @if ($nama_kelas !== 'Tanpa kelas')
        <livewire:admin.anggota.edit :$nama_kelas />
        @endif
        <div></div>
    </div>
    @foreach ($mahasiswa as $item)
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-purple2">{{ $item->NIM }}</span>
                    <span class="text-sm font-bold text-gray-400">
                        {{ $item->nama }}</span>
                </div>
                <div class="flex justify-center space-x-2">
                    <button wire:key="delete-{{ $item->id_kelas }}"
                        class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                        onclick="confirmDelete('{{ $item->id_mahasiswa }}', '{{ $item->nama }}','{{ str_replace('-', '/', $nama_kelas) }}')"><svg
                            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
    <div class="py-8 mt-4 mb-4 text-center">
        @if ( !count($mahasiswa) === 0)
            {{ $mahasiswa->links('') }}
        @endif
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
