<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true" class="inline-block px-3 py-2 text-white bg-blue-500 rounded hover:bg-blue-700"><svg
            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg></button>
    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tukar Jadwal</h3>
                <div @click="isOpen=false" wire:click="clear({{ $id_jadwal }})"
                    class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4 text-left"> <!-- Added text-left here -->
                <div class="p-4 max-h-[500px]">
                    <div class="pb-2 ml-2">
                        @foreach ($ammo as $k)
                            <span>
                                {{ $k->sesi }} | 
                                @if ($k->hari == "Monday")
                                    Senin
                                @elseif ($k->hari == "Tuesday")
                                    Selasa
                                @elseif ($k->hari == "Wednesday")
                                    Rabu
                                @elseif ($k->hari == "Thursday")
                                    Kamis
                                @elseif ($k->hari == "Friday")
                                    Jumat
                                @endif
                                | {{ $k->kode_prodi }} | {{ $k->kelas->nama_kelas }}
                            </span>
                        @endforeach
                    </div>
                    <select name="target" id="target" wire:model.live="target" class="items-center px-4 py-2 pr-2 ml-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        <option value="" selected>Pilih Jadwal yang akan ditukar</option>
                        @foreach ($jadwals as $x)
                        <option value="{{ $x->id_jadwal }}">{{ $x->sesi }} | 
                            @if ($x->hari == "Monday")
                                Senin
                            @elseif ($x->hari == "Tuesday")
                                Selasa
                            @elseif ($x->hari == "Wednesday")
                                Rabu
                            @elseif ($x->hari == "Thursday")
                                Kamis
                            @elseif ($x->hari == "Friday")
                                Jumat
                            @endif
                            | {{ $x->kode_prodi }} | {{ $x->kelas->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                    <button wire:click="tukar()" class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Tukar</button>
                </div>
            </div>
        </div>
    </div>
</div>