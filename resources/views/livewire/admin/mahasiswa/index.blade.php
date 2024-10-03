<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-2">
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success');
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-yellow-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-2 text-white {{ $bgColor }} rounded">
                    <span>{!! session('message') !!}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <div>
            @if (session()->has('message2'))
                @php
                    $messageType = session('message_type2', 'warning');
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-yellow-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-2 mb-4 text-white {{ $bgColor }} rounded">
                    <span>{!! session('message2') !!}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <!-- Modal Form -->
                <livewire:admin.mahasiswa.create />
                {{-- modal import --}}
                <div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
                    <!-- Button to open the modal -->
                    <button @click="isOpen=true"
                        class="flex items-center pr-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="26"
                            height="26" viewBox="0 0 48 48">
                            <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path>
                            <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z">
                            </path>
                            <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path>
                            <path fill="#17472a" d="M14 24.005H29V33.055H14z"></path>
                            <g>
                                <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"></path>
                                <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z">
                                </path>
                                <path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"></path>
                                <path fill="#129652" d="M29 24.005H44V33.055H29z"></path>
                            </g>
                            <path fill="#0c7238"
                                d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638 C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                            </path>
                            <path fill="#fff"
                                d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                            </path>
                        </svg>
                        Import
                    </button>
                    <div x-show="isOpen"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
                        <div class="w-1/2 bg-white  shadow-lg">
                            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                                <h3 class="text-xl font-semibold">Import Mahasiswa</h3>
                                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                                    <button class="text-gray-900">&times;</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="p-4 max-h-[500px] overflow-y-auto">
                                    <form wire:submit="import">
                                        @csrf <!-- CSRF protection for form submission -->
                                        <div class="mb-4">
                                            <label for="file"
                                                class="block text-sm font-medium text-gray-700">File</label>
                                            <input type="file" id="file" wire:model="file" name="file"
                                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                            @error('file')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div wire:loading>
                                            <div class="mt-2 w-full flex flex-row items-center space-x-2">
                                                <div class="spinner"></div>
                                                <div class="spinner-text">Memproses Permintaan...</div>
                                            </div>
                                        </div>
                                        <!-- Submit Button inside the form -->
                                        <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">

                                            <button type="button" @click="isOpen = false"
                                                class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Close</button>
                                            <button type="submit"
                                                class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                <th class="px-4 py-2 text-center">NIM Mahasiswa</th>
                <th class="px-4 py-2 text-center">Jenis Kelamin</th>
                <th class="px-4 py-2 text-center">Prodi</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswas as $mahasiswa)
                <tr class="border-t" wire:key="matkul-{{ $mahasiswa->id_mahasiswa }}">
                    <td class="px-4 py-2 text-center">
                        {{ ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() + $loop->iteration }}</td>
                    </td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->jenis_kelamin }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-col">
                            <div class="flex justify-center space-x-2">
                                <livewire:admin.mahasiswa.show :id_mahasiswa="$mahasiswa->id_mahasiswa"
                                    wire:key="selengkapnya-{{ rand() . $mahasiswa->id_mahasiswa }}" />
                                <livewire:admin.mahasiswa.edit :id_mahasiswa="$mahasiswa->id_mahasiswa"
                                    wire:key="edit-{{ rand() . $mahasiswa->id_mahasiswa }}" />
                                <button class="inline-block px-3 py-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $mahasiswa->id_mahasiswa }}', '{{ $mahasiswa->nama }}')">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </div>
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
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
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
