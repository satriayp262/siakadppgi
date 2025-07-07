<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 12px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 6px;
        text-align: center;
    }

    thead tr {
        background-color: #6b46c1;
        color: white;
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

    <p class="heading">Jadwal Mengajar Dosen {{ $x->dosen->nama_dosen }} Semester {{ $x->semester->nama_semester }}</p>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Sesi</th>
                <th>Mata Kuliah</th>
                <th>Prodi</th>
                <th>Kelas</th>
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
                    <td>{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                    <td>{{ $jadwal->prodi->nama_prodi }}</td>
                    <td>{{ $jadwal->kelas->nama_kelas }}</td>
                    <td>
                        {{ $jadwal->id_ruangan == 'Online' ? 'Online' : $jadwal->ruangan->kode_ruangan }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
