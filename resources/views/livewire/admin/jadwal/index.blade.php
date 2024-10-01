<div class="container mx-auto p-4">
    <div class="flex flex-col justify-between mx-4">
        <div>
            @if ($message)
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <span>{{ $message }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <button wire:click="generateJadwal"
                class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                Buat Jadwal Otomatis
            </button>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border border-gray-300">Jam</th>
                    <th class="py-2 px-4 border border-gray-300">Senin</th>
                    <th class="py-2 px-4 border border-gray-300">Selasa</th>
                    <th class="py-2 px-4 border border-gray-300">Rabu</th>
                    <th class="py-2 px-4 border border-gray-300">Kamis</th>
                    <th class="py-2 px-4 border border-gray-300">Jumat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ([1 => '08:00 - 09:00', 2 => '09:00 - 10:00', 3 => '10:00 - 11:00', 4 => '11:00 - 12:00', 5 => '13:00 - 14:00', 6 => '14:00 - 15:00', 7 => '15:00 - 16:00', 8 => '16:00 - 17:00'] as $jamKe => $waktu)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border border-gray-300">{{ $waktu }}</td>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                            <td class="py-2 px-4 border border-gray-300">
                                @php
                                    $jadwalItem = $jadwal->where('hari', $hari)->where('jam_ke', $jamKe)->first();
                                @endphp
                                @if ($jadwalItem)
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $jadwalItem->matkul->nama }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        ({{ $jadwalItem->dosen->nama }})
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $jadwalItem->kelas->nama }}
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
