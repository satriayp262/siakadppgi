<div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
    <P class="px-4 py-2 text-lg font-bold text-customPurple">Jadwal Kelas {{ $krs->kelas->nama_kelas }}</P>
    <div class="flex justify-end mt-2">
        <button type="button"
            class="flex px-4 py-2 ml-2 font-bold text-white align-middle bg-blue-500 rounded hover:bg-blue-700"
            wire:click='generatePdf()'>
            Download Jadwal Perkuliahan
        </button>
    </div>
    <livewire:table.mahasiswa.jadwal.jadwal-table />
        {{-- <table class="w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">Hari</th>
                    <th class="px-3 py-2 text-center">Sesi</th>
                    <th class="px-3 py-2 text-center">Kelas</th>
                    <th class="px-3 py-2 text-center">Mata Kuliah</th>
                    <th class="px-3 py-2 text-center">Dosen</th>
                    <th class="px-3 py-2 text-center">Ruangan</th>
                </tr>
            </thead>
                <tbody>
                    @php
                        $previousDay = null;
                    @endphp

                    @foreach ($jadwals as $jadwal)
                        <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                            <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                            <td class="px-3 py-1 text-center">
                                @if ($jadwal->hari != $previousDay)
                                    {{ $jadwal->hari }}
                                    @php
                                        $previousDay = $jadwal->hari;
                                    @endphp
                                @endif
                            </td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->kelas->nama_kelas }}</td>
                            @if ($jadwal->matakuliah->jenis_mata_kuliah == 'P')
                                <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }} (Grup {{ $jadwal->grup }})</td>
                            @else
                                <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                            @endif
                            <td class="px-3 py-1 text-center">{{ $jadwal->dosen->nama_dosen }}</td>
                            @if ($jadwal->id_ruangan == 'Online')
                                <td class="px-3 py-1 text-center">Online</td>
                            @else
                                <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
        </table> --}}
</div>
