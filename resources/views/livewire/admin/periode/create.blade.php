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
        <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Set Periode Pengisian Emonev</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="save">
                        <!-- Input Form inside the form -->
                        <div class="mb-4">
                            <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                            <select id="semester" wire:model.live="id_semester" name="semester"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="">Select</option>
                                @foreach ($semesters as $semester1)
                                    <option value="{{ $semester1->id_semester }}">{{ $semester1->nama_semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="ml-2 mt-2">
                            <h2 class="text-base font-semibold text-gray-800 mb-2 border-b pb-1">Sesi Pertama</h2>
                            <div class="mb-4">
                                <label for="tanggal_mulai_1" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai</label>
                                <input type="date" wire:model="tanggal_mulai_1" name="tanggal_mulai_1"
                                    id="tanggal_mulai_1"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('tanggal_mulai_1')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_selesai_1" class="block text-sm font-medium text-gray-700">Tanggal
                                    Selesai</label>
                                <input type="date" wire:model="tanggal_selesai_1" name="tanggal_selesai_1"
                                    id="tanggal_selesai_1"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('tanggal_selesai_1')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="ml-2">
                            <h2 class=" text-base font-semibold text-gray-800 mb-2 border-b pb-1">Sesi Kedua</h2>
                            {{-- <div class="mb-4">
                                <label for="sesi_2" class="block text-sm font-medium text-gray-700">Sesi
                                    Kedua</label>
                                <input hidden disabled type="number" wire:model="sesi_2" name="sesi_2" id="sesi_2"
                                    value="2"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('sesi_2')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <div class="mb-4">
                                <label for="tanggal_mulai_2" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai</label>
                                <input type="date" wire:model="tanggal_mulai_2" name="tanggal_mulai_2"
                                    id="tanggal_mulai_2"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('tanggal_mulai_2')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_selesai_2" class="block text-sm font-medium text-gray-700">Tanggal
                                    Selesai</label>
                                <input type="date" wire:model="tanggal_selesai_2" name="tanggal_selesai_2"
                                    id="tanggal_selesai_2"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('tanggal_selesai_2')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
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
