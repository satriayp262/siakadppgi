<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <!-- Modal Form -->
        {{-- <div class="flex justify-between mt-2">
            <input type="text" wire:model.debounce.300ms="search" placeholder="   Search"
            class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div> --}}
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">Nama Mata Kuliah</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Jenis Mata Kuliah</th>
                    <th class="px-4 py-2 text-center">Methode Pembelajaran</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matakuliah as $matkul)
                    <tr wire:key="matkul-{{ $matkul->id_mata_kuliah }}">
                        <td class="px-4 py-2 text-center">{{ $matkul->nama_mata_kuliah }}</td>
                        <td class="px-4 py-2 text-center">{{ $matkul->prodi->nama_prodi }}</td>
                        <td class="px-4 py-2 text-center">{{ $matkul->getJenisMatakuliah() }}</td>
                        <td class="px-4 py-2 text-center">{{ $matkul->metode_pembelajaran }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex flex-row">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('dosen.bobot.kelas', ['kode_mata_kuliah' => $matkul->kode_mata_kuliah]) }}"
                                        class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                                        <p>▶</p>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">
            {{ $matakuliah->links('') }}
        </div>
    </div>
</div>

