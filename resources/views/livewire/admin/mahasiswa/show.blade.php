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
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
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
                        @php
                            $jk = [
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ];
                            $agama = [
                                1 => 'Islam',
                                2 => 'Kristen',
                                3 => 'Katolik',
                                4 => 'Hindu',
                                5 => 'Buddha',
                                6 => 'Konghucu',
                                99 => 'Lainnya',
                            ];
                            $jalur_pendaftaran = [
                                3 => 'Penelusuran Minat dan Kemampuan (PMDK)',
                                4 => 'Prestasi',
                                9 => 'Program Internasional',
                                11 => 'Program Kerjasama Perusahaan/Institusi/Pemerintah',
                                12 => 'Seleksi Mandiri',
                                13 => 'Ujian Masuk Bersama Lainnya',
                                14 => 'Seleksi Nasional Berdasarkan Tes (SNBT)',
                                15 => 'Seleksi Nasional Berdasarkan Prestasi (SNBP)',
                            ];
                            $jenis_pendaftaran = [
                                1 => 'Peserta didik baru',
                                2 => 'Pindahan',
                                3 => 'Naik Kelas',
                                4 => 'Akselerasi',
                                5 => 'Mengulang',
                                6 => 'Lanjutan semester',
                                8 => 'Pindahan Alih Bentuk',
                                13 => 'RPL Perolehan SKS',
                                14 => 'Pendidikan Non Gelar (Course)',
                                15 => 'Fast Track',
                                16 => 'RPL Transfer SKS',
                            ];
                            $jenis_tempat_tinggal = [
                                1 => 'Bersama orang tua',
                                2 => 'Wali',
                                3 => 'Kost',
                                4 => 'Asrama',
                                5 => 'Panti asuhan',
                                10 => 'Rumah sendiri',
                                99 => 'Lainnya',
                            ];
                            $jenis_transportasi = [
                                1 => 'Jalan kaki',
                                3 => 'Angkutan umum/bus/pete-pete',
                                4 => 'Mobil/bus antar jemput',
                                5 => 'Kereta api',
                                6 => 'Ojek',
                                7 => 'Andong/bendi/sado/dokar/delman/becak',
                                8 => 'Perahu penyeberangan/rakit/getek',
                                11 => 'Kuda',
                                12 => 'Sepeda',
                                13 => 'Sepeda motor',
                                14 => 'Mobil pribadi',
                                99 => 'Lainnya',
                            ];
                            $pembiayaan = [
                                1 => 'Mandiri',
                                2 => 'Beasiswa Tidak Penuh',
                                3 => 'Beasiswa Penuh',
                            ];
                        @endphp
                        @foreach (['NIM' => 'NIM', 'NIK' => 'NIK', 'nama' => 'Nama Mahasiswa', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'jenis_kelamin' => 'Jenis Kelamin', 'mulai_semester' => 'Mulai Semester', 'kode_prodi' => 'Prodi', 'agama' => 'Agama', 'alamat' => 'Alamat', 'jalur_pendaftaran' => 'Jalur Pendaftaran', 'kewarganegaraan' => 'Kewarganegaraan', 'jenis_pendaftaran' => 'Jenis Pendaftaran', 'tanggal_masuk_kuliah' => 'Tanggal Masuk Kuliah', 'jenis_tempat_tinggal' => 'Jenis Tempat Tinggal', 'telp_rumah' => 'Telp Rumah', 'no_hp' => 'No HP', 'email' => 'Email', 'terima_kps' => 'Terima KPS', 'no_kps' => 'No KPS', 'jenis_transportasi' => 'Jenis Transportasi', 'kode_pt_asal' => 'Kode PT Asal', 'nama_pt_asal' => 'Nama PT Asal', 'kode_prodi_asal' => 'Kode Prodi Asal', 'nama_prodi_asal' => 'Nama Prodi Asal', 'jenis_pembiayaan' => 'Jenis Pembiayaan', 'jumlah_biaya_masuk' => 'Jumlah Biaya Masuk'] as $field => $label)
                            <div class="mb-4 text-left border w-full h-full p-2">
                                <label for="{{ $field }}"
                                    class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                                <p class="text-sm text-gray-500">
                                    @php
                                        if ($field == 'agama') {
                                            $value = $agama[$mahasiswa->$field] ?? 'Data Belum Ada';
                                        } elseif ($field == 'jalur_pendaftaran') {
                                            $value = $jalur_pendaftaran[$mahasiswa->$field] ?? 'Data Belum Ada';
                                        } elseif ($field == 'jenis_pendaftaran') {
                                            $value = $jenis_pendaftaran[$mahasiswa->$field] ?? 'Data Belum Ada';
                                        } elseif ($field == 'jenis_tempat_tinggal') {
                                            $value = $jenis_tempat_tinggal[$mahasiswa->$field] ?? 'Data Belum Ada';
                                        } elseif ($field == 'jenis_transportasi') {
                                            $value = $jenis_transportasi[$mahasiswa->$field] ?? 'Data Belum Ada';
                                        } elseif ($field == 'jenis_pembiayaan') {
                                            $value = $pembiayaan[$mahasiswa->$field] ?? 'Data Belum Ada';
                                        } elseif ($field == 'jenis_kelamin') {
                                            $value = $jk[$mahasiswa->$field] ?? 'Data Belum Ada';
                                        } elseif ($field == 'kode_prodi') {
                                            $value = $mahasiswa->prodi->nama_prodi ?? 'Data Belum Ada';
                                        } elseif ($field == 'mulai_semester') {
                                            $value = $mahasiswa->semester->nama_semester ?? 'Data Belum Ada';
                                        } elseif ($field == 'tanggal_lahir') {
                                            $value = $mahasiswa->tanggal_lahir
                                                ? \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->format('d-m-Y')
                                                : 'Data Belum Ada';
                                        } elseif ($field == 'tanggal_masuk_kuliah') {
                                            $value = $mahasiswa->tanggal_masuk_kuliah
                                                ? \Carbon\Carbon::parse($mahasiswa->tanggal_masuk_kuliah)->format(
                                                    'd-m-Y',
                                                )
                                                : 'Data Belum Ada';
                                        } elseif ($field == 'jenis_kelamin') {
                                            $value =
                                                $mahasiswa->terima_kps === '1'
                                                    ? 'Iya'
                                                    : ($mahasiswa->terima_kps === '0'
                                                        ? 'Tidak'
                                                        : 'Data Belum Ada');
                                        } elseif ($field == 'jumlah_biaya_masuk') {
                                            $value = $mahasiswa->jumlah_biaya_masuk
                                                ? number_format($mahasiswa->jumlah_biaya_masuk, 2, ',', '.')
                                                : 'Data Belum Ada';
                                        } else {
                                            $value = $mahasiswa->$field ?? 'Data Belum Ada';
                                        }
                                    @endphp
                                    {{ $value }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <h1 class="mt-2 text-xl font-bold text-left">Data Orang tua Wali</h1>
                    <div class="grid grid-cols-3 mt-4">
                        @php
                            $penghasilan = [
                                11 => 'Kurang dari Rp. 500,000',
                                12 => 'Rp. 500,000 - Rp. 999,999',
                                13 => 'Rp. 1,000,000 - Rp. 1,999,999',
                                14 => 'Rp. 2,000,000 - Rp. 4,999,999',
                                15 => 'Rp. 5,000,000 - Rp. 20,000,000',
                                16 => 'Lebih dari Rp. 20,000,000',
                            ];
                            $kodePenghasilanAyah = $mahasiswa->orangtuaWali->penghasilan_ayah ?? null;
                            $penghasilanAyah = $penghasilan[$kodePenghasilanAyah] ?? null;
                            $kodePenghasilanIbu = $mahasiswa->orangtuaWali->penghasilan_ibu ?? null;
                            $penghasilanIbu = $penghasilan[$kodePenghasilanIbu] ?? null;
                            $kodePenghasilanWali = $mahasiswa->orangtuaWali->penghasilan_wali ?? null;
                            $penghasilanWali = $penghasilan[$kodePenghasilanWali] ?? null;

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
                            $kodepekerjaanAyah = $mahasiswa->orangtuaWali->pekerjaan_ayah ?? null;
                            $pekerjaanAyah = $pekerjaan[$kodepekerjaanAyah] ?? null;
                            $kodepekerjaanIbu = $mahasiswa->orangtuaWali->pekerjaan_ibu ?? null;
                            $pekerjaanIbu = $pekerjaan[$kodepekerjaanIbu] ?? null;
                            $kodepekerjaanWali = $mahasiswa->orangtuaWali->pekerjaan_wali ?? null;
                            $pekerjaanWali = $pekerjaan[$kodepekerjaanWali] ?? null;
                            $parentData = [
                                'Nama Ayah' => $mahasiswa->orangtuaWali->nama_ayah ?? 'Data Belum Ada',
                                'Nama Ibu' => $mahasiswa->orangtuaWali->nama_ibu ?? 'Data Belum Ada',
                                'Nama Wali' => $mahasiswa->orangtuaWali->nama_wali ?? 'Data Belum Ada',

                                'NIK Ayah' => $mahasiswa->orangtuaWali->NIK_ayah ?? 'Data Belum Ada',
                                'NIK Ibu' => $mahasiswa->orangtuaWali->NIK_ibu ?? 'Data Belum Ada',
                                'NIK Wali' => $mahasiswa->orangtuaWali->NIK_wali ?? 'Data Belum Ada',

                                'Pendidikan Ayah' =>
                                    $mahasiswa->orangtuaWali->pendidikanAyah->nama_pendidikan_terakhir ??
                                    'Data Belum Ada',
                                'Pendidikan Ibu' =>
                                    $mahasiswa->orangtuaWali->pendidikanIbu->nama_pendidikan_terakhir ??
                                    'Data Belum Ada',
                                'Pendidikan Wali' =>
                                    $mahasiswa->orangtuaWali->pendidikanWali->nama_pendidikan_terakhir ??
                                    'Data Belum Ada',

                                'Pekerjaan Ayah' => $pekerjaanAyah ?? 'Data Belum Ada',
                                'Pekerjaan Ibu' => $pekerjaanIbu ?? 'Data Belum Ada',
                                'Pekerjaan Wali' => $pekerjaanWali ?? 'Data Belum Ada',

                                'Penghasilan Ayah' => $penghasilanAyah ?? 'Data Belum Ada',
                                'Penghasilan Ibu' => $penghasilanIbu ?? 'Data Belum Ada',
                                'Penghasilan Wali' => $penghasilanWali ?? 'Data Belum Ada',
                            ];
                        @endphp

                        @foreach ($parentData as $label => $value)
                            <div class="mb-4 text-left border w-full h-full p-2">
                                <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                                <p class="text-sm text-gray-500">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
