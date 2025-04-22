<div class="flex items-center justify-center p-10">
    @if (!$ujian)
        <div class="flex items-center justify-center mt-10">
            <div class="flex flex-col items-center max-w-md p-6 text-center border border-purple-300 shadow-md backdrop-blur-md bg-white/50 rounded-xl">
                <!-- Ikon Calendar-Off -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3M3 11h18M5 20h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z" />
                    <line x1="3" y1="3" x2="21" y2="21" stroke="currentColor" stroke-width="1.5" />
                </svg>

                <span class="text-xl font-semibold text-gray-700">Belum ada Jadwal Ujian</span>
                <p class="mt-1 text-sm text-gray-500">Silakan cek kembali nanti atau hubungi bagian akademik.</p>
            </div>
        </div>


    @else
        <div class="flex flex-col w-3/4 p-4 bg-white border border-black">
            <div class="flex">
                <img src="{{ asset('img/Politeknik_Piksi_Ganesha_Bandung.png') }}" alt="" style="width: 80px;" class="mr-4">
                <div class="flex flex-col text-center">
                    <p class="text-2xl font-bold text-purple-700">
                        POLITEKNIK PIKSI GANESHA INDONESIA
                    </p>
                    <p class="text-sm text-purple-700">
                        Jln. Letnan Jendral Suprapto No. 73, Kranggan, Bumirejo, Kec. Kebumen, Kab. Kebumen, Jawa
                                Tengah,
                                Kebumen, Jawa Tengah, Indonesia 54311
                    </p>
                </div>

            </div>
                <div class="my-4 border-t border-black">
                    <span class="flex items-center justify-center mt-4 text-lg font-bold">KARTU {{ $z }} SEMESTER {{ $c }} TAHUN AJARAN {{ $y }}/{{ $y + 1 }}</span>
                </div>
                <div class="flex justify-center px-2">
                    <div class="flex flex-col">
                        <div class="flex">
                            <span class="w-16 font-medium text-gray-600">Nama</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-gray-800">{{ $mahasiswa->nama }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-16 font-medium text-gray-600">NIM</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-gray-800">{{ $mahasiswa->NIM }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-16 font-medium text-gray-600">Prodi</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-gray-800">{{ $mahasiswa->prodi->nama_prodi }}</span>
                        </div>
                    </div>
                    <div class="mx-4 border-r border-black"></div>
                    <div>
                        @if ($z == 'UTS' && $w >= $a || $z == 'UAS' && $w == $s)
                            <table class="w-full bg-white border border-gray-600">
                                <thead>
                                    <tr class="items-center w-full text-sm text-black align-middle">
                                        <th class="px-2 py-2 text-center border border-gray-600">Hari</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Sesi</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Mata Kuliah</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Dosen</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Kelas</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Ruangan</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @php
                                            $previousDay = null;
                                        @endphp

                                        @foreach ($jadwals as $jadwal)
                                            <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                                <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                                <td class="px-1 py-1 text-center border border-gray-400">
                                                    @if ($jadwal->hari != $previousDay)
                                                        <div>
                                                            @if ($jadwal->hari == 'Monday')
                                                                Senin
                                                            @elseif ($jadwal->hari == 'Tuesday')
                                                                Selasa
                                                            @elseif ($jadwal->hari == 'Wednesday')
                                                                Rabu
                                                            @elseif ($jadwal->hari == 'Thursday')
                                                                Kamis
                                                            @elseif ($jadwal->hari == 'Friday')
                                                                Jumat
                                                            @endif
                                                        </div>
                                                        <div class="text-sm">
                                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                                        </div>
                                                        @php
                                                            $previousDay = $jadwal->hari;
                                                        @endphp
                                                    @endif
                                                </td>
                                                <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->sesi }}</td>
                                                <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                                <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->dosen->nama_dosen }}</td>
                                                <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->kelas->nama_kelas }}</td>
                                                @if ($jadwal->id_ruangan == 'Online')
                                                    <td class="px-1 py-1 text-center border border-gray-400">Online</td>
                                                @else
                                                    <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->ruangan->kode_ruangan }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                        @else
                            @if ($z == 'UTS')
                                <div class="flex justify-center w-full mt-2">
                                    <div class="flex items-center gap-3 px-5 py-3 font-semibold text-yellow-800 bg-yellow-100 border border-yellow-300 rounded-lg shadow-md w-fit">
                                        <!-- Ikon uang -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.105 0-2 .672-2 1.5S10.895 11 12 11s2 .672 2 1.5S13.105 14 12 14m0-6v6m-9 2a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v10z" />
                                        </svg>
                                        <span class="text-sm sm:text-base">Lunasi pembayaran dari bulan A sampai D</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex justify-center w-full mt-2">
                                    <div class="flex items-center gap-3 px-5 py-3 font-semibold text-yellow-800 bg-yellow-100 border border-yellow-300 rounded-lg shadow-md w-fit">
                                        <!-- Ikon uang -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.105 0-2 .672-2 1.5S10.895 11 12 11s2 .672 2 1.5S13.105 14 12 14m0-6v6m-9 2a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v10z" />
                                        </svg>
                                        <span class="text-sm sm:text-base">Lunasi semua pembayaran</span>
                                    </div>
                                </div>
                             @endif
                        @endif
                    </div>
                </div>
                <button type="button" class="px-4 py-2 mt-4 font-bold text-white rounded bg-purple2" wire:click='generatePdf()'>Download Kartu Ujian</button>
        </div>
    @endif
</div>
