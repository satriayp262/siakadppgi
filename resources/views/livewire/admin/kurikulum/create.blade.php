<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white font-black" aria-hidden="true"
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
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Data Kurikulum</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="save">
                        <div class="mb-4">
                            <label for="nama_kurikulum" class="block text-sm font-medium text-gray-700">Nama
                                Kurikulum</label>
                            <input type="text" id="nama_kurikulum" wire:model="nama_kurikulum" name="nama_kurikulum"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('nama_kurikulum')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="mulai_berlaku" class="block text-sm font-medium text-gray-700">Mulai
                                Berlaku</label>
                            <select id="mulai_berlaku" wire:model="mulai_berlaku" name="mulai_berlaku"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled selected>Pilih Semester</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id_semester }}">
                                        {{ $semester->nama_semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mulai_berlaku')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jumlah_sks_lulus" class="block text-sm font-medium text-gray-700">Jumlah SKS
                                Lulus</label>
                            <input type="text" id="jumlah_sks_lulus" wire:model="jumlah_sks_lulus"
                                name="jumlah_sks_lulus"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jumlah_sks_lulus')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jumlah_sks_wajib" class="block text-sm font-medium text-gray-700">Jumlah SKS
                                Wajib</label>
                            <input type="text" id="jumlah_sks_wajib" wire:model="jumlah_sks_wajib"
                                name="jumlah_sks_wajib"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jumlah_sks_wajib')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror


                        </div>

                        <div class="mb-4">
                            <label for="jumlah_sks_pilihan" class="block text-sm font-medium text-gray-700">Jumlah SKS
                                Pilihan</label>
                            <input type="text" id="jumlah_sks_pilihan" wire:model="jumlah_sks_pilihan"
                                name="jumlah_sks_pilihan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jumlah_sks_pilihan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Prodi</label>
                            <select id="kode_prodi" wire:model="kode_prodi" name="kode_prodi"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled selected>Pilih Prodi</option>
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}">
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_prodi')
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
