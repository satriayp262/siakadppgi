<div class="mx-5">
    <div class="flex justify-between mb-4 mt-4 items-center mx-4">
        <div x-data="{ isOpen: false, load: false }" @modal-closed.window="isOpen = false">
            <!-- Button to open the modal -->
            <button @click="isOpen=true; load=true"
                class="flex items-center md:pr-4 py-2 pr-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="26" height="26"
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
                        d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638 C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
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
                        <h3 class="text-xl font-semibold">Export Presensi Dosen</h3>
                        <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                            <button class="text-gray-900">&times;</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="p-4 max-h-[500px] overflow-y-auto">
                            <form wire:submit.prevent="exportExcel">
                                @csrf
                                <div class="mb-4 space-y-4">
                                    <!-- Semester Filter -->
                                    <div class="flex flex-col">
                                        <label for="id_semester" class="block text-sm font-medium text-gray-700">
                                            Pilih Semester Yang akan di Export
                                        </label>
                                        <select id="id_semester" wire:model="id_semester" name="id_semester"
                                            wire:change="updateMatkulKelasOptions"
                                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                            <option value="semua">Semua</option>
                                            @foreach ($semesterList as $item)
                                                <option value="{{ $item->id_semester }}">
                                                    {{ $item->nama_semester }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Prodi Filter -->
                                    <div class="flex flex-col">
                                        <label for="kode_prodi" class="block text-sm font-medium text-gray-700">
                                            Pilih Prodi Yang akan di Export
                                        </label>
                                        <select id="kode_prodi" wire:model="kode_prodi" name="kode_prodi"
                                            wire:change="updateMatkulKelasOptions"
                                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                            <option value="semua">Semua</option>
                                            @foreach ($prodiList as $item)
                                                <option value="{{ $item->kode_prodi }}">
                                                    {{ $item->nama_prodi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Mata Kuliah Filter -->
                                    <div class="flex flex-col">
                                        <label for="id_mata_kuliah" class="block text-sm font-medium text-gray-700">
                                            Pilih Mata Kuliah Yang akan di Export
                                        </label>
                                        <select id="id_mata_kuliah" wire:model="id_mata_kuliah" name="id_mata_kuliah"
                                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                            <option value="semua">Semua</option>
                                            @if ($filteredMatkulList)
                                                @foreach ($filteredMatkulList as $item)
                                                    <option value="{{ $item->id_mata_kuliah }}">
                                                        {{ $item->nama_mata_kuliah }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Kelas Filter -->
                                    <div class="flex flex-col">
                                        <label for="id_kelas" class="block text-sm font-medium text-gray-700">
                                            Pilih Kelas Yang akan di Export
                                        </label>
                                        <select id="id_kelas" wire:model="id_kelas" name="id_kelas"
                                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                            <option value="semua">Semua</option>
                                            @if ($filteredKelasList)
                                                @foreach ($filteredKelasList as $item)
                                                    <option value="{{ $item->id_kelas }}">
                                                        {{ $item->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            @endif
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

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <livewire:table.presensi-mahasiwa-table />
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Listen for the spSentSuccess event
            Livewire.on('spSentSuccess', (data) => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Surat Peringatan telah berhasil dikirim ke mahasiswa.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true,
                });
            });

            // If you also want to show error messages
            Livewire.on('spSentError', (message) => {
                Swal.fire({
                    title: 'Gagal!',
                    text: message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
@endpush
