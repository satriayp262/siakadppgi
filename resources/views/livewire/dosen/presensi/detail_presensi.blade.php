<div class="mx-5">
    <h1 class="text-xl font-bold mt-4">Detail Presensi</h1>
    <div class="flex justify-between items-center">
        <h1 class="text-md font-bold">Mata Kuliah : {{ $matkul }}</h1>
        <button class="px-4 py-2 font-bold text-sm text-white bg-red-500 rounded hover:bg-red-700" wire:click="back">Kembali</button>
    </div>
    <table class="min-w-full mt-4 bg-white text-sm">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                <th class="px-4 py-2 text-center">NIM</th>
                <th class="px-4 py-2 text-center">Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presensi as $key => $presensiItem)
                <tr>
                    <td class="px-2 py-1 text-center">{{ $key + 1 }}</td>
                    <td class="px-2 py-1 text-center">{{ $presensiItem->nama }}</td>
                    <td class="px-2 py-1 text-center">{{ $presensiItem->nim }}</td>
                    <td class="px-2 py-1 text-center">{{ $presensiItem->matkul->nama_mata_kuliah }}</td>
                    <td class="px-2 py-1 text-center">{{ \Carbon\Carbon::parse($presensiItem->waktu_submit)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
