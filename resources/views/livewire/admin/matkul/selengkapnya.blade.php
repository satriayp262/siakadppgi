<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Selengkapnya</button>

    <!-- Modal Background -->
    <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg ">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Selengkapnya</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <table class="min-w-full mt-4 bg-white border border-gray-200">
                    <thead>
                        <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                            <th class="px-4 py-2 text-center">Kode Mata Kuliah</th>
                            <th class="px-4 py-2 text-center">Nama Mata Kuliah</th>
                            <th class="px-4 py-2 text-center">Jenis Mata Kuliah</th>
                            <th class="px-4 py-2 text-center">SKS Tatap Muka</th>
                            <th class="px-4 py-2 text-center">SKS Praktek</th>
                            <th class="px-4 py-2 text-center">SKS Praktek Lapangan</th>
                            <th class="px-4 py-2 text-center">SKS Simulasi</th>
                            <th class="px-4 py-2 text-center">Metode Pembelajaran</th>
                            <th class="px-4 py-2 text-center">Tanggal Mulai Efektif</th>
                            <th class="px-4 py-2 text-center">Tanggal Akhir Efektif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $matkuls->kode_mata_kuliah }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->nama_mata_kuliah }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->jenis_mata_kuliah }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->sks_tatap_muka }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->sks_praktek }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->sks_praktek_lapangan }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->sks_simulasi }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->metode_pembelajaran }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->tgl_mulai_efektif }}</td>
                            <td class="px-4 py-2 text-center">{{ $matkuls->tgl_akhir_efektif }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
