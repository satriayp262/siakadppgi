<div class="mx-5">
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
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
            <div class="flex items-end">
                <button wire:click="loadData"
                    class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                    Tampilkan
                </button>
            </div>
        </div>

        <!-- Tabel Data -->
        @if ($selectedSemester || $selectedprodi)
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="bg-customPurple text-white text-sm">
                        <th class="px-2 py-2 text-center w-1/12">No.</th>
                        <th class="px-4 py-2 text-center w-2/12">Semester</th>
                        <th class="px-4 py-2 text-center w-2/12">Prodi</th>
                        <th class="px-4 py-2 text-center w-1/12">NIDN</th>
                        <th class="px-4 py-2 text-center w-4/12">Nama Dosen</th>
                        <th class="px-4 py-2 text-center w-2/12">Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jawaban as $item)
                        <tr class="border-t" wire:key="jawaban-{{ $item->id_jawaban }}">
                            <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->nama_semester }}</td>
                            <td class="px-4 py-2 text-left">{{ $item->nama_prodi }}</td>
                            <td class="px-4 py-2 text-left">{{ $item->nidn }}</td>
                            <td class="px-4 py-2 text-left">{{ $item->nama_dosen }}</td>
                            <td
                                class="px-4 py-2 text-center font-black text-xl {{ $item->total_nilai > 200 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $item->total_nilai }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
