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

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Nama Kelas</th>
                    <th class="px-4 py-2 text-center">Lingkup Kelas</th>
                    <th class="px-4 py-2 text-center">Mode Kuliah</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($this->CheckDosen)
                    @foreach ($kelas as $index => $item)
                        <tr class="text-center border-b border-gray-200">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->nama_kelas }}</td>
                            <td class="px-4 py-2">{{ $item->lingkup_kelas }}</td>
                            <td class="px-4 py-2">{{ $item->mode_kuliah }}</td>
                            <td class="px-4 py-2">{{ $item->prodi->nama_prodi ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex flex-col">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('dosen.berita_acara.detail_kelas', ['id_mata_kuliah' => $item->matkul->id_mata_kuliah, 'id_kelas' => $item->id_kelas]) }}"
                                            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                                            <p class="text-white">▶</p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada kelas yang ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kelas->links() }}
        </div>
    </div>
</div>
