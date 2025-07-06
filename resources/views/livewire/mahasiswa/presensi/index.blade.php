<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button -->
    <button @click="isOpen=true"
        class="flex items-center px-2 py-1 text-sm font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <span>Presensi</span>
    </button>

    <!-- Modal -->
    <div x-show="isOpen" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="isOpen = false" class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-2 bg-gray-200 rounded-t">
                <h2 class="text-lg font-semibold text-left">Presensi Mahasiswa</h2>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500 cursor-pointer">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <form wire:submit.prevent="submit">
                <div class="p-4 space-y-4 max-h-[70vh] overflow-y-auto">

                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama" wire:model="nama"
                            class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" id="nim" wire:model="nim"
                            class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="token" class="block text-sm font-medium text-gray-700">Token</label>
                        <input type="text" id="token" wire:model="token"
                            class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500">
                        @error('token')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <div class="mt-2 flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" id="hadir" wire:model.live="keterangan" value="Hadir"
                                    class="form-radio h-4 w-4 text-indigo-600" onclick="toggleRadio(event, this)">
                                <span class="ml-2">Hadir</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" id="ijin" wire:model.live="keterangan" value="Ijin"
                                    class="form-radio h-4 w-4 text-indigo-600" onclick="toggleRadio(event, this)">
                                <span class="ml-2">Ijin</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" id="sakit" wire:model.live="keterangan" value="Sakit"
                                    class="form-radio h-4 w-4 text-indigo-600" onclick="toggleRadio(event, this)">
                                <span class="ml-2">Sakit</span>
                            </label>
                        </div>
                        @error('keterangan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($keterangan == 'Ijin')
                        <div class="mb-4">
                            <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan</label>
                            <input type="text" id="alasan" wire:model="alasan"
                                class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500">
                            @error('alasan')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="flex justify-end px-4 py-2 bg-gray-100 rounded-b">
                    <button type="button" @click="isOpen = false"
                        class="px-4 py-2 font-semibold text-white bg-red-500 rounded hover:bg-red-600">Tutup</button>
                    <button type="submit"
                        class="px-4 py-2 ml-2 font-semibold text-white bg-green-500 rounded hover:bg-green-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
