<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        Buat Token
    </button>

    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Buat Token</h3>
                <button @click="isOpen=false"
                    class="text-gray-900 px-3 rounded-sm shadow hover:bg-red-500">&times;</button>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit.prevent="save">
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
                            <label for="valid_until">Berlaku Hingga</label>
                            <input type="datetime-local" wire:model="valid_until" class="border p-2 rounded w-full"
                                required />
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
