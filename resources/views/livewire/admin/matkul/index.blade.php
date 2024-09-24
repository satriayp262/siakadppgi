<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <h1 class="text-2xl font-bold ">Berita Table</h1>
        <div>
            @if (session()->has('message'))
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white bg-green-500 rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1"  onclick="document.getElementById('flash-message').style.display='none'"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:admin.matkul.create />
            <input type="text" wire:model.live="search" placeholder="   Search" class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">Kode Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Nama Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Jenis Mata Kuliah</th>
                <th class="px-4 py-2 text-center">SKS Tatap Muka</th>
                <th class="px-4 py-2 text-center">SKS Praktek</th>
                <th class="px-4 py-2 text-center">SKS Praktek Lapangan</th>
                <th class="px-4 py-2 text-center">SKS Simulasi</th>
                <th class="px-4 py-2 text-center">Metode Pembelajaran</th>
                <th class="px-4 py-2 text-center">Tanggal Mulai Efektif</th>
                <th class="px-4 py-2 text-center">Tanggal Akhir Efektif</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matkuls as $matkul)
                <tr class="border-t" wire:key="matkul-{{ $matkul->id_mata_kuliah }}">
                    <td class="px-4 py-2 text-center">{{ $matkul->kode_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->nama_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->jenis_mata_kuliah }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->sks_tatap_muka }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->sks_praktek }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->sks_praktek_lapangan }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->sks_simulasi }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->metode_pembelajaran }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->tgl_mulai_efektif }}</td>
                    <td class="px-4 py-2 text-center">{{ $matkul->tgl_akhir_efektif }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="flex space-x-2">
                                <livewire:admin.matkul.edit :id_mata_kuliah="$matkul->id_mata_kuliah" wire:key="edit-{{ $matkul->id_mata_kuliah }}" />
                            </div>
                            <button class="inline-block px-3 py-1 text-white bg-red-500 rounded hover:bg-red-700" 
                                    wire:click="destroy({{ $matkul->id_mata_kuliah }})" wire:confirm="Are you sure?">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{ $matkuls->links('pagination::tailwind') }}
    </div>
</div>
