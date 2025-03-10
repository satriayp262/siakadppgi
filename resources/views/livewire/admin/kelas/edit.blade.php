<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true" class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700"><svg
            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg>
    </button>

    <div>
        <!-- Modal Background -->
        <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
            <div class="w-1/2 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                    <h3 class="text-xl font-semibold">Edit Kelas</h3>
                    <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                        <button class="text-gray-900">&times;</button>
                    </div>
                </div>
                <div class="p-4 text-left">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <form wire:submit="update">
                            <input type="text" hidden wire:model="id_kelas">
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
                                <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Nama
                                    Prodi</label>
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
                            <div class="mb-4">
                                <label for="nama_kelas" class="block text-sm font-medium text-gray-700">Nama
                                    Kelas</label>
                                <input type="text" id="nama_kelas" wire:model="nama_kelas" name="nama_kelas"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nama_kelas')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

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
                                <label for="mode_kuliah" class="block text-sm font-medium text-gray-700">Mode
                                    Kuliah</label>
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
                                <button type="button" wire:click="clear({{ $id_kelas }})"
                                    @click="isOpen = false"
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
