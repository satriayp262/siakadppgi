<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
        <!-- Button to open the modal -->
        <button @click="isOpen=true"
            class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
            Buat Jadwal
        </button>
        <!-- Modal Background -->
            <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
                <!-- Modal Content -->
                <div class="w-1/2 bg-white rounded-lg shadow-lg">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                        <h3 class="text-xl font-semibold">Pilih Semester</h3>
                        <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                            <button class="text-gray-900">&times;</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="p-4 max-h-[500px] overflow-y-auto">
                            <div class="grid grid-cols-4 gap-4 mb-4">
                                @foreach ($semesters as $z)
                                    <button type="button" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                                            wire:click="pilihSemester({{ $z->id_semester }})">
                                        {{ $z->nama_semester }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>