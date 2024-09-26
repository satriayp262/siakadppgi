<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 ">
        {{-- <h1 class="text-2xl font-bold ">Prodi Table</h1> --}}
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
                    <td class="px-4 py-2 text-center w-1/4">{{ $prodi->kode_prodi }}</td>
                    <td class="px-4 py-2 text-center w-1/4">{{ $prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center w-1/2">
                        <div class="flex items-center justify-center space-x-2">
                            <livewire:admin.prodi.edit :id_prodi="$prodi->id_prodi" wire:key="edit-{{ $prodi->id_prodi }}" />
                            <button class="inline-block px-3 py-1 text-white bg-red-500 rounded hover:bg-red-700"
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
