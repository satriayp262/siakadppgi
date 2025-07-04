<div class="flex items-center justify-center p-4">
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
            {{-- <div class="flex">
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
            </div> --}}
            <img src="{{ asset('img/kop_surat.jpg') }}" alt="Kop Surat" style="width: 100%; margin-bottom: 10px;">
            <div style=" height: 2px; margin-top: 6px;"></div>
                <div class="mb-2">
                    <span class="flex items-center justify-center mt-2 text-lg font-bold">
                        @if ($z == 'UTS')
                            KARTU PESERTA UJIAN TENGAH SEMESTER (UTS)
                        @elseif ($z == 'UAS')
                            KARTU PESERTA UJIAN AKHIR SEMESTER (UAS)
                        @endif
                    </span>
                </div>
                    <div class="grid grid-cols-2 mb-4">
                        <div class="flex">
                            <span class="font-medium text-black w-28">Semester</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-black">{{ $c }} {{ $y }}/{{ $y + 1 }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-16 font-medium text-black">NPM</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-black">{{ $mahasiswa->NIM }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-medium text-black w-28">Program Studi</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-black">{{ $mahasiswa->prodi->nama_prodi }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-16 font-medium text-black">Kelas</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-black">{{ $kelas->kelas->nama_kelas }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-medium text-black w-28">Nama</span>
                            <span class="w-4 text-center">:</span>
                            <span class="flex-1 text-black">{{ $mahasiswa->nama }}</span>
                        </div>
                    </div>
                    <div>
                            <table class="w-full bg-white border border-gray-600">
                                <thead>
                                    <tr class="items-center w-full text-sm text-black align-middle bg-gray-300">
                                        <th class="px-2 py-2 text-center border border-gray-600">Hari</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Sesi</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Mata Kuliah</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Dosen</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Ruang</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Paraf</th>
                                        <th class="px-2 py-2 text-center border border-gray-600">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedJadwals as $hari => $items)
                                        @foreach ($items as $index => $jadwal)
                                            <tr wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                                @if ($index === 0)
                                                    <td class="px-1 py-1 text-center border border-gray-400" rowspan="{{ count($items) }}">
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('dddd') }}
                                                        </div>
                                                        <div class="text-sm">
                                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                                        </div>
                                                    </td>
                                                @endif
                                                <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->sesi }}</td>
                                                @if ($jadwal->matakuliah->jenis_mata_kuliah == 'P')
                                                    <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->matakuliah->nama_mata_kuliah }} (Grup {{ $jadwal->grup }})</td>
                                                @else
                                                    <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                                @endif
                                                <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->dosen->nama_dosen }}</td>
                                                <td class="px-1 py-1 text-center border border-gray-400">
                                                    {{ $jadwal->id_ruangan == 'Online' ? 'Online' : $jadwal->ruangan->kode_ruangan }}
                                                </td>
                                                <td class="px-1 py-1 text-center border border-gray-400"></td>
                                                <td class="px-1 py-1 text-center border border-gray-400"></td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        <div class="flex pl-2 mt-6">
                            <div class="flex-col items-center pl-[10px] border border-black w-80 py-2 mb-8">
                                <span>Keterangan    :</span>
                                <div class="grid items-center grid-cols-2 text-sm w-80">
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 1</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">08.00 - 09.30</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 2</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">09.30 - 11.00</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 3</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">11.00 - 12.30</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 4</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">12.30 - 14.00</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 5</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">14.00 - 15.30</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 6</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">15.30 - 17.00</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 7</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">17.00 - 18.30</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-black ">Sesi 8</span>
                                        <span class="w-4 text-center">:</span>
                                        <span class="flex text-black">18.30 - 20.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex pl-72">
                                <div class="flex flex-col text-black ">
                                    <span class="mb-1">
                                        Kebumen, {{ \Carbon\Carbon::parse($komponen->tanggal_dibuat)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                    </span>
                                    <span class="mb-1">{{ $komponen->jabatan }}</span>

                                    <div class="h-16 pl-4 my-2">
                                        <img src="{{ asset('storage/' . $komponen->ttd) }}" alt="Tanda Tangan" class="object-contain h-full" />
                                    </div>

                                    <span>{{ $komponen->nama }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <button type="button" class="px-4 py-2 mt-4 font-bold text-white rounded bg-purple2" wire:click='generatePdf()'>Download Kartu Ujian</button>
        </div>
    @endif
</div>
