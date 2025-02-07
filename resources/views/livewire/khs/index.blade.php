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
                    <th class="px-4 py-2 text-center">Nama Kelas</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Semester</th>
                    <th class="px-4 py-2 text-center">Methode Pembelajaran</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $item)
                    <tr wire:key="item-{{rand(). $item->id_kelas }}">
                        <td class="px-4 py-2 text-center">{{ $item->nama_kelas }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->prodi->nama_prodi }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->semester->nama_semester }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->bahasan }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex flex-row">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('dosen.khs.show', ['nama_kelas' => str_replace('/', '-', $item->nama_kelas)]) }}">
                                        <p class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">▶</p>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="py-8 mt-4 text-center">
            {{ $kelas->links('') }}
        </div>
    </div>
</div>
