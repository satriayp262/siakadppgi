<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button -->
    <button @click="isOpen=true" class="flex items-center p-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </button>

    <!-- Modal -->
    <div x-show="isOpen" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="isOpen = false" class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-2 bg-gray-200 rounded-t">
                <h2 class="text-lg font-semibold text-left">Edit Berita Acara</h2>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500 cursor-pointer">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>

            <!-- Body -->
            <form wire:submit.prevent="update">
                <div class="p-4 space-y-4 max-h-[70vh] overflow-y-auto">

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Pertemuan</label>
                        <input type="text" class="w-full px-3 py-2 border rounded bg-gray-100"
                            value="{{ $pertemuan }}" readonly>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Tanggal</label>
                        <input type="text" class="w-full px-3 py-2 border rounded bg-gray-100"
                            value="{{ $tanggal }}" readonly>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Sesi</label>
                        <input type="text" class="w-full px-3 py-2 border rounded bg-gray-100"
                            value="{{ $sesi }}" readonly>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Mata Kuliah</label>
                        <input type="text" class="w-full px-3 py-2 border rounded bg-gray-100"
                            value="{{ $nama_mata_kuliah }}" readonly>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Kelas</label>
                        <input type="text" class="w-full px-3 py-2 border rounded bg-gray-100"
                            value="{{ $nama_kelas }}" readonly>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Jumlah Mahasiswa</label>
                        <input type="text" class="w-full px-3 py-2 border rounded bg-gray-100"
                            value="{{ $jumlah_mahasiswa }}" readonly>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Materi</label>
                        <textarea wire:model="materi" rows="3" class="w-full px-3 py-2 border rounded resize-none"></textarea>
                        @error('materi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-left">Keterangan</label>
                        <input wire:model="keterangan" class="w-full px-3 py-2 border rounded"></input>
                        @error('keterangan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end px-4 py-2 bg-gray-100 rounded-b">
                    <button type="button" @click="isOpen = false"
                        class="px-4 py-2 font-semibold text-white bg-red-500 rounded hover:bg-red-600">Tutup</button>
                    <button type="submit"
                        class="px-4 py-2 ml-2 font-semibold text-white bg-green-500 rounded hover:bg-green-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
