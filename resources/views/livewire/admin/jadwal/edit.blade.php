<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    {{-- @php
        $edit = $request->contains(function ($item) use ($ammo) {
            return $item->nidn == $ammo->nidn && $item->id_mata_kuliah == $ammo->id_mata_kuliah && $item->hari == $ammo->hari && $item->sesi == $ammo->sesi && $item->status == "edit";
        });

        $ok = $request->contains(function ($item) use ($ammo) {
            return $item->nidn == $ammo->nidn && $item->id_mata_kuliah == $ammo->id_mata_kuliah && $item->hari == $ammo->hari && $item->sesi == $ammo->sesi && $item->status == "ok";
        });
    @endphp --}}

    @if ($l)
        <button @click="isOpen=true" class="inline-block px-3 py-2 text-white transition bg-yellow-600 rounded-lg hover:bg-yellow-800">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
            </svg>
        </button>
    @elseif ($ok)
        <button @click="isOpen=true" class="inline-block px-3 py-2 text-white transition bg-green-600 rounded-lg hover:bg-green-800">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
            </svg>
        </button>
    @else
        <button @click="isOpen=true" class="inline-block px-3 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-800">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
            </svg>
        </button>
    @endif


    <!-- Modal Background -->
    <div x-show="isOpen" x-transition.opacity x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-blue-600 rounded-t-lg">
                <h3 class="text-xl font-semibold text-white">Edit Jadwal</h3>
                <button @click="isOpen=false" wire:click="clear({{ $id_jadwal }})" class="text-lg text-white">&times;</button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-black border border-collapse border-gray-300 table-auto">
                        <thead class="bg-customPurple">
                            <tr>
                                <th class="px-4 py-2 text-white border border-gray-300">Hari</th>
                                <th class="px-4 py-2 text-white border border-gray-300">Sesi</th>
                                <th class="px-4 py-2 text-white border border-gray-300">Mata Kuliah</th>
                                <th class="px-4 py-2 text-white border border-gray-300">Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 border border-gray-300">
                                    @if ($ammo->hari == "Monday")
                                        Senin
                                    @elseif ($ammo->hari == "Tuesday")
                                        Selasa
                                    @elseif ($ammo->hari == "Wednesday")
                                        Rabu
                                    @elseif ($ammo->hari == "Thursday")
                                        Kamis
                                    @elseif ($ammo->hari == "Friday")
                                        Jumat
                                    @endif
                                </td>
                                <td class="px-4 py-2 border border-gray-300">{{ $ammo->sesi }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $ammo->matakuliah->nama_mata_kuliah }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $ammo->dosen->nama_dosen }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if ($l)
                    <div>
                        <span>
                            Ingin diganti menjadi hari
                            @if ($editRequest->to_hari)
                                <b>
                                    @switch($editRequest->to_hari)
                                        @case('Monday') Senin @break
                                        @case('Tuesday') Selasa @break
                                        @case('Wednesday') Rabu @break
                                        @case('Thursday') Kamis @break
                                        @case('Friday') Jumat @break
                                    @endswitch
                                </b>
                            @endif
                            dan sesi <b>{{ $editRequest->to_sesi }}</b>
                        </span>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-4">
                    <button wire:click='switch' class="px-4 py-2 font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-800">Tukar Jadwal</button>
                    <button wire:click='ganti' class="px-4 py-2 font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-800">Ganti Hari/Sesi</button>
                </div>

                <!-- Form Handling -->
                @if ($edit == 'switch')
                    <form wire:submit='tukar' class="space-y-4">
                        <select wire:model.live="target" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" selected>Pilih Jadwal yang akan ditukar</option>
                            <option value="" disabled class="text-white bg-customPurple">Hari  /   Sesi   /   Mata Kuliah   /   Dosen</option>
                            @foreach ($jadwals as $x)
                                <option value="{{ $x->id_jadwal }}">
                                    @if ($x->hari == "Monday")
                                        Senin /
                                    @elseif ($x->hari == "Tuesday")
                                        Selasa /
                                    @elseif ($x->hari == "Wednesday")
                                        Rabu /
                                    @elseif ($x->hari == "Thursday")
                                        Kamis /
                                    @elseif ($x->hari == "Friday")
                                        Jumat /
                                    @endif
                                    {{ $x->sesi }} / {{ $x->matakuliah->nama_mata_kuliah }} / {{ $x->dosen->nama_dosen }}
                                </option>
                            @endforeach
                        </select>
                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="isOpen=false" wire:click="clear({{ $id_jadwal }})" class="px-4 py-2 font-bold text-white transition bg-red-600 rounded-lg hover:bg-red-800">Close</button>
                            <button type="submit" @click="isOpen=false" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800">Submit</button>
                        </div>
                    </form>
                @elseif ($edit == 'ganti')
                    <form wire:submit='update' class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <select wire:model.live="z" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" selected>Pilih Hari</option>
                                    <option value="Monday">Senin</option>
                                    <option value="Tuesday">Selasa</option>
                                    <option value="Wednesday">Rabu</option>
                                    <option value="Thursday">Kamis</option>
                                    <option value="Friday">Jumat</option>
                                </select>
                                @error('z') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <select wire:model.live="x" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" selected>Pilih Sesi</option>
                                    <option value="1">sesi 1, jam 08.00-09.30</option>
                                    <option value="2">sesi 2, jam 09.30-11.00</option>
                                    <option value="3">sesi 3, jam 11.00-12.30</option>
                                    <option value="4">sesi 4, jam 12.30-14.00</option>
                                    <option value="5">sesi 5, jam 14.00-15.30</option>
                                    <option value="6">sesi 6, jam 15.30-17.00</option>
                                    <option value="7">sesi 7, jam 17.00-18.30</option>
                                    <option value="8">sesi 8, jam 18.30-20.00</option>
                                    <option value="9">sesi 9, jam 20.00-21.30</option>
                                </select>
                                @error('x') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="isOpen=false" wire:click="clear({{ $id_jadwal }})" class="px-4 py-2 font-bold text-white transition bg-red-600 rounded-lg hover:bg-red-800">Close</button>
                            <button type="submit" @click="isOpen=false" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800">Submit</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
