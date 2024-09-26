<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 ">
        <h1 class="text-2xl font-bold ">Dosen Table</h1>
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
            <livewire:admin.dosen.create />
            <input type="text" wire:model.live="search" placeholder="   Search" class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Nama Dosen</th>
                <th class="px-4 py-2 text-center">NIDN</th>
                <th class="px-4 py-2 text-center">Jenis Kelamin</th>
                <th class="px-4 py-2 text-center">Jabatan Fungsional</th>
                <th class="px-4 py-2 text-center">Kepangkatan</th>
                <th class="px-4 py-2 text-center">Nama Prodi</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dosens as $dosen)
                <tr wire:key="dosen-{{ $dosen->id_dosen }}">
                    <td class="px-4 py-2  text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2  text-center">{{ $dosen->nama_dosen }}</td>
                    <td class="px-4 py-2  text-center">{{ $dosen->nidn }}</td>
                    <td class="px-4 py-2  text-center">{{ $dosen->jenis_kelamin }}</td>
                    <td class="px-4 py-2  text-center">{{ $dosen->jabatan_fungsional }}</td>
                    <td class="px-4 py-2  text-center">{{ $dosen->kepangkatan }}</td>
                    <td class="px-4 py-2  text-center">{{ $dosen->prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="flex space-x-2">
                                <livewire:admin.dosen.edit :id_dosen="$dosen->id_dosen" wire:key="edit-{{ $dosen->id_dosen }}" />
                            </div>
                            <button  wire:key="delete-{{ $dosen->id_dosen }}" class="inline-block px-3 py-1 mt-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete({{ $dosen->id_dosen }}, '{{ $dosen->nama_dosen }}')">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{ $dosens->links('pagination::tailwind') }}
    </div>

    <script>
        function confirmDelete(id, nama_dosen) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Dosen ${nama_dosen}?`,
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
