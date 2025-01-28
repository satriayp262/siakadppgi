<div class="mx-5">
    <div class="flex flex-row justify-between mx-4 mt-4 items-center">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <a href="{{ route('dosen.berita_acara') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                        Berita Acara
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span
                            class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $matkul->nama_mata_kuliah }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <input type="text" wire:model.live="search" placeholder="   Search"
            class="px-2 py-2 ml-4 border border-gray-300 rounded-lg">
    </div>

    @if ($this->CheckDosen)
        @foreach ($kelas as $index => $item)
            <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
                <div class="flex flex-row justify-between">
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-purple2">{{ $item->nama_kelas }}</span>
                        <span class="text-sm font-bold text-gray-400">Prodi :
                            {{ $item->prodi->nama_prodi ?? '-' }}</span>
                    </div>
                    <div class="flex justify-center space-x-2 py-2">
                        <a href="{{ route('dosen.berita_acara.detail_kelas', ['id_mata_kuliah' => $item->matkul->id_mata_kuliah, 'id_kelas' => $item->id_kelas]) }}"
                            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                            <p class="text-white">▶</p>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="px-4 py-2 text-center">Tidak ada kelas yang ditemukan.</td>
        </tr>
    @endif
</div>
