<div class="mx-5">
    <div class="flex items-center justify-between">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Prodi</span>
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
    <div class="flex justify-between mx-4 mt-4">
        <h1 class="text-2xl font-bold ">Prodi Table</h1>
        <div>
            @if (session()->has('message'))
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white bg-green-500 rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:admin.prodi.create />
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                {{-- <th class="px-4 py-2 text-center">No.</th> --}}
                <th class="px-4 py-2 text-center">Kode Prodi</th>
                <th class="px-4 py-2 text-center">Nama Prodi</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prodis as $prodi)
                <tr class="border-t" wire:key="prodi-{{ $prodi->id_prodi }}">
                    {{-- <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td> --}}
                    <td class="px-4 py-2 text-center">{{ $prodi->kode_prodi }}</td>
                    <td class="px-4 py-2 text-center">{{ $prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="flex space-x-2">
                                <livewire:admin.prodi.edit :id_prodi="$prodi->id_prodi" wire:key="edit-{{ $prodi->id_prodi }}" />
                            </div>
                            <button class="inline-block px-3 py-1 mt-2 text-white bg-red-500 rounded hover:bg-red-700"
                                onclick="confirmDelete('{{ $prodi->id_prodi }}', '{{ $prodi->nama_prodi }}')">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{ $prodis->links('pagination::tailwind') }}
    </div>
    <script>
        function confirmDelete(id, nama_prodi) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Mata Kuliah ${nama_prodi}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id);
                }
            });
        }
    </script>
</div>
