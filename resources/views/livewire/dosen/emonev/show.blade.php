<div class="mx-5 mt-4">
    <nav aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('dosen.emonev') }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                    Emonev
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $Matakuliah }}</span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg w-full" style="width: 1225px">

        <div class=" flex items-stretch">
            <div class="">
                <h2 class="text-gray-700 text-base md:text-md font-medium">
                    Halaman ini menampilkan hasil survei Emonev yang telah diisi oleh mahasiswa.
                </h2>
                <h3 class="text-gray-700 text-base md:text-md font-medium">
                    Silakan pilih semester yang diinginkan untuk melihat hasil survei Emonev.
                </h3>

            </div>
            <div class=" flex-grow text-center items-center">
                <h4 class="text-gray-700 text-base md:text-md font-semibold">Keterangan nilai: </h4>
                <div class="flex flex-wrap items-center gap-2 md:gap-4 ml-3 md:ml-5 mt-3">
                    @foreach ([6 => 'red', 7 => 'gray', 8 => 'yellow', 9 => 'green', 10 => 'blue'] as $value => $color)
                        <div class="flex items-center">
                            <span
                                class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center bg-{{ $color }}-500 text-white font-semibold rounded-full mr-2">
                                {{ $value }}
                            </span>
                            <span class="text-gray-700 text-sm md:text-base">
                                {{ ['Kurang', 'Cukup', 'Baik', 'Sangat Baik', 'Istimewa'][$value - 6] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

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
        <div class="overflow-x-scroll ">

            <table class="mt-4 bg-white border border-gray-200 whitespace-nowrap">
                <thead>
                    <tr class="bg-customPurple text-white text-sm">
                        <th class="px-2 py-2 text-center w-12">No.</th>
                        @foreach ($pertanyaan as $item)
                            <th class="px-4 py-2 text-center w-30">
                                <div class="relative">
                                    <button id="dropdownNilaiButton-{{ $item->id_pertanyaan }}"
                                        data-dropdown-toggle="dropdownNilai-{{ $item->id_pertanyaan }}"
                                        data-dropdown-delay="500" type="button" class="space-x-2 flex items-center">
                                        {{ $item->nama_pertanyaan }} <br>
                                        <svg class="w-[12px] h-[12px] text-white aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M5.05 3C3.291 3 2.352 5.024 3.51 6.317l5.422 6.059v4.874c0 .472.227.917.613 1.2l3.069 2.25c1.01.742 2.454.036 2.454-1.2v-7.124l5.422-6.059C21.647 5.024 20.708 3 18.95 3H5.05Z" />
                                        </svg>
                                    </button>
                                    <div id="dropdownNilai-{{ $item->id_pertanyaan }}"
                                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute">
                                        <a href="#" wire:click.prevent="setValues('', '')"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua</a>
                                        <a href="#" wire:click.prevent="setValues(6, {{ $item->id_pertanyaan }})"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kurang</a>
                                        <a href="#" wire:click.prevent="setValues(7, {{ $item->id_pertanyaan }})"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cukup</a>
                                        <a href="#" wire:click.prevent="setValues(8, {{ $item->id_pertanyaan }})"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Baik</a>
                                        <a href="#" wire:click.prevent="setValues(9, {{ $item->id_pertanyaan }})"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sangat
                                            Baik</a>
                                        <a href="#"
                                            wire:click.prevent="setValues(10, {{ $item->id_pertanyaan }})"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Istimewa</a>
                                    </div>
                                </div>
                            </th>
                        @endforeach

                        <th class="px-4 py-2 text-center w-40">Saran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jawaban as $item)
                        <tr class="border-t" wire:key="jawaban-{{ $item->id_jawaban }}">
                            <td class=" px-2 py-2 text-center">{{ $loop->iteration }}
                            </td>

                            @foreach ($pertanyaan as $ins)
                                @php
                                    $average = number_format($item->{'pertanyaan_' . $ins->id_pertanyaan}, 2);
                                    $round = round($average);
                                @endphp
                                <td class="px-4 py-2 text-left">
                                    {{ $round }}
                                </td>
                            @endforeach
                            <td class="px-4 py-2 text-left">{{ $item->saran }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $jawaban->links() }}

    </div>
</div>
