<div class="mx-5">
    <nav aria-label="Breadcrumb" class="mt-4">
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
                    <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $matkul->nama_mata_kuliah }}</span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Nama Kelas</th>
                    <th class="px-4 py-2 text-center">Lingkup Kelas</th>
                    <th class="px-4 py-2 text-center">Mode Kuliah</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas as $index => $item)
                    <tr class="text-center border-b border-gray-200">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $item->nama_kelas }}</td>
                        <td class="px-4 py-2">{{ $item->lingkup_kelas }}</td>
                        <td class="px-4 py-2">{{ $item->mode_kuliah }}</td>
                        <td class="px-4 py-2">{{ $item->prodi->nama_prodi ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('dosen.berita_acara.detail_kelas', ['id_mata_kuliah' => $item->matkul->id_mata_kuliah, 'id_kelas' => $item->id_kelas]) }}"
                                class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada kelas yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kelas->links() }}
        </div>
    </div>
</div>
