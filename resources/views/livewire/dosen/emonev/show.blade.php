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
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                <span class="block font-medium text-gray-700 text-left">Periode :</span>
                <select id="semester" wire:model="selectedSemester"
                    class="w-full md:w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                    <option value="" disabled>Pilih Periode</option>
                    @foreach ($periode as $item)
                        <option value="{{ $item->nama_periode }}">{{ $item->nama_periode }}</option>
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

        <!-- Tabel Data -->
        <div class="">
            @if ($selectedSemester)
                @livewire('table.dosen.emonev.emonev-table', ['jawaban' => $selectedSemester, 'matakuliah' => $id, 'user' => $user])
            @endif
        </div>
    </div>
</div>
