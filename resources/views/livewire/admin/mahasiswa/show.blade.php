<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="px-3 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700"><svg
            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2"
                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    </button>

    <!-- Modal Background -->
    <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Data Mahasiswa</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <div class="grid grid-cols-3">
                        @foreach (['NIM', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'NIK', 'agama', 'alamat', 'jalur_pendaftaran', 'kewarganegaraan', 'jenis_pendaftaran', 'tanggal_masuk_kuliah', 'mulai_semester', 'jenis_tempat_tinggal', 'telp_rumah', 'no_hp', 'email', 'terima_kps', 'no_kps', 'jenis_transportasi', 'kode_prodi', 'SKS_diakui', 'kode_pt_asal', 'nama_pt_asal', 'kode_prodi_asal', 'nama_prodi_asal', 'jenis_pembiayaan', 'jumlah_biaya_masuk'] as $field)
                            <div class="mb-4 text-left border w-full h-full p-2">
                                @php
                                    if ($field === 'NIM' || $field === 'NIK') {
                                        $label = Str::of($field)->replace('_', ' ');
                                    } else {
                                        $label = Str::of($field)->replace('_', ' ')->title();
                                    }
                                @endphp
                                <label for="{{ strtolower($field) }}"
                                    class="block text-sm text-left font-medium text-gray-700">{{ $label }}</label>
                                <p class="text-sm text-gray-500">{{ $this->$field ?? 'Data Belum ada' }}</p>
                            </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
