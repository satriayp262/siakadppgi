<div class="flex items-center justify-center p-10">
    @if (!$ujian)
        <div class="flex">
            <span class="flex items-center justify-center mt-4 text-lg font-bold">
                Belum ada Jadwal Ujian
            </span>
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
                                        <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->kelas->matkul->nama_mata_kuliah }}</td>
                                        <td class="px-1 py-1 text-center border border-gray-400">{{ $jadwal->kelas->matkul->dosen->nama_dosen }}</td>
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
                </div>
            </div>
        </div>
    @endif
</div>
