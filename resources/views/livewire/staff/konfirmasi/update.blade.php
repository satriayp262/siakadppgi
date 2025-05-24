<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-3 py-1 font-sm text-white bg-purple2 rounded hover:bg-customPurple">
        {{-- <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white font-black" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M5 12h14m-7 7V5" />
        </svg> --}}

        Update Status
    </button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Buat Tagihan</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 text-left"> <!-- Added text-left here -->
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <input type="text" hidden wire:model="id_konfirmasi">
                        <form wire:submit="save">
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama
                                    Mahasiswa</label>
                                <input type="text" disabled id="nama" wire:model="nama" name="nama"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nama')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                                <input type="text" disabled id="nim" wire:model="nim" name="nim"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nim')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="mb-4">
                                <label for="jenis_tagihan" class="block text-sm font-medium text-gray-700">Jenis
                                    Tagihan</label>
                                <input type="text" id="jenis_tagihan" wire:model="jenis_tagihan" name="jenis_tagihan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm"></input>
                                @error('Keterangan')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="Bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                                <input type="month" id="Bulan" wire:model="Bulan" name="Bulan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('Bulan')
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
</div>
