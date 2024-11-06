<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg>
    </button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Data Kurikulum</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4 text-left">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="update">
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
