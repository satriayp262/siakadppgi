<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex flex-col md:flex-row justify-start md:justify-between  items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center ">
                            <a href="{{ route('dosen.aktifitas') }}"
                                class="text-[12px] md:text-[14px]  font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                <span class="text-[12px] md:text-[14px]  font-medium text-gray-500 ms-1 md:ms-2">Aktifitas</span>
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a href="{{ route('dosen.aktifitas.kelas', ['kode_mata_kuliah' => $kode_mata_kuliah]) }}"
                                class="text-[12px] md:text-[14px]  font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                {{ $kode_mata_kuliah }}
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a href="{{ route('dosen.aktifitas.kelas.show', ['nama_kelas' => str_replace('/', '-', $nama_kelas), 'kode_mata_kuliah' => $kode_mata_kuliah]) }}"
                                class="text-[12px] md:text-[14px]  font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                {{ $nama_kelas }}
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a href="{{ route('dosen.aktifitas.kelas.aktifitas', ['kode_mata_kuliah' => $kode_mata_kuliah, 'nama_kelas' => str_replace('/', '-', $nama_kelas), 'nama_aktifitas' => $nama_aktifitas]) }}"
                                class="text-[12px] md:text-[14px]  font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                {{ $nama_aktifitas }}
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- <livewire:dosen.presensi.create-token /> --}}
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="w-full md:w-48 px-2 md:ml-4 mt-2 md:mt-0 py-2 border border-gray-300 rounded-lg">
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <div class="flex justify-between">
            <p class="px-4 py-2 font-bold">{{$nama_aktifitas}}</p>
            <button wire:click="save" class="px-4 py-2 bg-blue-500 text-white">Save Nilai</button>
        </div>
        <table class="min-w-full mt-4 bg-white text-[12px] md:text-[14px] border border-gray-200">
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
