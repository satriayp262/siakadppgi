<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success'); // Default to success
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:admin.mahasiswa.create />
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">NIM Mahasiswa</th>
                <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                <th class="px-4 py-2 text-center">Kelamin Mahasiswa</th>
                <th class="px-4 py-2 text-center">NIK</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswas as $mahasiswa)
                <tr class="border-t" wire:key="matkul-{{ $mahasiswa->id_mahasiswa }}">
                    <td class="px-4 py-2 text-center">
                        {{ ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() + $loop->iteration }}</td>
                    </td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->jenis_kelamin }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->NIK }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-col items-center">
                            <div class="flex space-x-2">
                                <livewire:admin.mahasiswa.edit :id_mahasiswa="$mahasiswa->id_mahasiswa"
                                    wire:key="edit-{{ rand() . $mahasiswa->id_mahasiswa }}" />
                                <button
                                    class="inline-block px-3 py-1 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $mahasiswa->id_mahasiswa }}', '{{ $mahasiswa->nama }}')">Delete</button>
                            </div>
                            <div class="flex justify-center mt-2 w-full">
                                <livewire:admin.mahasiswa.show :id_mahasiswa="$mahasiswa->id_mahasiswa"
                                    wire:key="selengkapnya-{{ rand() . $mahasiswa->id_mahasiswa }}" />
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="mt-4 text-center">
        {{ $mahasiswas->links('') }}
    </div>
    <script>
        function confirmDelete(id, nama) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Mahasiswa ${nama}?`,
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
