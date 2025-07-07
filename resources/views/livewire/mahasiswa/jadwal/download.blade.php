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

    <p class="heading">Jadwal Perkuliahan Semester {{ $jadwal->semester->nama_semester }} kelas {{ $jadwal->kelas->nama_kelas }}</p>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Sesi</th>
                <th>Kelas</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            @php $previousDay = null; @endphp
            @foreach ($jadwals as $jadwal)
                <tr>
                    <td>
                        @if ($jadwal->hari != $previousDay)
                            {{ $jadwal->hari }}
                            @php $previousDay = $jadwal->hari; @endphp
                        @endif
                    </td>
                    <td>
                        Sesi {{ $jadwal->sesi }} ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                    </td>
                    <td>{{ $jadwal->kelas->nama_kelas }}</td>
                    <td>
                        {{ $jadwal->matakuliah->nama_mata_kuliah }}
                        @if ($jadwal->matakuliah->jenis_mata_kuliah == 'P')
                            (Grup {{ $jadwal->grup }})
                        @endif
                    </td>
                    <td>{{ $jadwal->dosen->nama_dosen }}</td>
                    <td>
                        {{ $jadwal->id_ruangan == 'Online' ? 'Online' : $jadwal->ruangan->kode_ruangan }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
