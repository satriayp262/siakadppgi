<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true" class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg>
    </button>

    <div>
        <!-- Modal Background -->
        <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
            <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                    <h3 class="text-xl font-semibold">Edit Dosen</h3>
                    <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                        <button class="text-gray-900">&times;</button>
                    </div>
                </div>
                <div class="p-4 text-left">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <form wire:submit.prevent="update">
                            <!-- ID Dosen -->
                            <input type="text" hidden wire:model="id_dosen">

                            <!-- Nama Dosen -->
                            <div class="mb-4">
                                <label for="nama_dosen_{{ $id_dosen }}" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                                <input type="text" id="nama_dosen_{{ $id_dosen }}" wire:model="nama_dosen" name="nama_dosen"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nama_dosen')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- NIDN -->
                            <div class="mb-4">
                                <label for="nidn_{{ $id_dosen }}" class="block text-sm font-medium text-gray-700">NIDN</label>
                                <input type="number" id="nidn_{{ $id_dosen }}" wire:model="nidn" name="nidn"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nidn')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-4">
                                <label for="jenis_kelamin_{{ $id_dosen }}" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select id="jenis_kelamin_{{ $id_dosen }}" wire:model="jenis_kelamin" name="jenis_kelamin"
                                    class="block w-full py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring px-2 focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                    <option value="" disabled selected>Select</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jabatan Fungsional -->
                            <div class="mb-4">
                                <label for="jabatan_fungsional_{{ $id_dosen }}" class="block text-sm font-medium text-gray-700">Jabatan Fungsional</label>
                                <input type="text" id="jabatan_fungsional_{{ $id_dosen }}" wire:model="jabatan_fungsional" name="jabatan_fungsional"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('jabatan_fungsional')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kepangkatan -->
                            <div class="mb-4">
                                <label for="kepangkatan_{{ $id_dosen }}" class="block text-sm font-medium text-gray-700">Kepangkatan</label>
                                <input type="text" id="kepangkatan_{{ $id_dosen }}" wire:model="kepangkatan" name="kepangkatan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('kepangkatan')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nama Prodi -->
                            <div class="mb-4">
                                <label for="kode_prodi_{{ $id_dosen }}" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                                <select id="kode_prodi_{{ $id_dosen }}" wire:model="kode_prodi" name="kode_prodi"
                                    class="block w-full py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring px-2 focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($prodis as $p)
                                        <option value="{{ $p->kode_prodi }}">{{ $p->nama_prodi }}</option>
                                    @endforeach
                                </select>
                                @error('kode_prodi')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                                <button type="button" wire:click="clear({{ $id_dosen }})" @click="isOpen = false"
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
