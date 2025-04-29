<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true" class="inline-block px-3 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-800">
        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg>
    </button>

    <!-- Modal Background -->
    <div x-show="isOpen" x-transition.opacity x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 rounded-t-lg bg-customPurple">
                <h3 class="text-xl font-semibold text-white">Edit Komponen Kartu Ujian</h3>
                <button @click="isOpen=false" wire:click="clear({{ $id_komponen }})" class="text-lg text-white">&times;</button>
            </div>

            <!-- Modal Content -->
            <div>
                    <form wire:submit="update" class="p-6 space-y-6 bg-white shadow-md rounded-xl" enctype="multipart/form-data">
                        <input type="hidden" wire:model="id_komponen">

                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block mb-1 text-sm font-semibold text-gray-800 text-start">Nama</label>
                            <input type="text" id="nama" wire:model="nama" name="nama"
                                class="w-full px-4 py-2 text-sm text-gray-800 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label for="jabatan" class="block mb-1 text-sm font-semibold text-gray-800 text-start">Jabatan</label>
                            <input type="text" id="jabatan" wire:model="jabatan" name="jabatan"
                                class="w-full px-4 py-2 text-sm text-gray-800 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('jabatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- TTD (File Upload) -->
                        <div>
                            <label for="ttd" class="block mb-1 text-sm font-semibold text-gray-800 text-start">TTD (Gambar)</label>
                            <input type="file" id="ttd" wire:model="ttd" name="ttd"
                                class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('ttd') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" @click="isOpen=false" wire:click="clear({{ $id_komponen }})"
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
