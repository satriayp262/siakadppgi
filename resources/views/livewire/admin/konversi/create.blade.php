<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false"
    @open-modal.window="isOpen = true; $nextTick(() => Livewire.dispatch('initSelect2'))">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-6 h-6 mr-2 text-white font-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14"
            height="14" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M5 12h14m-7 7V5" />
        </svg>
        Tambah
    </button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <div wire:loading wire:target="save"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="spinner loading-spinner"></div>
            </div>
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Konversi</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 text-left"> <!-- Added text-left here -->
                    <div class="p-4 max-h-[500px] border border-gray-200 overflow-y-auto">
                        <form wire:submit.prevent="save" enctype="multipart/form-data">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Mahasiswa</label>
                            <div class="mb-4 w-full bg-gray-200 border border-gray-700 rounded">
                                <x-select2 wire:model.live="mahasiswa_id" placeholder="Cari Mahasiswa..."
                                    class="w-full px-2 py-1  rounded-md shadow-2xl sm:text-sm">
                                    <option></option>
                                    @foreach ($mahasiswaList as $mhs)
                                        <option value="{{ $mhs->NIM }}">{{ $mhs->NIM }} - {{ $mhs->nama }}
                                        </option>
                                    @endforeach
                                </x-select2>
                                @error('mahasiswa_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Select KRS -->
                            <div class="mb-4">
                                <label for="krs_id" class="block text-sm font-medium text-gray-700">Pilih KRS</label>
                                <select id="krs_id" wire:model.live="krs_id"
                                    class="w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                    <option></option>
                                    @foreach ($listKRS as $krs)
                                        <option value="{{ $krs->id_krs }}">
                                            {{ ($krs->matkul->nama_mata_kuliah ?? 'Mata Kuliah Tidak Ditemukan') . " (".$krs->matkul->dosen->nama_dosen .")"}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('krs_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Nilai -->
                            <div class="mb-4">
                                <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai</label>
                                <input type="text" wire:model="nilai" id="nilai"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nilai')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- keterangan -->
                            <div class="mb-4">
                                <label for="keterangan"
                                    class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <input type="text" wire:model="keterangan" id="keterangan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('keterangan')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Upload File -->
                            <div class="mb-4">
                                <label for="file" class="block text-sm font-medium text-gray-700">Upload
                                    File</label>
                                <input type="file" wire:model="file" id="file"
                                    class="block w-full px-2 py-1 mt-1 bg-white border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('file')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Buttons -->
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
</div>
