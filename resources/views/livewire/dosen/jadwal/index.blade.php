<div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
    <P class="px-4 py-2 text-lg font-bold text-customPurple">Jadwal Mengajar {{ $dosen->nama_dosen }}</P>
    <livewire:table.dosen.jadwal.jadwal-table />
    <button type="button" class="flex items-center px-4 py-2 mt-2 ml-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click='generatePdf()'>Download Jadwal Mengajar</button>
        {{-- <table class="w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">Hari</th>
                    <th class="px-3 py-2 text-center">Sesi</th>
                    <th class="px-3 py-2 text-center">Mata Kuliah</th>
                    <th class="px-3 py-2 text-center">Prodi</th>
                    <th class="px-3 py-2 text-center">Kelas</th>
                    <th class="px-3 py-2 text-center">Ruangan</th>
                    <th class="px-3 py-2 text-center">Ganti/Validasi</th>
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
                            <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->prodi->nama_prodi }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->kelas->nama_kelas }}</td>
                            @if ($jadwal->id_ruangan == 'Online')
                                <td class="px-3 py-1 text-center">Online</td>
                            @else
                                <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                            @endif
                            <td class="px-3 py-1 text-center">
                                <div class="flex flex-row justify-center">
                                    <livewire:dosen.jadwal.request :id_jadwal="$jadwal->id_jadwal"
                                        wire:key="edit-{{ $jadwal->id_jadwal }}" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table> --}}
</div>
