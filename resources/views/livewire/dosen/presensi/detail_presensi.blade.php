<div class="mx-5">
    <div class="flex flex-row justify-end mx-4 mt-4 items-center">
        {{-- <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <a href="{{ route('dosen.presensi') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                        E-Presensi
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('dosen.presensiByKelas', ['id_mata_kuliah' => $matkul->id_mata_kuliah]) }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            {{ $matkul->nama_mata_kuliah }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $kelas->nama_kelas }}</span>
                    </div>
                </li>
            </ol>
        </nav> --}}
        <input type="text" wire:model.live="search" placeholder="   Search"
            class="px-2 py-2 ml-4 border border-gray-300 rounded-lg">
    </div>
    <table class="min-w-full mt-4 bg-white text-sm">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                <th class="px-4 py-2 text-center">NIM</th>
                <th class="px-4 py-2 text-center">Waktu</th>
                <th class="px-4 py-2 text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if ($mahasiswaPresensi->isEmpty())
                <tr>
                    <td colspan="5" class="px-2 py-4 text-center">Tidak ada data</td>
                </tr>
            @endif
            @foreach ($mahasiswaPresensi as $key => $item)
                <tr class="border-t">
                    <td class="px-2 py-2 text-center">{{ $key + 1 }}</td>
                    <td class="px-2 py-2 text-center">{{ $item['nama'] }}</td>
                    <td class="px-2 py-2 text-center">{{ $item['nim'] }}</td>
                    <td class="px-2 py-2 text-center">
                        {{ $item['waktu_submit']? \Carbon\Carbon::parse($item['waktu_submit'])->timezone('Asia/Jakarta')->format('d/m/Y H:i'): '-' }}
                    </td>
                    <td class="px-2 py-2 text-center">{{ $item['keterangan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
