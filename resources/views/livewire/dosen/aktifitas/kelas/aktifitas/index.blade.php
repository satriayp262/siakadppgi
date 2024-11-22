<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between mt-2">
            <input type="text" wire:model.live="search" placeholder="   Search" wire:key="search-input"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <div class="flex justify-between">
            <p class="px-4 py-2 font-bold">{{$nama_aktifitas}}</p>
            <button wire:click="save" class="px-4 py-2 bg-blue-500 text-white">Save Nilai</button>
        </div>
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">NIM</th>
                    <th class="px-4 py-2 text-center">Nama</th>
                    <th class="px-4 py-2 text-center">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Nilai as $index => $item)
                    <tr wire:key="item-{{ $item['NIM'] }}">
                        <td class="px-4 py-2 text-center">{{ $item['NIM'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $item['nama'] }}</td>
                        <td class="px-4 py-2 text-center flex flex-col items-center">
                            <input wire:loading.remove type="number" wire:model.defer="Nilai.{{ $index }}.nilai"
                                class="w-24 px-2 py-1 border" required>
                                @error('Nilai.' . $index . '.nilai')
                                    <small class="text-red-500">{{ $message }}</small>
                                @enderror
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
