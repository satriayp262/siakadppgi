@php
    use Vinkla\Hashids\Facades\Hashids;
@endphp

<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 mb-6">
        @if ($krs->isEmpty())
            <div class="bg-white shadow-lg p-6 rounded-lg max-w-full text-center">
                <!-- Dropdown Semester -->
                <div class="flex space-x-4 mb-4">
                    <!-- Dropdown Semester -->
                    <div class="flex space-x-4 items-center">
                        <span class="block font-medium text-gray-700 text-left ">Semester :</span>
                        <select id="semester" wire:model="selectedSemester"
                            class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                            <option value="">Pilih Semester</option>
                            @foreach ($semesters as $item)
                                @foreach ($item as $semester)
                                    <option value="{{ $semester->nama_semester }}">{{ $semester->nama_semester }}
                                    </option>
                                @endforeach
                            @endforeach

                        </select>
                    </div>

                    <!-- Tombol Tampilkan -->
                    <div class="flex items-end space-x-2">
                        <button wire:click="loadData"
                            class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                            Tampilkan
                        </button>
                    </div>
                </div>
                <div class="">
                    <img src="{{ asset('img/empty-box_18864389.png') }}" alt="not found" class="w-40 h-auto mx-auto">
                    <p class="font-bold text-customPurple text-lg mt-4">Belum Ada KRS di Semester ini</p>
                </div>
            </div>
        @else
            <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
                <div class="flex space-x-4 mb-4">
                    <!-- Dropdown Semester -->
                    <div class="flex space-x-4 items-center">
                        <span class="block font-medium text-gray-700 text-left ">Semester :</span>
                        <select id="semester" wire:model="selectedSemester"
                            class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                            @foreach ($semesters as $item)
                                @foreach ($item as $semester)
                                    <option value="{{ $semester->nama_semester }}">{{ $semester->nama_semester }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <!-- Tombol Tampilkan -->
                    <div class="flex items-end space-x-2">
                        <button wire:click="loadData"
                            class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                            Tampilkan
                        </button>
                    </div>
                </div>

                <table class="min-w-full mt-4 bg-white border border-gray-200">
                    <thead class="bg-purple2 text-white">
                        <thead>
                            <tr class="bg-customPurple text-white text-sm">
                                <th class="px-4 py-2 text-center w-[10%]">#</th>
                                <th class="px-4 py-2 text-center w-[30%]">Nama Dosen</th>
                                <th class="px-4 py-2 text-center w-[20%]">NIDN</th>
                                <th class="px-4 py-2 text-center w-[20%]">Mata Kuliah</th>
                                <th class="px-4 py-2 text-center w-[20%]">Status</th>
                                <th class="px-4 py-2 text-center w-[40%]">Aksi</th>
                            </tr>
                        </thead>
                    </thead>
                    <tbody>
                        @foreach ($krs as $item)
                            <tr class="border-b border-gray-200">
                                <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="px-2 py-2 text-left">{{ $item->matkul->dosen->nama_dosen }}</td>
                                <td class="px-2 py-2 text-left">{{ $item->matkul->nidn }}</td>
                                <td class="px-2 py-2 text-left">{{ $item->matkul->nama_mata_kuliah }}</td>
                                <td class="px-2 py-2 text-center">-</td>
                                <td class="px-2 py-2 text-center">
                                    @php
                                        $kode = Hashids::encode($item->matkul->id_mata_kuliah, $k->id_kelas);
                                    @endphp
                                    <button
                                        onclick="window.location.href='{{ route('emonev.detail', ['id_mata_kuliah' => $kode, 'nama_semester' => $semester1]) }}'"
                                        class="bg-purple2 hover:bg-customPurple text-white px-5 py-2 rounded-lg transition-transform transform hover:scale-105 text-sm font-medium">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                clip-rule="evenodd" />
                                            <path fill-rule="evenodd"
                                                d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
