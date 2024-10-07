<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="px-3 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"><svg
            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg></button>

    <!-- Modal Background -->
    <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Edit Mahasiswa</h3>
                <div @click="isOpen=false" wire:click="clear('{{ $id_mahasiswa }}')"
                    class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit.prevent="save">
                        @csrf <!-- CSRF protection for form submission -->
                        <div class="grid grid-cols-2 gap-4">
                            @foreach (['NIM', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'NIK', 'agama', 'alamat', 'jalur_pendaftaran', 'kewarganegaraan', 'jenis_pendaftaran', 'tanggal_masuk_kuliah', 'mulai_semester', 'jenis_tempat_tinggal', 'telp_rumah', 'no_hp', 'email', 'terima_kps', 'no_kps', 'jenis_transportasi', 'kode_prodi', 'kode_pt_asal', 'nama_pt_asal', 'kode_prodi_asal', 'nama_prodi_asal', 'jenis_pembiayaan', 'jumlah_biaya_masuk'] as $field)
                                <div class="mb-4">
                                    @php
                                        if ($field === 'NIM' || $field === 'NIK') {
                                            $label = Str::of($field)->replace('_', ' ');
                                        } else {
                                            $label = Str::of($field)->replace('_', ' ')->title();
                                        }
                                    @endphp
                                    <label for="{{ strtolower($field) }}"
                                        class="block text-sm text-left font-medium text-gray-700">{{ $label }}</label>

                                    @if ($field === 'tanggal_lahir' || $field === 'tanggal_masuk_kuliah')
                                        <input type="date" id="{{ strtolower($field) }}"
                                            wire:model="{{ strtolower($field) }}" name="{{ strtolower($field) }}"
                                            class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                    @elseif ($field === 'jenis_kelamin')
                                        <select id="{{ strtolower($field) }}" wire:model="{{ strtolower($field) }}"
                                            name="{{ strtolower($field) }}"
                                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                            <option value="" disabled selected>Select</option>
                                            <option value="Perempuan">Perempuan</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                        </select>
                                    @elseif ($field === 'mulai_semester')
                                        <div class="flex items-center">
                                            <select id="{{ strtolower($field) }}" wire:model="{{ strtolower($field) }}"
                                                name="{{ strtolower($field) }}"
                                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                @foreach ($semesters as $semester)
                                                    <option value="{{ $semester->kode_semester }}">
                                                        {{ $semester->nama_semester }}
                                                    </option>
                                                @endforeach
                                                <option value="add_new">Tambah Semester</option>
                                                {{-- <livewire:admin.semester.create /> --}}
                                            </select>
                                        </div>
                                    @elseif($field === 'kode_prodi')
                                        <select id="{{ strtolower($field) }}" wire:model="{{ strtolower($field) }}"
                                            name="{{ strtolower($field) }}"
                                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                            @foreach ($prodis as $program)
                                                <option value="{{ $program->kode_prodi }}">{{ $program->nama_prodi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" id="{{ strtolower($field) }}"
                                            wire:model="{{ strtolower($field) }}" name="{{ strtolower($field) }}"
                                            class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                    @endif

                                    @error(strtolower($field))
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button inside the form -->
                        <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                            <button type="button" @click="isOpen = false" wire:click="clear('{{ $id_mahasiswa }}')"
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
