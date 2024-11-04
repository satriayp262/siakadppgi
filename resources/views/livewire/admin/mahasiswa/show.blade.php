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
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->nama ?? 'Data Belum Ada' }}</p>
                        </div>


                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="NIM" class="block text-sm font-medium text-gray-700">NIM</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->NIM ?? 'Data Belum Ada' }}</p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="prodi" class="block text-sm font-medium text-gray-700">Prodi</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->prodi->nama_prodi ?? 'Data Belum Ada' }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Tanggal
                                Lahir</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->tempat_lahir ?? 'Data Belum Ada' }},
                                {{ $mahasiswa->tanggal_lahir ? \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->format('d-m-Y') : 'Data Belum Ada' }}
                            </p>
                        </div>

                        @php
                            $jk = [
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ];
                        @endphp
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis
                                Kelamin</label>
                            <p class="text-sm text-gray-500">
                                {{ $jk[$mahasiswa->jenis_kelamin ?? null] ?? 'Data Belum Ada' }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="NIK" class="block text-sm font-medium text-gray-700">NIK</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->NIK ?? 'Data Belum Ada' }}</p>
                        </div>
                        @php
                            $agama = [
                                1 => 'Islam',
                                2 => 'Kristen',
                                3 => 'Katolik',
                                4 => 'Hindu',
                                5 => 'Buddha',
                                6 => 'Konghucu',
                                99 => 'Lainnya',
                            ];
                        @endphp
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                            <p class="text-sm text-gray-500">{{ $agama[$mahasiswa->agama ?? null] ?? 'Data Belum Ada' }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->alamat ?? 'Data Belum Ada' }}</p>
                        </div>
                        @php
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
                        @endphp


                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="jalur_pendaftaran" class="block text-sm font-medium text-gray-700">Jalur
                                Pendaftaran</label>
                            <p class="text-sm text-gray-500">
                                {{ $jalur_pendaftaran[$mahasiswa->jalur_pendaftaran ?? null] ?? 'Data Belum Ada' }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="kewarganegaraan"
                                class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->kewarganegaraan ?? 'Data Belum Ada' }}
                            </p>
                        </div>

                        @php
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
                        @endphp
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="jenis_pendaftaran" class="block text-sm font-medium text-gray-700">Jenis
                                Pendaftaran</label>
                            <p class="text-sm text-gray-500">
                                {{ $jenis_pendaftaran[$mahasiswa->jenis_pendaftaran ?? null] ?? 'Data Belum Ada' }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="tanggal_masuk_kuliah" class="block text-sm font-medium text-gray-700">Tanggal
                                Masuk Kuliah</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->tanggal_masuk_kuliah ? \Carbon\Carbon::parse($mahasiswa->tanggal_masuk_kuliah)->format('d-m-Y') : 'Data Belum Ada' }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="mulai_semester"
                                class="block text-sm font-medium
                            text-gray-700">Mulai
                                Semester</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->semester->nama_semester ?? 'Data Belum Ada' }}
                            </p>
                        </div>
                        @php
                            $jenis_tempat_tinggal = [
                                1 => 'Bersama orang tua',
                                2 => 'Wali',
                                3 => 'Kost',
                                4 => 'Asrama',
                                5 => 'Panti asuhan',
                                10 => 'Rumah sendiri',
                                99 => 'Lainnya',
                            ];
                        @endphp
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="jenis_tempat_tinggal" class="block text-sm font-medium text-gray-700">Jenis
                                Tempat Tinggal</label>
                            <p class="text-sm text-gray-500">
                                {{ $jenis_tempat_tinggal[$mahasiswa->jenis_tempat_tinggal ?? null] ?? 'Data Belum Ada' }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="telp_rumah"
                                class="block text
                            -sm font-medium text-gray-700">Telp
                                Rumah</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->telp_rumah ?? 'Data Belum Ada' }}</p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->no_hp ?? 'Data Belum Ada' }}</p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->email ?? 'Data Belum Ada' }}</p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="terima_kps"
                                class="block text
                            -sm font-medium text-gray-700">Terima
                                KPS</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->terima_kps === '1' ? 'Iya' : ($mahasiswa->terima_kps === '0' ? 'Tidak' : 'Data Belum Ada') }}
                            </p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="no_kps" class="block text-sm font-medium text-gray-700">No KPS</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->no_kps ?? 'Data Belum Ada' }}</p>
                        </div>
                        @php
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
                        @endphp
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="jenis_transportasi"
                                class="block text
                            -sm font-medium text-gray-700">Jenis
                                Transportasi</label>
                            <p class="text-sm text-gray-500">{{ $jenis_transportasi[$mahasiswa->jenis_transportasi ?? null ] ?? 'Data Belum Ada' }}
                            </p>
                        </div>


                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="kode_pt_asal"
                                class="block text
                            -sm font-medium text-gray-700">Kode
                                PT Asal</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->kode_pt_asal ?? 'Data Belum Ada' }}</p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="nama_pt_asal"
                                class="block text
                            -sm font-medium text-gray-700">Nama
                                PT Asal</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->nama_pt_asal ?? 'Data Belum Ada' }}</p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="kode_prodi_asal"
                                class="block text
                            -sm font-medium text-gray-700">Kode
                                Prodi Asal</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->kode_prodi_asal ?? 'Data Belum Ada' }}</p>
                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="nama_prodi_asal"
                                class="block text
                            -sm font-medium text-gray-700">Nama
                                Prodi Asal</label>
                            <p class="text-sm text-gray-500">{{ $mahasiswa->nama_prodi_asal ?? 'Data Belum Ada' }}</p>
                        </div>

                        @php
                            $pembiayaan = [
                                1 => 'Mandiri',
                                2 => 'Beasiswa Tidak Penuh',
                                3 => 'Beasiswa Penuh',
                            ];
                        @endphp
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="jenis_pembiayaan"
                                class="block text
                            -sm font-medium text-gray-700">Jenis
                                Pembiayaan</label>
                            <p class="text-sm text-gray-500">
                                {{ $pembiayaan[$mahasiswa->jenis_pembiayaan] ?? 'Data Belum Ada' }}
                            </p>

                        </div>

                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label for="jumlah_biaya_masuk"
                                class="block text
                            -sm font-medium text-gray-700">Jumlah
                                Biaya Masuk</label>
                            <p class="text-sm text-gray-500">Rp.
                                {{ $mahasiswa->jumlah_biaya_masuk ? number_format($mahasiswa->jumlah_biaya_masuk, 2, ',', '.') : 'Data Belum Ada' }}
                            </p>
                        </div>

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
                        @endphp


                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->nama_ayah ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">NIK Ayah</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->NIK_ayah ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Pendidikan Ayah</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->pendidikanAyah->nama_pendidikan_terakhir ?? 'Data Belum Ada' }}
                            </p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                            <p class="text-sm text-gray-500">
                                {{ $pekerjaanAyah ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Penghasilan Ayah</label>
                            <p class="text-sm text-gray-500">{{ $penghasilanAyah ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->nama_ibu ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">NIK Ibu</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->NIK_ibu ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Pendidikan Ibu</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->pendidikanIbu->nama_pendidikan_terakhir ?? 'Data Belum Ada' }}
                            </p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                            <p class="text-sm text-gray-500">
                                {{ $pekerjaanIbu ?? 'Data Belum Ada' }}
                            </p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Penghasilan Ibu</label>
                            <p class="text-sm text-gray-500">
                                {{ $penghasilanIbu ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Nama Wali</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->nama_wali ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">NIK Wali</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->NIK_wali ?? 'Data Belum Ada' }}</p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Pekerjaan Wali</label>
                            <p class="text-sm text-gray-500">
                                {{ $pekerjaanWali ?? 'Data Belum Ada' }}
                            </p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Pendidikan Wali</label>
                            <p class="text-sm text-gray-500">
                                {{ $mahasiswa->orangtuaWali->pendidikanWali->nama_pendidikan_terakhir ?? 'Data Belum Ada' }}
                            </p>
                        </div>
                        <div class="mb-4 text-left border w-full h-full p-2">
                            <label class="block text-sm font-medium text-gray-700">Penghasilan Wali</label>
                            <p class="text-sm text-gray-500">
                                {{ $penghasilanWali ?? 'Data Belum Ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
