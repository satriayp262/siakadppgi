<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true"
        class="inline-block px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-700">Edit</button>

    <div>
        <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
            <div class="w-1/2 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                    <h3 class="text-xl font-semibold">Edit Dosen</h3>
                    <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                        <button class="text-gray-900">&times;</button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <form wire:submit="update">
                            <input type="text" hidden wire:model="id_dosen">

                            <div class="mb-4">
                                <label for="nama_dosen" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                                <input type="text" id="nama_dosen" wire:model="nama_dosen"
                                    name="nama_dosen"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nama_dosen')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nidn" class="block text-sm font-medium text-gray-700">NIDN</label>
                                <input type="number" id="nidn" wire:model="nidn"
                                    name="nidn"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nidn')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis
                                    Kelamin</label>
                                <select id="jenis_kelamin" wire:model="jenis_kelamin" name="jenis_kelamin"
                                    class="block w-full py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring px-2focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                    <option value="" disabled selected>Select</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="jabatan_fungsional" class="block text-sm font-medium text-gray-700">Jabatan Fungsional</label>
                                <input type="text" id="jabatan_fungsional" wire:model="jabatan_fungsional"
                                    name="jabatan_fungsional"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('jabatan_fungsional')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="kepangkatan" class="block text-sm font-medium text-gray-700">Kepangkatan</label>
                                <input type="text" id="kepangkatan" wire:model="kepangkatan" name="kepangkatan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('kepangkatan')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Kode Prodi</label>
                                <select id="kode_prodi" wire:model="kode_prodi" name="kode_prodi"
                                    class="block w-full py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring px-2focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                    <option value="" disabled selected>Select</option>
                                    <option value="1">1</option>
                                <option value="2">2</option>
                                </select>
                                @error('kode_prodi')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button inside the form -->
                            <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                                <button type="button" wire:click="clear({{ $id_dosen }})"
                                    @click="isOpen = false"
                                    class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Close</button>
                                <button type="submit" @click="isOpen = false"
                                    class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
