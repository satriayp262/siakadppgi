<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 ">
        {{-- <h1 class="text-2xl font-bold ">Prodi Table</h1> --}}
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
                {{-- @push('scripts')
                    <script>
                        setTimeout(() => {
                            const flashMessage = document.getElementById('flash-message');
                            if (flashMessage) {
                                flashMessage.remove();
                            }
                        }, 1000); // Adjust the time (in milliseconds) as needed
                    </script>
                @endpush --}}
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
                <th class="px-4 py-2 text-center">No.</th>
                <th class="px-4 py-2 text-center">Kode Prodi</th>
                <th class="px-4 py-2 text-center">Nama Prodi</th>
                <th class="px-4 py-2 text-center">Jenjang</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prodis as $prodi)
                <tr class="border-t" wire:key="prodi-{{ $prodi->id_prodi }}">
                    <td class="px-4 py-2 text-center">
                        {{ ($prodis->currentPage() - 1) * $prodis->perPage() + $loop->iteration }}</td>
                    <td class="px-4 py-2 text-center w-1/4">{{ $prodi->kode_prodi }}</td>
                    <td class="px-4 py-2 text-center w-1/4">{{ $prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center w-1/4">{{ $prodi->jenjang }}</td>
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
        {{ $prodis->links('') }}
    </div>

    <script>
        function confirmDelete(id, nama_prodi) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Prodi ${nama_prodi}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#28a745',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id);
                }
            });
        }
    </script>
</div>
