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
        background-color: #5e2b97;
        color: white;
    }
</style>

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
                <td>{{ $jadwal->sesi }}</td>
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
