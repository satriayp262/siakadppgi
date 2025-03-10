<div class="mx-5">
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg w-full" style="width: 1225px">
        <!-- Dropdown Pilihan Semester dan Prodi -->
        <div class="flex space-x-4 mb-4">
            <!-- Dropdown Semester -->
            <div>
                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                <select id="semester" wire:model="selectedSemester"
                    class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                    <option value="">Pilih Semester</option>
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->nama_semester }}">{{ $semester->nama_semester }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Prodi -->
            <div>
                <label for="prodi" class="block text-sm font-medium text-gray-700">Prodi</label>
                <select id="prodi" wire:model="selectedprodi"
                    class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                    <option value="">Pilih Prodi</option>
                    @foreach ($Prodis as $prodi)
                        <option value="{{ $prodi->nama_prodi }}">{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Tampilkan -->
            <div class="flex items-end space-x-2">
                <button wire:click="loadData"
                    class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                    Tampilkan
                </button>
                <a wire:click='download' target="_blank"
                    class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition-transform hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                    </svg>
                    Download
                </a>
            </div>
        </div>

        <!-- Tabel Data -->

        <div class="overflow-x-auto ">
            <h1 class=" text-customPurple font-bold text-lg text-justify">Monitoring dan Evaluasi Dosen
                {{ $selectedprodi }}
                di semester
                @if ($selectedSemester)
                    {{ $selectedSemester }}
                @else
                    {{ $semesters[0]->nama_semester }}
                @endif
            </h1>
            <table class="mt-4 bg-white border border-gray-200 whitespace-nowrap">
                <thead>
                    <tr class="bg-customPurple text-white text-sm">
                        <th class="px-2 py-2 text-center w-12">No.</th>
                        <th class="px-4 py-2 text-center w-40">Nama Dosen</th>
                        <th class="px-4 py-2 text-center w-40">Kelas</th>
                        @foreach ($pertanyaan as $item)
                            <th class="px-4 py-2 text-center w-28">{{ $item->nama_pertanyaan }}</th>
                        @endforeach
                        <th class="px-4 py-2 text-center w-40">Saran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jawaban->unique('id_emonev') as $item)
                        <tr class="border-t" wire:key="jawaban-{{ $item->id_jawaban }}">
                            <td class=" px-2 py-2 text-center">{{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 text-left">{{ $item->nama_dosen }}</td>
                            <td class="px-4 py-2 text-left">{{ $item->nama_kelas }}</td>
                            @foreach ($pertanyaan as $ins)
                                @php
                                    $nilai = $item
                                        ->where('id_pertanyaan', $ins->id_pertanyaan)
                                        ->where('id_emonev', $item->id_emonev)
                                        ->first()->nilai;
                                    switch ($nilai) {
                                        case null:
                                            $nilai = '-';
                                            break;
                                        case 6:
                                            $nilai = 'Kurang';
                                            break;
                                        case 7:
                                            $nilai = 'Cukup';
                                            break;
                                        case 8:
                                            $nilai = 'Baik';
                                            break;
                                        case 9:
                                            $nilai = 'Sangat Baik';
                                            break;
                                        case 10:
                                            $nilai = 'Istimewa';
                                            break;
                                    }
                                @endphp
                                <td class="px-4 py-2 text-left">{{ $nilai }}</td>
                            @endforeach
                            <td class="px-4 py-2 text-left">{{ $item->saran }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
