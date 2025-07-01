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
        <div class="mb-4 max-w-6xl p-4">
            @livewire('component.chart-emonev', ['x' => $nama_periode], key($selectedSemester))
        </div>
        @if ($nama_periode)
            <div class="max-w-6xl">
                <h2 class="text-lg font-semibold mb-4 text-center">👨‍🏫 Detail Evaluasi Dosen Periode
                    <span class=" text-purple2">{{ $nama_periode }}</span>
                </h2>
                @livewire('table.emonev-admin', ['periode' => $nama_periode], key($selectedSemester))
            </div>
        @endif
    </div>
</div>
