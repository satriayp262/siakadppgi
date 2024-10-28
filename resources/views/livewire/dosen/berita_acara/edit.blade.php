<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true" class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg>
    </button>
    <div>
        <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
            <div class="w-1/2 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                    <h3 class="text-xl font-semibold">Edit Dosen</h3>
                    <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500 cursor-pointer">
                        <button class="text-gray-900">&times;</button>
                    </div>
                </div>
                <div class="p-4 text-left">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <form wire:submit.prevent="update">
                            <input type="text" hidden wire:model="id_berita_acara">

                            <div class="mb-4">
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" id="tanggal" wire:model="tanggal" name="tanggal"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('tanggal')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nidn" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                                <input type="text" id="nidn" value="{{ $nama_dosen }}" disabled
                                    name="nidn"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nidn')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="id_mata_kuliah" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                                <select id="id_mata_kuliah" wire:model="id_mata_kuliah" name="id_mata_kuliah"
                                    class="block w-full py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring px-2 focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($matkul as $m)
                                        <option value="{{ $m->id_mata_kuliah }}">{{ $m->nama_mata_kuliah }}</option>
                                    @endforeach
                                </select>
                                @error('id_mata_kuliah')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="materi" class="block text-sm font-medium text-gray-700">Materi</label>
                                <textarea id="materi" wire:model="materi" name="materi"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('materi')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="jumlah_mahasiswa" class="block text-sm font-medium text-gray-700">Jumlah Mahasiswa</label>
                                <input type="number" id="jumlah_mahasiswa" wire:model="jumlah_mahasiswa"
                                    name="jumlah_mahasiswa"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('jumlah_mahasiswa')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                                <button type="button" wire:click="clear({{ $id_berita_acara }})"
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
