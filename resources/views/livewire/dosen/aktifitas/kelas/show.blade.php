<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <!-- Modal Form -->
        {{-- <div class="flex justify-between mt-2">
            <input type="text" wire:model.debounce.300ms="search" placeholder="   Search"
            class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div> --}}
        <livewire:dosen.aktifitas.kelas.create :$id_kelas />

    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">Nama Kelas</th>
                    <th class="px-4 py-2 text-center">Nama aktifitas</th>
                    <th class="px-4 py-2 text-center">Catatan</th>
                    <th class="px-4 py-2 text-center">Tanggal Dibuat</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($this->CheckDosen)
                    @foreach ($aktifitas as $item)
                        <tr wire:key="item-{{ $item->id_aktifitas }}">
                            <td class="px-4 py-2 text-center">{{ $item->kelas->nama_kelas }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->nama_aktifitas }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->catatan }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM Y') }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex flex-row">
                                    <div class="flex justify-center w-full space-x-2">
                                        {{-- <a href="{{ route('dosen.aktifitas.kelas', ['id_mata_kuliah' => $matkul->id_mata_kuliah]) }}"
                                        class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                                        <p>▶</p>
                                    </a> --}}
                                        <livewire:dosen.aktifitas.kelas.edit :id_aktifitas="$item->id_aktifitas" :$id_kelas
                                            wire:key="edit-{{ $item->id_aktifitas }}">

                                            <button
                                                class="inline-block px-4 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                                wire:key="delete-{{ $item->id_aktifitas }}"
                                                onclick="confirmDelete('{{ $item->id_aktifitas }}')">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                            
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    function confirmDelete(id_aktifitas) {
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus Aktifitas ini?',
            text: "Data Nilai pada Aktifitas ini akan Hilang dan Data yang telah dihapus tidak akan dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', id_aktifitas);
            }
        });
    }
</script>
