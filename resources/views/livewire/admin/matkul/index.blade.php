<div class="mx-5">
    <div class="flex items-center justify-between">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Mata Kuliah</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="text-right">
                <ol class="breadcrumb">
                    <li class="text-sm font-medium text-gray-700 breadcrumb-item">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </li>
                </ol>
            </div>
        </div>
    <div class="flex flex-col justify-between mx-4 mt-4">
        <h1 class="text-2xl font-bold ">Table Mata Kuliah</h1>
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
                            <button class="inline-block px-3 py-1 mt-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete({{ $matkul->id_mata_kuliah }}, '{{ $matkul->nama_mata_kuliah }}')">Delete</button>
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
    <script>
        function confirmDelete(id, nama_mata_kuliah) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Mata Kuliah ${nama_mata_kuliah}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil method Livewire jika konfirmasi diterima
                    @this.call('destroy', id);
                }
            });
        }
    </script>
</div>
