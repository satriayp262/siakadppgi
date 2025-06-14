<div class="mx-5">
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
        <!-- Dropdown Semester -->
        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-4">
            <!-- Dropdown Semester -->
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                <span class="block font-medium text-gray-700 text-left">Periode :</span>
                <select id="semester" wire:model="selectedSemester"
                    class="w-full md:w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                    <option value="" disabled>Pilih Periode</option>
                    @foreach ($periode as $item)
                        <option value="{{ $item->id_periode }}">{{ $item->nama_periode }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Tampilkan -->
            <div class="flex justify-start md:items-end">
                <button wire:click="loadData"
                    class="md:w-auto bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
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

                @if ($status != null)
                    @if ($status == 'sudah')
                        <a wire:navigate.hover wire:click="$set('status', null)"
                            class="relative block p-4 rounded-lg shadow-lg bg-lime-500 hover:bg-lime-600">
                            <h2 class="text-lg font-semibold text-white">Sudah Isi Emonev</h2>
                            <p class="mt-1 text-xl font-bold text-white">{{ $emonev }}</p>
                        </a>

                        <a wire:navigate.hover wire:click="$set('status', 'belum')"
                            class="relative block p-4 rounded-lg shadow-lg bg-red-500 hover:bg-red-600">
                            <h2 class="text-lg font-semibold text-white">Belum Mengisi</h2>
                            <p class="mt-1 text-xl font-bold text-white">{{ $belum }}</p>
                        </a>
                    @else
                        <a wire:navigate.hover wire:click="$set('status', 'sudah')"
                            class="relative block p-4 rounded-lg shadow-lg bg-lime-500 hover:bg-lime-600">
                            <h2 class="text-lg font-semibold text-white">Sudah Isi Emonev</h2>
                            <p class="mt-1 text-xl font-bold text-white">{{ $emonev }}</p>
                        </a>

                        <a wire:navigate.hover wire:click="$set('status', null)"
                            class="relative block p-4 rounded-lg shadow-lg bg-red-500 hover:bg-red-600">
                            <h2 class="text-lg font-semibold text-white">Belum Mengisi</h2>
                            <p class="mt-1 text-xl font-bold text-white">{{ $belum }}</p>
                        </a>
                    @endif
                @else
                    <a wire:navigate.hover wire:click="$set('status', 'sudah')"
                        class="relative block p-4 rounded-lg shadow-lg bg-lime-500 hover:bg-lime-600">
                        <h2 class="text-lg font-semibold text-white">Sudah Isi Emonev</h2>
                        <p class="mt-1 text-xl font-bold text-white">{{ $emonev }}</p>
                    </a>

                    <a wire:navigate.hover wire:click="$set('status', 'belum')"
                        class="relative block p-4 rounded-lg shadow-lg bg-red-500 hover:bg-red-600">
                        <h2 class="text-lg font-semibold text-white">Belum Mengisi</h2>
                        <p class="mt-1 text-xl font-bold text-white">{{ $belum }}</p>
                    </a>
                @endif

            </div>
            <div class="">
                @if ($status == 'sudah')
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold">Daftar Mahasiswa</h1>
                        <p class="text-sm text-gray-500">Daftar Mahasiswa yang <span
                                class="text-green-500 font-semibold">sudah</span> mengisi emonev pada periode
                            {{ $nama }}</p>
                        </p>
                    </div>
                    @livewire('table.emonev.sudah-isi-emonev-table', ['mahasiswasudah' => $mahasiswasudah])
                @elseif ($status == 'belum')
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold">Daftar Mahasiswa</h1>
                        <p class="text-sm text-gray-500">Daftar Mahasiswa yang <span
                                class="text-red-500 font-semibold">belum</span>
                            mengisi emonev pada periode
                            {{ $nama }}</p>
                        </p>
                    </div>
                    @livewire('table.emonev.belum-isi-emonev-table', ['mahasiswabelum' => $mahasiswabelum])
                @else
                @endif
            </div>
        @endif
    </div>
</div>
