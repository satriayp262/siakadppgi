<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb" class="py-2">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <a href="{{ route('dosen.aktifitas') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Aktifitas</span>
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a href="{{ route('dosen.aktifitas.kelas', ['kode_mata_kuliah' => $kode_mata_kuliah]) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                {{ $kode_mata_kuliah }}
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a href="{{ route('dosen.aktifitas.kelas.show', ['nama_kelas' => str_replace('/', '-', $nama_kelas), 'kode_mata_kuliah' => $kode_mata_kuliah]) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                {{ str_replace('-', '/', $nama_kelas) }}
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- <livewire:dosen.presensi.create-token /> --}}
            {{-- <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 py-2 border border-gray-300 rounded-lg"> --}}
        </div>
        <div class="flex space-x-2">
            <livewire:dosen.aktifitas.kelas.create :$id_kelas :$id_mata_kuliah />
            <div x-data="{ isOpen: false, load: false }" @modal-closed.window="isOpen = false">
                <!-- Button to open the modal -->
                <button @click="isOpen=true; load=true"
                    class="flex items-center text-[10px] md:text-[16px] px-2 sm:px-2 py-1 sm:py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    <svg class="mr-1 md:mr-2 w-4 sm:w-6 h-4 sm:h-6" xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                        viewBox="0 0 48 48">
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
                    <div class="w-1/2 bg-white shadow-lg">
                        <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                            <h3 class="text-xl font-semibold">Import Nilai</h3>
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
                                            <a href="{{ asset('template/template_import_nilai.xlsx') }}"
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
                                                    class="flex-grow px-2 font-medium text-left text-black-500">Template_Import_Nilai.xlsx</span>

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
                                                <input type="file" id="file" wire:model="file" name="file"
                                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                                @error('file')
                                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                                @enderror

                                                <div x-show="uploading" class="mt-2">
                                                    <div class="mt-2 w-full flex flex-row items-center space-x-2">
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
            <div>
                <button wire:click="export"
                    class="flex items-center text-[10px] md:text-[16px] px-2 sm:px-2 py-1 sm:py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    <svg class="mr-1 md:mr-2 w-4 sm:w-6 h-4 sm:h-6" xmlns="http://www.w3.org/2000/svg" width="26" height="26" c
                        viewBox="0 0 48 48">
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
                            d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                        </path>
                        <path fill="#fff"
                            d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                        </path>
                    </svg>
                    Export
                </button>
            </div>
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
                    $messageType = session('message_type', 'success');
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

    <div class="bg-white shadow-lg p-2 sm:p-4 mt-2 sm:mt-4 mb-2 sm:mb-4 rounded-lg max-w-full">
        <h2 class="px-4 font-bold text-[20px]">
            {{ str_replace('-', '/', $nama_kelas) . '  (' . $kode_mata_kuliah . ')' }}
        </h2>
        <table class="min-w-full mt-2 sm:mt-4 bg-white text-xs sm:text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-white align-middle bg-gray-800">
                    {{-- <th class="px-2 sm:px-4 py-1 sm:py-2 text-center">Nama Kelas</th> --}}
                    <th class="px-2 sm:px-4 py-1 sm:py-2 text-center">Nama aktifitas</th>
                    <th class="px-2 sm:px-4 py-1 sm:py-2 text-center">Catatan</th>
                    <th class="px-2 sm:px-4 py-1 sm:py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aktifitas as $item)
                    <tr wire:key="item-{{ $item->id_aktifitas }}">
                        {{-- <td class="px-2 sm:px-4 py-1 sm:py-2 text-center">{{ $item->kelas->nama_kelas }}</td> --}}
                        <td class="px-2 sm:px-4 py-1 sm:py-2 text-center">{{ $item->nama_aktifitas }}</td>
                        <td class="px-2 sm:px-4 py-1 sm:py-2 text-center">
                            {{ $item->catatan ?? 'Belum ada Catatan' }}
                        </td>
                        <td class="px-2 sm:px-4 py-1 sm:py-2 text-center">
                            <div class="flex flex-row justify-center space-x-1 sm:space-x-2">
                                <livewire:dosen.aktifitas.kelas.edit 
                                    :id_aktifitas="$item->id_aktifitas" 
                                    :$id_kelas 
                                    :$id_mata_kuliah 
                                    wire:key="edit-{{ rand() . $item->id_aktifitas }}" />
    
                                <button
                                    class="inline-block px-2 sm:px-4 py-1 sm:py-2 text-white bg-red-500 rounded hover:bg-red-700"
                                    wire:key="delete-{{ $item->id_aktifitas }}"
                                    onclick="confirmDelete('{{ $item->id_aktifitas }}')">
                                    <svg class="w-4 sm:w-6 h-4 sm:h-6 text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
    
                                <a href="{{ route('dosen.aktifitas.kelas.aktifitas', ['kode_mata_kuliah' => $kode_mata_kuliah, 'nama_kelas' => str_replace('/', '-', $nama_kelas), 'nama_aktifitas' => $item->nama_aktifitas]) }}"
                                    class="py-1 sm:py-2 px-3 sm:px-5 bg-blue-500 hover:bg-blue-700 rounded text-white text-sm">
                                    ▶
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>
<script>
    function confirmDelete(id_aktifitas) {
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus Aktifitas ini?',
            text: "Data Nilai pada Aktifitas ini akan Hilang dan Data yang telah dihapus tidak akan dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', id_aktifitas);
            }
        });
    }
</script>
