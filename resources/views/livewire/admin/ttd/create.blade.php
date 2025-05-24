<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-6 h-6 mr-2 text-white font-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14"
            height="14" fill="none" viewBox="0 0 24 24">
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
                <h3 class="text-xl font-semibold">Tambah Staff</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 text-left"> <!-- Added text-left here -->
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <input type="text" hidden wire:model="nim">
                        <form wire:submit="save" class="space-y-6 rounded-xl" enctype="multipart/form-data">
                            <input type="hidden" wire:model="id_ttd">

                            <!-- Nama -->
                            <div>
                                <label for="nama"
                                    class="block mb-1 text-sm font-semibold text-gray-800 text-start">Nama</label>
                                <input type="text" id="nama" wire:model="nama" name="nama"
                                    class="w-full px-4 py-2 text-sm text-gray-800 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div>
                                <label for="jabatan"
                                    class="block mb-1 text-sm font-semibold text-gray-800 text-start">Jabatan</label>
                                <input type="text" id="jabatan" wire:model="jabatan" name="jabatan"
                                    class="w-full px-4 py-2 text-sm text-gray-800 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @error('jabatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TTD (File Upload) -->
                            <div x-data="{ uploading: false }" x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false">
                                <label for="ttd"
                                    class="block mb-1 text-sm font-semibold text-gray-800 text-start">TTD
                                    (Gambar)</label>
                                <input type="file" id="ttd" wire:model="ttd" name="ttd"
                                    class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                @error('ttd')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <div x-show="uploading" class="mt-2">
                                    <div class="flex flex-row items-center w-full mt-2 space-x-2">
                                        <div class="spinner"></div>
                                        <div class="spinner-text">Memproses Permintaan...</div>
                                    </div>
                                </div>
                            </div>


                            <!-- Buttons -->
                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" @click="isOpen=false"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                    Close
                                </button>
                                <button type="submit" @click="isOpen=false"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700">
                                    Submit
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
