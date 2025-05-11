<div class="mx-5">
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
        <!-- Dropdown Semester -->
        <div class="flex space-x-4 mb-4">
            <!-- Dropdown Semester -->
            <div class="flex space-x-4 items-center">
                <span class="block font-medium text-gray-700 text-left ">Periode :</span>
                <select id="semester" wire:model="selectedSemester"
                    class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                    <option value="" disabled>Pilih Periode</option>
                    @foreach ($periode as $item)
                        <option value="{{ $item->id_periode }}">{{ $item->nama_periode }}
                        </option>
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

        @if ($selectedSemester)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-3">
                <a wire:navigate.hover href="#"
                    class="relative block p-4 rounded-lg shadow-lg bg-yellow-500 hover:bg-yellow-600">
                    <h2 class="text-lg font-semibold text-white">Periode</h2>
                    <p class="mt-1 text-xl font-bold text-white">{{ $nama }}</p>
                </a>

                <a wire:navigate.hover href="#"
                    class="relative block p-4 rounded-lg shadow-lg bg-purple-400 hover:bg-purple-500">
                    <h2 class="text-lg font-semibold text-white">Total Mahasiswa (KRS)</h2>
                    <p class="mt-1 text-xl font-bold text-white">{{ $mahasiswa }}</p>
                </a>

                <a wire:navigate.hover href="#"
                    class="relative block p-4 rounded-lg shadow-lg bg-lime-500 hover:bg-lime-600">
                    <h2 class="text-lg font-semibold text-white">Sudah Isi Emonev</h2>
                    <p class="mt-1 text-xl font-bold text-white">{{ $emonev }}</p>
                </a>

                <a wire:navigate.hover href="#"
                    class="relative block p-4 rounded-lg shadow-lg bg-red-500 hover:bg-red-600">
                    <h2 class="text-lg font-semibold text-white">Belum Mengisi</h2>
                    <p class="mt-1 text-xl font-bold text-white">{{ $belum }}</p>
                </a>
            </div>
            <div class="justify-between flex items-center mr-2 mt=2">
                <div class="flex flex-col">
                    <h1 class="text-2xl font-bold">Daftar Mahasiswa</h1>
                    <p class="text-sm text-gray-500">Daftar Mahasiswa yang belum mengisi emonev pada periode
                        {{ $nama }}</p>
                    </p>
                </div>
            </div>
            @livewire('table.emonev.list-mahasiswa-table', ['selectedSemester' => $selectedSemester], key($selectedSemester))
        @endif



    </div>
