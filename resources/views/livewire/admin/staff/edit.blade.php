<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="inline-block px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-700"><svg
            class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg>
    </button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <div wire:loading wire:target="update"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
            <div class="spinner loading-spinner"></div>
        </div>
        <!-- Modal Content -->
        <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Edit Data Staff</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4 text-left"> <!-- Added text-left here -->
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="update">
                        <input type="text" hidden wire:model="id_staff">
                        <div class="mb-4">
                            <label for="nama_staff" class="block text-sm font-medium text-gray-700">
                                Nama Staff</label>
                            <input type="text" id="nama_staff" wire:model="nama_staff" name="nama_staff"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('nama_staff')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email</label>
                            <input type="email" id="email" wire:model="email" name="email"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('email')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nip" class="block text-sm font-medium text-gray-700">
                                NIP</label>
                            <input type="text" id="nip" wire:model="nip" name="nip"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('nip')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($ttd)
                            <div class="mb-4">
                                <label for="ttd">Tanda Tangan</label>
                                <img src="{{ asset(path: 'storage/image/ttd/' . $ttd) }}" alt="TTD"
                                    class="w-24 h-24 rounded shadow">
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="ttd_baru" class="block text-sm font-medium text-gray-700">
                                Jika ingin Mengubah TTD</label>
                            <input type="file" id="ttd_baru" wire:model="ttd_baru" name="ttd_baru"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @if ($ttd_baru)
                                <div class="mt-2">
                                    <img src="{{ $ttd_baru->temporaryUrl() }}" class="w-32 h-32 rounded shadow">
                                </div>
                            @endif
                            @error('ttd_baru')
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
