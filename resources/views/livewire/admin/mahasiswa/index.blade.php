<div class="mx-5">
    <div wire:loading wire:target="export,destroySelected,destroy"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
        <div class="spinner loading-spinner"></div>
    </div>
    <div class="flex flex-col mx-4 mt-2">
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <!-- Modal Form -->
                <livewire:admin.mahasiswa.create />
                {{-- modal import --}}
                <div x-data="{ isOpen: false, load: false }" @modal-closed.window="isOpen = false">

                    <!-- Button to open the modal -->
                    <button @click="isOpen=true; load=true"
                        class="flex items-center py-2 pr-4 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                            viewBox="0 0 48 48">
                            <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path>
                            <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z">
                            </path>
                            <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path>
                            <path fill="#17472a" d="M14 24.005H29V33.055H14z"></path>
                            <g>
                                . <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z">
                                </path>
                                <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z">
                                </path>
                                <path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"></path>
                                <path fill="#129652" d="M29 24.005H44V33.055H29z"></path>
                            </g>
                            <path fill="#0c7238"
                                d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                            </path>
                            <path fill="#fff"
                                d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                            </path>
                        </svg>
                        Import
                    </button>

                    <div x-show="isOpen && load" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
                        <div class="w-full max-w-2xl mx-4 bg-white shadow-lg">
                            <div wire:loading wire:target="import"
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
                                <div class="spinner loading-spinner"></div>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                                <h3 class="text-xl font-semibold">Import Mahasiswa</h3>
                                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                                    <button class="text-gray-900">&times;</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="p-4 max-h-[500px] overflow-y-auto">
                                    <form wire:submit.prevent="import">
                                        @csrf <!-- CSRF protection for form submission -->
                                        <div class="mb-4">
                                            <div class="flex flex-col">
                                                <label class="block text-sm font-medium text-gray-700">Template
                                                    Dokumen</label>
                                                <a href="{{ asset('template/template_import_mahasiswa.xlsx') }}"
                                                    class="flex items-center justify-between w-full px-2 py-1 mt-1 text-sm bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">

                                                    <!-- Left icon -->
                                                    <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z"
                                                            clip-rule="evenodd" />
                                                    </svg>

                                                    <!-- Button text -->
                                                    <span
                                                        class="flex-grow px-2 font-medium text-left text-black-500">Template_Import_Mahasiswa.xlsx</span>

                                                    <!-- Right icon -->
                                                    <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                                    </svg>
                                                </a>
                                                <br>
                                                <label for="file"
                                                    class="block text-sm font-medium text-gray-700">File</label>

                                                <div x-data="{ uploading: false, timeout: null }"
                                                    x-on:livewire-upload-start="uploading = true; clearTimeout(timeout);"
                                                    x-on:livewire-upload-finish="timeout = setTimeout(() => { uploading = false; }, 1000);"
                                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                    <input type="file" id="file" wire:model="file"
                                                        name="file"
                                                        class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                                    @error('file')
                                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                                    @enderror

                                                    <div x-show="uploading" class="mt-2">
                                                        <div class="flex flex-row items-center w-full mt-2 space-x-2">
                                                            <div class="spinner"></div>
                                                            <div class="spinner-text">Memproses Permintaan...</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                <livewire:admin.mahasiswa.export />
            </div>
            <div>
                @if (session()->has('message'))
                    @php
                        $messageType = session('message_type', 'success'); // Default to success
                        $bgColor =
                            $messageType === 'error'
                                ? 'bg-red-500'
                                : (($messageType === 'warning'
                                        ? 'bg-yellow-500'
                                        : $messageType === 'update')
                                    ? 'bg-blue-500'
                                    : 'bg-green-500');
                    @endphp
                    <div id="flash-message"
                        class="flex items-center justify-between p-2 mx-2 mt-4 text-white {{ $bgColor }} rounded">
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
                        $messageType = session('message_type', 'success'); // Default to success
                        $bgColor =
                            $messageType === 'error'
                                ? 'bg-red-500'
                                : (($messageType === 'warning'
                                        ? 'bg-yellow-500'
                                        : $messageType === 'update')
                                    ? 'bg-blue-500'
                                    : 'bg-green-500');
                    @endphp
                    <div id="flash-message"
                        class="flex items-center justify-between p-2 mx-2 mt-4 text-white {{ $bgColor }} rounded">
                        <span>{!! session('message2') !!}</span>
                        <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                            class="font-bold text-white">
                            &times;
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
            <livewire:table.mahasiswa-table />
            {{-- <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                    <th class="px-4 py-2 text-center">NIM Mahasiswa</th>
                    <th class="px-4 py-2 text-center">Semester</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswas as $mahasiswa)
                    <tr class="border-t" wire:key="matkul-{{ $mahasiswa->id_mahasiswa }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" class="selectRow" wire:model="selectedMahasiswa"
                                value="{{ $mahasiswa->id_mahasiswa }}">
                        </td>
                        <td class="px-4 py-2 text-center">
                            {{ ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->semesterDifference }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex flex-col">
                                <div class="flex justify-center space-x-2">
                                    <livewire:admin.mahasiswa.show :id_mahasiswa="$mahasiswa->id_mahasiswa"
                                        wire:key="selengkapnya-{{ rand() . $mahasiswa->id_mahasiswa }}" />
                                    <livewire:admin.mahasiswa.edit :id_mahasiswa="$mahasiswa->id_mahasiswa"
                                        wire:key="edit-{{ rand() . $mahasiswa->id_mahasiswa }}" />
                                    <button
                                        class="inline-block px-3 py-2 text-white bg-red-500 rounded hover:bg-red-700"
                                        onclick="confirmDelete('{{ $mahasiswa->id_mahasiswa }}', '{{ $mahasiswa->nama }}')">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="mt-4 mb-4 text-center">
            {{ $mahasiswas->links('') }}
        </div> --}}
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

            window.addEventListener('bulkDelete.alert.mahasiswa-table-s8eldb-table', (event) => {
                const ids = event.detail[0].ids;

                // console.log(event.detail[0].ids);
                if (!ids || ids.length === 0) return;

                Swal.fire({
                    title: `Apakah anda yakin ingin menghapus ${ids.length} data User?`,
                    text: "Data yang telah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Livewire.find(
                        //     document.querySelector('[wire\\:id]').getAttribute('wire:id')
                        // ).call('destroySelected', ids);
                        @this.call('destroySelected', ids);
                    }
                });
            });

            function isMovingToDropdown(event) {
                const target = event.relatedTarget; // Elemen tujuan kursor
                return target && (target.closest('.relative') !== null);
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('destroyed', event => {
                    Swal.fire({
                        title: 'Success!',
                        text: event.detail.params.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Dispatch the modal-closed event to close the modal
                        window.dispatchEvent(new CustomEvent('modal-closed'));
                    });
                });
            });
        </script>
    </div>
