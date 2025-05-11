<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="px-3 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700"><svg
            class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
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
                        @foreach (['NIM' => 'NIM', 'NIK' => 'NIK', 'NISN' => 'NISN', 'NPWP' => 'NPWP', 'nama' => 'Nama Mahasiswa', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'jenis_kelamin' => 'Jenis Kelamin', 'mulai_semester' => 'Mulai Semester', 'kode_prodi' => 'Prodi', 'agama' => 'Agama', 'alamat' => 'Alamat', 'jalur_pendaftaran' => 'Jalur Pendaftaran', 'kewarganegaraan' => 'Kewarganegaraan', 'jenis_pendaftaran' => 'Jenis Pendaftaran', 'tanggal_masuk_kuliah' => 'Tanggal Masuk Kuliah', 'jenis_tempat_tinggal' => 'Jenis Tempat Tinggal', 'telp_rumah' => 'Telp Rumah', 'no_hp' => 'No HP', 'email' => 'Email', 'terima_kps' => 'Terima KPS', 'no_kps' => 'No KPS', 'jenis_transportasi' => 'Jenis Transportasi', 'kode_pt_asal' => 'Kode PT Asal', 'nama_pt_asal' => 'Nama PT Asal', 'kode_prodi_asal' => 'Kode Prodi Asal', 'nama_prodi_asal' => 'Nama Prodi Asal', 'jenis_pembiayaan' => 'Jenis Pembiayaan', 'jumlah_biaya_masuk' => 'Jumlah Biaya Masuk'] as $field => $label)
                            <div class="mb-4 text-left border w-full h-full p-2">
                                <label for="{{ $field }}"
                                    class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                                <p class="text-sm text-gray-500">
                                    @php
                                        $value = match ($field) {
                                            'jenis_kelamin' => $mahasiswa->getJenisKelamin(),
                                            'agama' => $mahasiswa->getAgama(),
                                            'jalur_pendaftaran' => $mahasiswa->getJalurPendaftaran(),
                                            'jenis_pendaftaran' => $mahasiswa->getJenisPendaftaran(),
                                            'jenis_tempat_tinggal' => $mahasiswa->getJenisTempatTinggal(),
                                            'jenis_transportasi' => $mahasiswa->getJenisTransportasi(),
                                            'jenis_pembiayaan' => $mahasiswa->getJenisPembiayaan(),
                                            'mulai_semester' => $mahasiswa->semester->nama_semester,
                                            'terima_kps' => $mahasiswa->terima_kps === '1' ? 'Ya' : 'Tidak',
                                            'jumlah_biaya_masuk' => $mahasiswa->jumlah_biaya_masuk
                                                ? number_format($mahasiswa->jumlah_biaya_masuk, 2, ',', '.')
                                                : 'Data Belum Ada',
                                            'tanggal_masuk_kuliah' => $mahasiswa->tanggal_masuk_kuliah
                                                ? \Carbon\Carbon::parse($mahasiswa->tanggal_masuk_kuliah)->format(
                                                    'd-m-Y',
                                                )
                                                : 'Data Belum Ada',
                                            default => $mahasiswa->$field ?? 'Data Belum Ada',
                                        };
                                    @endphp
                                    {{ $value }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <h1 class="mt-2 text-xl font-bold text-left">Data Orang tua Wali</h1>
                    <div class="grid grid-cols-3 mt-4">
                        @php
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

                                'Pekerjaan Ayah' => $mahasiswa->orangtuaWali->getPekerjaanAyah() ?? 'Data Belum Ada',
                                'Pekerjaan Ibu' => $mahasiswa->orangtuaWali->getPekerjaanIbu() ?? 'Data Belum Ada',
                                'Pekerjaan Wali' => $mahasiswa->orangtuaWali->getPekerjaanWali() ?? 'Data Belum Ada',

                                'Penghasilan Ayah' =>
                                    $mahasiswa->orangtuaWali->getPenghasilanAyah() ?? 'Data Belum Ada',
                                'Penghasilan Ibu' => $mahasiswa->orangtuaWali->getPenghasilanIbu() ?? 'Data Belum Ada',
                                'Penghasilan Wali' =>
                                    $mahasiswa->orangtuaWali->getPenghasilanWali() ?? 'Data Belum Ada',
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
