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
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Data Kelas</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="save">
                        <div class="mb-4">
                            <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                            <select id="semester" wire:model.live="semester" name="semester"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                @foreach ($Semester as $semester1)
                                    <option value="{{ $semester1->id_semester }}">{{ $semester1->nama_semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                            <select id="kode_prodi" wire:model.live="kode_prodi" name="kode_prodi"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                @foreach ($prodi as $p)
                                    <option value="{{ $p->kode_prodi }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                            @error('kode_prodi')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- <div class="mb-4">
                            <label for="nama_kelas" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                            <input type="text" id="nama_kelas" wire:model="nama_kelas" name="nama_kelas"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('nama_kelas')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        <div class="mb-4">
                            <label for="bahasan" class="block text-sm font-medium text-gray-700">Bahasan</label>
                            <input type="text" id="bahasan" wire:model="bahasan" name="bahasan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('bahasan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="lingkup_kelas" class="block text-sm font-medium text-gray-700">Lingkup
                                Kelas</label>
                            <select id="lingkup_kelas" wire:model="lingkup_kelas" name="lingkup_kelas"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                <option value="1">Internal</option>
                                <option value="2">Eksternal</option>
                                <option value="3">Campuran</option>
                            </select>
                            @error('lingkup_kelas')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="mode_kuliah" class="block text-sm font-medium text-gray-700">Mode Kuliah</label>
                            <select id="mode_kuliah" wire:model="mode_kuliah" name="mode_kuliah"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                <option value="O">Online</option>
                                <option value="F">Offline</option>
                                <option value="M">Campuran</option>
                            </select>
                            @error('mode_kuliah')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
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
