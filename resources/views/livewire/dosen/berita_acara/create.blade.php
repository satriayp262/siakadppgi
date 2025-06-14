<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-4 h-4 text-white dark:text-white font-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="10" height="10" fill="none" viewBox="0 0 24 24">
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
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Berita Acara</h3>
                <button @click="isOpen=false"
                    class="text-gray-900 px-3 rounded-sm shadow hover:bg-red-500">&times;</button>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit.prevent="save">
                        <div class="mb-4">
                            <label for="tanggal"
                                class="block text-sm font-medium text-gray-700 text-left">Tanggal</label>
                            <input type="date" id="tanggal" wire:model="tanggal" name="tanggal"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('tanggal')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_dosen" class="block text-sm font-medium text-gray-700 text-left">Nama
                                Dosen</label>
                            <input type="text" id="nama_dosen" name="nama_dosen" value="{{ $nama_dosen }}" disabled
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="id_mata_kuliah" class="block text-sm font-medium text-gray-700 text-left">Mata
                                Kuliah</label>
                            <input type="text" id="id_mata_kuliah" name="id_mata_kuliah" value="{{ $nama_mata_kuliah }}" disabled
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="id_kelas"
                                class="block text-sm font-medium text-gray-700 text-left">Kelas</label>
                            <input type="text" id="id_kelas" name="id_kelas" value="{{ $nama_kelas }}" disabled
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="materi"
                                class="block text-sm font-medium text-gray-700 text-left">Materi</label>
                            <textarea id="materi" wire:model="materi" name="materi"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm"></textarea>
                            @error('materi')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jumlah_mahasiswa"
                                class="block text-sm font-medium text-gray-700 text-left">Jumlah
                                Mahasiswa</label>
                            <input type="text" id="jumlah_mahasiswa" wire:model="jumlah_mahasiswa"
                                name="jumlah_mahasiswa"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-sm focus:border-indigo-500 sm:text-sm">
                            @error('jumlah_mahasiswa')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                            <button type="button" @click="isOpen = false"
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
