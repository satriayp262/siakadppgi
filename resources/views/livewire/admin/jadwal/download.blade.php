<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
        font-size: 12px;
    }

    thead {
        background-color: #6b46c1;
        color: white;
    }

    .bg-gray-100 {
        background-color: #f3f4f6;
        font-weight: bold;
        text-align: left;
    }

    .bg-gray-200 {
        background-color: #e5e7eb;
        font-weight: bold;
        text-align: left;
    }

    .italic {
        font-style: italic;
    }

    .kop-surat {
        width: 100%;
        margin-bottom: 10px;
    }

    .heading {
        font-size: 16px;
        font-weight: bold;
        color: black;
        margin: 20px 0 5px 0;
        text-align: center;
    }
</style>

<div>
    <img src="{{ public_path('img/kop_surat.jpg') }}" alt="Kop Surat" class="kop-surat">

    <p class="heading">Jadwal Perkuliahan Semester {{ $x->semester->nama_semester }}</p>

    <table>
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Sesi</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $previousProdi = null;
                $previousSemester = null;
            @endphp

            @foreach ($prodis as $prodi)
                @if ($jadwals->where('kode_prodi', $prodi->kode_prodi)->isEmpty())
                    @if ($previousProdi != $prodi->nama_prodi)
                        <tr>
                            <td colspan="6" class="bg-gray-200">{{ $prodi->nama_prodi }}</td>
                        </tr>
                        @php $previousProdi = $prodi->nama_prodi; @endphp
                    @endif
                @endif

                @foreach ($jadwals->where('kode_prodi', $prodi->kode_prodi)->groupBy('id_semester') as $idSemester => $jadwalsBySemester)
                    @php
                        $previousDay = null;
                        $previous = null;
                        $semester = $jadwalsBySemester->first()->semester->nama_semester ?? 'Semester Tidak Diketahui';
                    @endphp

                    @if ($previousSemester != $semester || $previousSemester == $semester)
                        <tr>
                            <td colspan="6" class="bg-gray-100">{{ $prodi->nama_prodi }} {{ $semester }}</td>
                        </tr>
                        @php $previousSemester = $semester; @endphp
                    @endif

                    @foreach ($jadwalsBySemester as $jadwal)
                        @if ($previous != null && $previous != $jadwal->kelas->nama_kelas)
                            <tr>
                                <td colspan="6" class="bg-gray-100">&nbsp;</td>
                            </tr>
                        @endif

                        <tr>
                            <td>
                                @if ($jadwal->kelas->nama_kelas != $previous)
                                    {{ $jadwal->kelas->nama_kelas }}
                                    @php $previous = $jadwal->kelas->nama_kelas; @endphp
                                @endif
                            </td>
                            <td>
                                @if ($jadwal->hari != $previousDay)
                                    {{ $jadwal->hari }}
                                    @php $previousDay = $jadwal->hari; @endphp
                                @endif
                            </td>
                            <td>{{ $jadwal->sesi }}</td>

                            <td>
                                @if ($jadwal->matakuliah->jenis_mata_kuliah == 'P')
                                    {{ $jadwal->matakuliah->nama_mata_kuliah }} (Grup {{ $jadwal->grup }})
                                @else
                                    {{ $jadwal->matakuliah->nama_mata_kuliah }}
                                @endif
                            </td>

                            <td>{{ $jadwal->dosen->nama_dosen }}</td>

                            <td>
                                @if ($jadwal->id_ruangan == 'Online')
                                    Online
                                @else
                                    {{ $jadwal->ruangan->kode_ruangan }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach

                @if ($jadwals->where('kode_prodi', $prodi->kode_prodi)->isEmpty())
                    <tr>
                        <td colspan="6" class="italic text-center">Tidak ada jadwal untuk prodi ini.</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
