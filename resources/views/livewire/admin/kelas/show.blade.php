<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="px-3 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700"><svg
            class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2"
                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg></button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg ">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Data Kelas</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <div class="grid grid-cols-4">
                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="semester" class="block text-sm font-medium text-gray-700">
                                    Semester</label>
                                <p class="text-sm text-gray-500">
                                    {{ $kelases->Semester->nama_semester ?? 'Data Belum Ada' }}</p>
                            </div>
                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="nama_kelas" class="block text-sm font-medium text-gray-700">Nama
                                    Kelas</label>
                                <p class="text-sm text-gray-500">{{ $kelases->nama_kelas ?? 'Data Belum Ada' }}</p>
                            </div>
                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="lingkup_kelas" class="block text-sm font-medium text-gray-700">Lingkup
                                    Kelas</label>
                                <p class="text-sm text-gray-500">
                                    @if ($kelases->lingkup_kelas == 1)
                                        Internal
                                    @elseif($kelases->lingkup_kelas == 2)
                                        Eksternal
                                    @elseif($kelases->lingkup_kelas == 3)
                                        Campuran
                                    @else
                                        Data Belum Ada
                                    @endif
                                </p>
                            </div>

                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="nama_kelas" class="block text-sm font-medium text-gray-700">Mode
                                    Kuliah</label>
                                <p class="text-sm text-gray-500">
                                    @if ($kelases->mode_kuliah == 'O')
                                        Online
                                    @elseif($kelases->mode_kuliah == 'F')
                                        Offline
                                    @elseif($kelases->mode_kuliah == 'M')
                                        Campuran
                                    @else
                                        Data Belum Ada
                                    @endif
                                </p>
                            </div>
                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="bahasan" class="block text-sm font-medium text-gray-700">Bahasan</label>
                                <p class="text-sm text-gray-500">
                                    {{ $kelases->bahasan ?? 'Data Belum Ada' }}</p>
                            </div>
                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="kode_prodi" class="block text-sm font-medium text-gray-700">
                                    Prodi</label>
                                <p class="text-sm text-gray-500">{{ $kelases->prodi->nama_prodi ?? 'Data Belum Ada' }}
                                </p>
                            </div>
                            <div class="w-full h-full p-2 mb-4 text-left border">
                                <label for="prodi" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                                <p class="text-sm text-gray-500">{{ $kelases->prodi->nama_prodi ?? 'Data Belum Ada' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
