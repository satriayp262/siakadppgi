<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-2">
        <div class="flex md:flex-row flex-col md:space-y-0 space-y-4  justify-between mt-2">
            <div class="flex space-x-2">
                <!-- Modal Form -->
                {{-- <livewire:admin.mahasiswa.create /> --}}
                {{-- modal import --}}
                <div x-data="{ isOpen: false, load: false }" @modal-closed.window="isOpen = false">
                    <!-- Button to open the modal -->
                    <button @click="isOpen=true; load=true"
                        class="flex items-center md:pr-4 py-2 pr-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                        <svg class="mx-2 md:w-8 md:h-8 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
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
                        <div class="w-full max-w-2xl mx-4 bg-white shadow-lg">
                            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                                <h3 class="text-xl font-semibold">Import KRS</h3>
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
                                                <a wire:navigate.hover  href="{{ asset('template/template_import_krs.xlsx') }}"
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
                                                        class="flex-grow px-2 font-medium text-left text-black-500">Template_Import_KRS.xlsx</span>

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
                                                        <div class="mt-2 w-full flex flex-row items-center space-x-2">
                                                            <div class="spinner"></div>
                                                            <div class="spinner-text">Memproses Permintaan...</div>
                                                        </div>
                                                    </div>
                                                    @if ($importing)
                                                        <div class="mt-2">
                                                            <div
                                                                class="mt-2 w-full flex flex-row items-center space-x-2">
                                                                <div class="spinner"></div>
                                                                <div class="spinner-text">Memproses Permintaan...</div>
                                                            </div>
                                                        </div>
                                                    @endif
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
                <div x-data="{ isOpen: false, load: false }" @modal-closed.window="isOpen = false">
                    <!-- Button to open the modal -->
                    <button @click="isOpen=true; load=true"
                        class="flex items-center md:pr-4 py-2 pr-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                        <svg class="mx-2 md:w-8 md:h-8 w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="26"
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
                                d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                            </path>
                            <path fill="#fff"
                                d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                            </path>
                        </svg>
                        Export
                    </button>

                    <div x-show="isOpen && load" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
                        <div class="w-full max-w-2xl mx-4 bg-white shadow-lg">
                            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                                <h3 class="text-xl font-semibold">Export KRS</h3>
                                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                                    <button class="text-gray-900">&times;</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="p-4 max-h-[500px] overflow-y-auto">
                                    <form wire:submit.prevent="export">
                                        @csrf <!-- CSRF protection for form submission -->
                                        <div class="mb-4">
                                            <div class="flex flex-col">
                                                <label for="kode_prodi"
                                                    class="block text-sm font-medium text-gray-700">Pilih Semester Yang
                                                    akan di Export</label>

                                                <select id="id_semester" wire:model="id_semester" name="id_semester"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value="semua">
                                                        Semua
                                                    </option>
                                                    @foreach ($semester as $item)
                                                        <option value="{{ $item->id_semester }}">
                                                            {{ $item->nama_semester }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex flex-col">
                                                <label for="kode_prodi"
                                                    class="block text-sm font-medium text-gray-700">Pilih Prodi Yang
                                                    akan di Export</label>

                                                <select id="id_prodi" wire:model="id_prodi" name="id_prodi"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value="semua">
                                                        Semua
                                                    </option>
                                                    @foreach ($prodi as $item)
                                                        <option value="{{ $item->id_prodi }}">
                                                            {{ $item->nama_prodi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                                            <button type="button" @click="isOpen = false"
                                                class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Close</button>
                                            <button type="submit"
                                                class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Export</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 md:ml-4 py-1 border border-gray-300 rounded-lg"> --}}
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

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full overflow-x-auto">
        <livewire:table.krstable/>

        {{-- <table class="min-w-full mt-4 bg-white border border-gray-200 md:text-[16px] text-[10px]">
            <thead>
                <tr class="items-center w-full text-white align-middle bg-customPurple">
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-center">NIM Mahasiswa</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-center">Nama Mahasiswa</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-center">Semester</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-center">Prodi</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $item)
                    <tr class="border-t" wire:key="matkul-{{ $item->id_mahasiswa }}">
                        <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">{{ $item->NIM }}</td>
                        <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">{{ $item->nama }}</td>
                        <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">{{ $item->semesterDifference }}</td>
                        <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">{{ $item->prodi->nama_prodi }}</td>
                        <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">
                            <div class="flex flex-col">
                                <div class="flex justify-center space-x-2">
                                    <a wire:navigate.hover  href="{{ route('admin.krs.mahasiswa', ['NIM' => $item->NIM]) }}"
                                        class="py-1 px-2 sm:py-2 sm:px-4 bg-blue-500 hover:bg-blue-700 rounded text-white">
                                        <p><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                    d="M9 5l7 7-7 7" />
                            </svg></p>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="mt-4 mb-4 text-center">
            {{ $mahasiswa->links('') }}
        </div> --}}
    </div>
</div>
