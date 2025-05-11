<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-6 h-6 mr-2 font-black text-white" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M5 12h14m-7 7V5" />
        </svg>

        Tambah
    </button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Matkul</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="save">
                        <div class="mb-4">
                            <label for="kode_mata_kuliah" class="block text-sm font-medium text-gray-700">Kode Mata
                                Kuliah</label>
                            <input type="text" id="kode_mata_kuliah" wire:model="kode_mata_kuliah"
                                name="kode_mata_kuliah"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('kode_mata_kuliah')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_mata_kuliah" class="block text-sm font-medium text-gray-700">Nama Mata
                                Kuliah</label>
                            <input type="text" id="nama_mata_kuliah" wire:model="nama_mata_kuliah"
                                name="nama_mata_kuliah"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('nama_mata_kuliah')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jenis_mata_kuliah" class="block text-sm font-medium text-gray-700">Jenis Mata
                                Kuliah</label>
                            <select id="jenis_mata_kuliah" wire:model.live="jenis_mata_kuliah" name="jenis_mata_kuliah"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                <option value="W">Wajib Nasional</option>
                                <option value="A">Wajib Program Studi</option>
                                <option value="B">Pilihan</option>
                                <option value="C">Peminatan</option>
                                <option value="S">TA/SKRIPSI/THESIS/DISERTASI</option>
                            </select>
                            @error('jenis_mata_kuliah')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Prodi</label>
                            <select id="kode_prodi" wire:model.live="kode_prodi" name="kode_prodi"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                            @error('kode_prodi')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nidn" class="block text-sm font-medium text-gray-700">Dosen</label>
                            <select id="nidn" wire:model.live="nidn" name="nidn"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->nidn }}">
                                        {{ $dosen->nama_dosen . ' (' . $dosen->prodi->nama_prodi . ')' }}</option>
                                @endforeach
                            </select>
                            @error('nidn')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sks_tatap_muka" class="block text-sm font-medium text-gray-700">SKS Tatap
                                Muka</label>
                            <input type="text" id="sks_tatap_muka" wire:model="sks_tatap_muka" name="sks_tatap_muka"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('sks_tatap_muka')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sks_praktek" class="block text-sm font-medium text-gray-700">SKS praktek</label>
                            <input type="text" id="sks_praktek" wire:model="sks_praktek" name="sks_praktek"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('sks_praktek')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sks_praktek_lapangan" class="block text-sm font-medium text-gray-700">SKS
                                Praktek Lapangan</label>
                            <input type="text" id="sks_praktek_lapangan" wire:model="sks_praktek_lapangan"
                                name="sks_praktek_lapangan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('sks_praktek_lapangan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sks_simulasi" class="block text-sm font-medium text-gray-700">SKS
                                Simulasi</label>
                            <input type="text" id="sks_simulasi" wire:model="sks_simulasi" name="sks_simulasi"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('sks_simulasi')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="metode_pembelajaran" class="block text-sm font-medium text-gray-700">Metode
                                Pembelajaran</label>
                            <select id="metode_pembelajaran" wire:model="metode_pembelajaran"
                                name="metode_pembelajaran"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                <option value="Offline">Offline</option>
                                <option value="Online">Online</option>
                            </select>
                            @error('metode_pembelajaran')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tgl_mulai_efektif" class="block text-sm font-medium text-gray-700">Tanggal
                                Mulai Efektif</label>
                            <input type="date" id="tgl_mulai_efektif" wire:model="tgl_mulai_efektif"
                                name="tgl_mulai_efektif"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('tgl_mulai_efektif')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tgl_akhir_efektif" class="block text-sm font-medium text-gray-700">Tanggal
                                Akhir Efektif</label>
                            <input type="date" id="tgl_akhir_efektif" wire:model="tgl_akhir_efektif"
                                name="tgl_akhir_efektif"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('tgl_akhir_efektif')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- Submit Button inside the form -->
                        <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                            <button type="button" @click="isOpen = false"
                                class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Close</button>
                            <button type="submit"
                                class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
