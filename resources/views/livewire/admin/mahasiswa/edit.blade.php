    <div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
        <!-- Button to open the modal -->
        <button @click="isOpen=true" class="px-3 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"><svg
                class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
            </svg></button>

        <!-- Modal Background -->
        <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
            <div wire:loading wire:target="save"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
                <div class="spinner loading-spinner"></div>
            </div>
            <!-- Modal Content -->
            <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
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
                            <div class="fex flex-col">
                                <div class="grid grid-cols-2 gap-4">

                                    @foreach (['NIM', 'NIK', 'NISN', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'NPWP', 'mulai_semester', 'kode_prodi', 'agama', 'alamat', 'jalur_pendaftaran', 'kewarganegaraan', 'jenis_pendaftaran', 'tanggal_masuk_kuliah', 'jenis_tempat_tinggal', 'telp_rumah', 'no_hp', 'email', 'terima_kps', 'no_kps', 'jenis_transportasi', 'kode_pt_asal', 'nama_pt_asal', 'kode_prodi_asal', 'nama_prodi_asal', 'jenis_pembiayaan', 'jumlah_biaya_masuk'] as $field)
                                        <div class="mb-4">
                                            @php
                                                // Fields that skip title() transformation
                                                $noTitleFields = ['NIM', 'NIK', 'NISN', 'NPWP'];
                                                // Fields that require a red asterisk
                                                $requiredFields = [
                                                    'NIM',
                                                    'NIK',
                                                    'NISN',
                                                    'nama',
                                                    'tempat_lahir',
                                                    'tanggal_lahir',
                                                    'jenis_kelamin',
                                                    'mulai_semester',
                                                    'kode_prodi',
                                                ];

                                                if (in_array($field, $noTitleFields)) {
                                                    $label = $field;
                                                } else {
                                                    $label = Str::of($field)->replace('_', ' ')->title();
                                                }

                                                // Add red asterisk for required fields
                                                $label .= in_array($field, $requiredFields)
                                                    ? ' <span class="text-red-500">*</span>'
                                                    : '';
                                            @endphp
                                            <label for="{{ strtolower($field) }}"
                                                class="block text-sm text-left font-medium text-gray-700">{!! $label !!}</label>
                                            @if ($field === 'tanggal_lahir' || $field === 'tanggal_masuk_kuliah')
                                                <input type="date" id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                            @elseif ($field === 'jenis_kelamin')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="P">Perempuan</option>
                                                    <option value="L">Laki-Laki</option>
                                                </select>
                                            @elseif($field === 'agama')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    <option value="1">Islam</option>
                                                    <option value="2">Kristen</option>
                                                    <option value="3">Katolik</option>
                                                    <option value="4">Hindu</option>
                                                    <option value="5">Buddha</option>
                                                    <option value="6">Konghucu</option>
                                                    <option value="99">Lainnya</option>
                                                </select>
                                            @elseif($field === 'jalur_pendaftaran')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    <option value="3">Penelusuran Minat dan Kemampuan (PMDK)
                                                    </option>
                                                    <option value="4">Program Internasional</option>
                                                    <option value="9">Katolik</option>
                                                    <option value="11">Program Kerjasama
                                                        Perusahaan/Institusi/Pemerintah</option>
                                                    <option value="12">Seleksi Mandiri</option>
                                                    <option value="13">Ujian Masuk Bersama Lainnya</option>
                                                    <option value="14">Seleksi Nasional Berdasarkan Tes (SNBT)
                                                    </option>
                                                    <option value="15">Seleksi Nasional Berdasarkan Prestasi (SNBP)
                                                    </option>
                                                </select>
                                            @elseif($field === 'jenis_pendaftaran')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    <option value="1">Peserta didik baru</option>
                                                    <option value="2">Pindahan</option>
                                                    <option value="3">Naik Kelas</option>
                                                    <option value="4">Akselerasi</option>
                                                    <option value="5">Mengulang</option>
                                                    <option value="6">Lanjutan semester</option>
                                                    <option value="8">Pindahan Alih Bentuk</option>
                                                    <option value="13">RPL Perolehan SKS</option>
                                                    <option value="14">Pendidikan Non Gelar (Course)</option>
                                                    <option value="15">Fast Track</option>
                                                    <option value="16">RPL Transfer SKS</option>
                                                </select>
                                            @elseif($field === 'jenis_tempat_tinggal')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    <option value="1">Bersama orang tua</option>
                                                    <option value="2">Wali</option>
                                                    <option value="3">Kost</option>
                                                    <option value="4">Asrama</option>
                                                    <option value="5">Panti asuhan</option>
                                                    <option value="10">Rumah sendiri</option>
                                                    <option value="99">Lainnya</option>
                                                </select>
                                            @elseif($field === 'jenis_transportasi')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    <option value="1">Jalan kaki</option>
                                                    <option value="3">Angkutan umum/bus/pete-pete</option>
                                                    <option value="4">Mobil/bus antar jemput</option>
                                                    <option value="5">Kereta api</option>
                                                    <option value="6">Ojek</option>
                                                    <option value="7">Andong/bendi/sado/dokar/delman/becak
                                                    </option>
                                                    <option value="8">Perahu penyeberangan/rakit/getek</option>
                                                    <option value="11">Kuda</option>
                                                    <option value="12">Sepeda</option>
                                                    <option value="13">Sepeda motor</option>
                                                    <option value="14">Mobil pribadi</option>
                                                    <option value="99">Lainnya</option>
                                                </select>
                                            @elseif ($field === 'mulai_semester')
                                                <div class="flex items-center">
                                                    <select id="{{ strtolower($field) }}"
                                                        wire:model="{{ strtolower($field) }}"
                                                        name="{{ strtolower($field) }}"
                                                        class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                        @foreach ($semesters as $semester)
                                                            <option value="{{ $semester->id_semester }}">
                                                                {{ $semester->nama_semester }}
                                                            </option>
                                                        @endforeach
                                                        <option value="add_new">Tambah Semester</option>
                                                        {{-- <livewire:admin.semester.create /> --}}
                                                    </select>
                                                </div>
                                            @elseif($field === 'kode_prodi')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    @foreach ($prodis as $program)
                                                        <option value="{{ $program->kode_prodi }}">
                                                            {{ $program->nama_prodi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif($field === 'terima_kps')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    @php
                                                        $kps = [
                                                            1 => 'Iya',
                                                            0 => 'Tidak',
                                                        ];
                                                    @endphp
                                                    @foreach ($kps as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif($field === 'jenis_pembiayaan')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    @php
                                                        $jenis_pembiayaan = [
                                                            1 => 'Mandiri',
                                                            2 => 'Beasiswa Tidak Penuh',
                                                            3 => 'Beasiswa Penuh',
                                                        ];
                                                    @endphp
                                                    @foreach ($jenis_pembiayaan as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                            @endif

                                            @error(strtolower($field))
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>

                                <h1 class="my-4 text-xl font-bold text-left">Data Orang tua Wali</h1>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach (['nama_ibu', 'NIK_ibu', 'tanggal_lahir_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'nama_ayah', 'NIK_ayah', 'tanggal_lahir_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'nama_wali', 'NIK_wali', 'tanggal_lahir_wali', 'pendidikan_wali', 'pekerjaan_wali', 'penghasilan_wali'] as $field)
                                        @php
                                            if (
                                                $field === 'NIK_ayah' ||
                                                $field === 'NIK_ibu' ||
                                                $field === 'NIK_wali'
                                            ) {
                                                $label = Str::of($field)->replace('_', ' ');
                                            } else {
                                                $label = Str::of($field)->replace('_', ' ')->title();
                                            }
                                            if ($field === 'nama_ibu') {
                                                $label .= ' <span class="text-red-500">*</span>';
                                            }

                                        @endphp
                                        <div class="mb-4">
                                            <label for="{{ strtolower($field) }}"
                                                class="block text-sm text-left font-medium text-gray-700">{!! $label !!}</label>

                                            @if ($field === 'pendidikan_ayah' || $field === 'pendidikan_ibu' || $field === 'pendidikan_wali')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    @foreach ($pendidikans as $pendidikan)
                                                        <option value="{{ $pendidikan->kode_pendidikan_terakhir }}">
                                                            {{ $pendidikan->nama_pendidikan_terakhir }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif ($field === 'tanggal_lahir_ayah' || $field === 'tanggal_lahir_ibu' || $field === 'tanggal_lahir_wali')
                                                <input type="date" id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                            @elseif($field === 'pekerjaan_ayah' || $field === 'pekerjaan_ibu' || $field === 'pekerjaan_wali')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    @php
                                                        $pekerjaan = [
                                                            1 => 'Tidak bekerja',
                                                            2 => 'Nelayan',
                                                            3 => 'Petani',
                                                            4 => 'Peternak',
                                                            5 => 'PNS/TNI/Polri',
                                                            6 => 'Karyawan Swasta',
                                                            7 => 'Pedagang Kecil',
                                                            8 => 'Pedagang Besar',
                                                            9 => 'Wiraswasta',
                                                            10 => 'Wirausaha',
                                                            11 => 'Buruh',
                                                            12 => 'Pensiunan',
                                                            13 => 'Peneliti',
                                                            14 => 'Tim Ahli / Konsultan',
                                                            15 => 'Magang',
                                                            16 => 'Tenaga Pengajar / Instruktur / Fasilitator',
                                                            17 => 'Pimpinan / Manajerial',
                                                            98 => 'Sudah Meninggal',
                                                            99 => 'Lainnya',
                                                        ];
                                                    @endphp
                                                    @foreach ($pekerjaan as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif($field === 'penghasilan_ayah' || $field === 'penghasilan_ibu' || $field === 'penghasilan_wali')
                                                <select id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                                    <option value=" " disabled selected>Select</option>
                                                    @php
                                                        $penghasilan = [
                                                            11 => 'Kurang dari Rp. 500,000',
                                                            12 => 'Rp. 500,000 - Rp. 999,999',
                                                            13 => 'Rp. 1,000,000 - Rp. 1,999,999',
                                                            14 => 'Rp. 2,000,000 - Rp. 4,999,999',
                                                            15 => 'Rp. 5,000,000 - Rp. 20,000,000',
                                                            16 => 'Lebih dari Rp. 20,000,000',
                                                        ];
                                                    @endphp
                                                    @foreach ($penghasilan as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" id="{{ strtolower($field) }}"
                                                    wire:model="{{ strtolower($field) }}"
                                                    name="{{ strtolower($field) }}"
                                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                            @endif
                                            @error(strtolower($field))
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Submit Button inside the form -->
                            <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                                <button type="button" @click="isOpen = false"
                                    wire:click="clear('{{ $id_mahasiswa }}')"
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
