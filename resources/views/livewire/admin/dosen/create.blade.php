<div x-data="{ isOpen: false, load: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen = true; load = true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-6 h-6 mr-2 text-white font-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14"
            height="14" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M5 12h14m-7 7V5" />
        </svg>
        Tambah
    </button>

    <!-- Modal -->
    <div x-show="isOpen && load" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Dosen</h3>
                <button @click="isOpen = false"
                    class="text-gray-900 px-3 py-1 hover:bg-red-500 rounded-sm">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 max-h-[500px] overflow-y-auto">
                <form wire:submit.prevent="save">
                    <!-- Nama Dosen -->
                    <div class="mb-4">
                        <label for="nama_dosen" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                        <input type="text" id="nama_dosen" wire:model="nama_dosen" name="nama_dosen"
                            class="block w-full px-2 py-1 mt-1 bg-gray-200 border border-gray-400 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                        @error('nama_dosen')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIDN -->
                    <div class="mb-4">
                        <label for="nidn" class="block text-sm font-medium text-gray-700">NIDN</label>
                        <input type="text" id="nidn" wire:model="nidn" name="nidn"
                            class="block w-full px-2 py-1 mt-1 bg-gray-200 border border-gray-400 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                        @error('nidn')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-4">
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select id="jenis_kelamin" wire:model="jenis_kelamin" name="jenis_kelamin"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border border-gray-400 rounded-md focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled selected>Pilih</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jabatan Fungsional -->
                    <div class="mb-4">
                        <label for="jabatan_fungsional" class="block text-sm font-medium text-gray-700">Jabatan
                            Fungsional</label>
                        <input type="text" id="jabatan_fungsional" wire:model="jabatan_fungsional"
                            class="block w-full px-2 py-1 mt-1 bg-gray-200 border border-gray-400 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                        @error('jabatan_fungsional')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kepangkatan -->
                    <div class="mb-4">
                        <label for="kepangkatan" class="block text-sm font-medium text-gray-700">Kepangkatan</label>
                        <input type="text" id="kepangkatan" wire:model="kepangkatan"
                            class="block w-full px-2 py-1 mt-1 bg-gray-200 border border-gray-400 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                        @error('kepangkatan')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Prodi -->
                    <div class="mb-4">
                        <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                        <select id="kode_prodi" wire:model="kode_prodi"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border border-gray-400 rounded-md focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled selected>Pilih</option>
                            @foreach ($prodis as $p)
                                <option value="{{ $p->kode_prodi }}">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                        @error('kode_prodi')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Modal Footer Buttons -->
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
