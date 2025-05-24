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
            <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                    <h3 class="text-xl font-semibold">Edit Presensi</h3>
                    <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                        <button class="text-gray-900">&times;</button>
                    </div>
                </div>
                <div class="p-4 text-left">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <form wire:submit="update">
                            <input type="text" hidden wire:model="id_presensi">

                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama
                                    Mahasiswa</label>
                                <input type="text" id="nama" wire:model="nama" name="nama"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nama')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                                <input type="number" id="nim" wire:model="nim" name="nim"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nim')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <select id="keterangan" wire:model.change="keterangan" name="keterangan"
                                    class="block w-full py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 px-2 sm:text-sm">
                                    <option value="">Select</option>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Alpha">Alpha</option>
                                    <option value="Ijin">Ijin</option>
                                    <option value="Sakit">Sakit</option>
                                </select>
                                @error('keterangan')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Input alasan hanya muncul saat Ijin --}}
                            @if ($keterangan === 'Ijin')
                                <div class="mb-4 transition-all duration-300 ease-in-out">
                                    <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan</label>
                                    <input type="text" id="alasan" wire:model="alasan" name="alasan"
                                        class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                    @error('alasan')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <!-- Submit Button inside the form -->
                            <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                                <button type="button" wire:click="clear({{ $id_presensi }})" @click="isOpen = false"
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
