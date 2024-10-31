<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="px-3 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700"><svg
            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2"
                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg></button>

    <!-- Modal Background -->
    <div  x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg ">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Data Matkul</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <div class="grid grid-cols-3">
                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="kode_mata_kuliah" class="block text-sm font-medium text-gray-700">Kode Mata
                                    Kuliah</label>
                                <p class="text-sm text-gray-500">{{ $matkul->kode_mata_kuliah ?? 'Data Belum Ada' }}</p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="nama_mata_kuliah" class="block text-sm font-medium text-gray-700">Nama Mata
                                    Kuliah</label>
                                <p class="text-sm text-gray-500">{{ $matkul->nama_mata_kuliah ?? 'Data Belum Ada' }}</p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="jenis_mata_kuliah" class="block text-sm font-medium text-gray-700">Jenis
                                    Mata Kuliah</label>
                                @if ($matkul->jenis_mata_kuliah == 'W')
                                    <p class="text-sm text-gray-500">Wajib Nasional</p>
                                @elseif ($matkul->jenis_mata_kuliah == 'A')
                                    <p class="text-sm text-gray-500">Wajib Program Studi</p>
                                @elseif ($matkul->jenis_mata_kuliah == 'B')
                                    <p class="text-sm text-gray-500">Pilihan</p>
                                @elseif ($matkul->jenis_mata_kuliah == 'C')
                                    <p class="text-sm text-gray-500">Peminatan</p>
                                @elseif ($matkul->jenis_mata_kuliah == 'S')
                                    <p class="text-sm text-gray-500">TA/SKRIPSI/THESIS/DISERTASI</p>
                                @endif
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="prodi" class="block text-sm font-medium text-gray-700">Prodi</label>
                                <p class="text-sm text-gray-500">{{ $matkul->prodi->nama_prodi ?? 'Prodi Umum' }}</p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="nidn" class="block text-sm font-medium text-gray-700">Dosen</label>
                                <p class="text-sm text-gray-500">{{ $matkul->dosen->nama_dosen ?? '-' }}</p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="sks_tatap_muka" class="block text-sm font-medium text-gray-700">SKS Tatap
                                    Muka</label>
                                <p class="text-sm text-gray-500">{{ $matkul->sks_tatap_muka ?? 'Data Belum Ada' }}</p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="sks_praktek" class="block text-sm font-medium text-gray-700">SKS
                                    Praktek</label>
                                <p class="text-sm text-gray-500">{{ $matkul->sks_praktek ?? 'Data Belum Ada' }}</p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="sks_praktek_lapangan" class="block text-sm font-medium text-gray-700">SKS
                                    Praktek Lapangan</label>
                                <p class="text-sm text-gray-500">{{ $matkul->sks_praktek_lapangan ?? 'Data Belum Ada' }}
                                </p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="sks_simulasi" class="block text-sm font-medium text-gray-700">SKS
                                    Simulasi</label>
                                <p class="text-sm text-gray-500">{{ $matkul->sks_simulasi ?? 'Data Belum Ada' }}</p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="metode_pembelajaran" class="block text-sm font-medium text-gray-700">Metode
                                    Pembelajaran</label>
                                <p class="text-sm text-gray-500">{{ $matkul->metode_pembelajaran ?? 'Data Belum Ada' }}
                                </p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="tgl_mulai_efektif" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai Efektif</label>
                                <p class="text-sm text-gray-500">{{ $matkul->tgl_mulai_efektif ?? 'Data Belum Ada' }}
                                </p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="tgl_akhir_efektif" class="block text-sm font-medium text-gray-700">Tanggal
                                    Akhir Efektif</label>
                                <p class="text-sm text-gray-500">{{ $matkul->tgl_akhir_efektif ?? 'Data Belum Ada' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
