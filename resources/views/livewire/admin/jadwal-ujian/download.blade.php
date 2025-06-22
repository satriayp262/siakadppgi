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
    <img src="{{ public_path('img/kop_surat.jpg') }}" class="kop-surat" alt="Kop Surat">

    @if ($x->jenis_ujian == 'UTS')
        <p class="heading">Jadwal UTS Semester {{$x->semester->nama_semester}}</p>
    @else
        <p class="heading">Jadwal UAS Semester {{$x->semester->nama_semester}}</p>
    @endif


    <table>
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Hari, Tanggal</th>
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
                $previousKelas = null;
                $previousTanggal = null;
                $previousDay = null;
            @endphp

            @foreach ($prodis as $prodi)
                @php
                    $prodiJadwal = $jadwals->where('kode_prodi', $prodi->kode_prodi);
                @endphp

                @if ($prodiJadwal->isEmpty())
                    <tr>
                        <td colspan="6" class="bg-gray-200">{{ $prodi->nama_prodi }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="italic text-center">Tidak ada jadwal untuk prodi ini.</td>
                    </tr>
                    @continue
                @endif

                @foreach ($prodiJadwal->groupBy('id_semester') as $idSemester => $jadwalsBySemester)
                    @php
                        $semester = $jadwalsBySemester->first()->semester->nama_semester ?? 'Semester Tidak Diketahui';
                    @endphp

                    <tr>
                        <td colspan="6" class="bg-gray-100">{{ $prodi->nama_prodi }} {{ $semester }}</td>
                    </tr>

                    @foreach ($jadwalsBySemester as $jadwal)
                        @php
                            $ujian = \App\Models\Jadwal::where('id_kelas', $jadwal->id_kelas)->first(['jenis_ujian']);
                            $jenisUjian = $ujian->jenis_ujian ?? '-';
                            $currentKelas = $jadwal->kelas->nama_kelas;
                            $currentTanggal = $jadwal->tanggal;
                            $dayName = $currentTanggal
                                ? \Carbon\Carbon::parse($currentTanggal)->format('l')
                                : null;
                            $tanggalFormatted = $currentTanggal
                                ? \Carbon\Carbon::parse($currentTanggal)->locale('id')->isoFormat('DD MMMM YYYY')
                                : null;
                        @endphp

                        @if ($previousKelas != null && $previousKelas != $currentKelas)
                            <tr><td colspan="6" class="bg-gray-100" style="padding: 12px;"></td></tr>
                        @endif

                        <tr>
                            <td>
                                @if ($previousKelas !== $currentKelas)
                                    {{ $currentKelas }} ({{ $jenisUjian }})
                                    @php $previousKelas = $currentKelas; @endphp
                                @endif
                            </td>
                            <td>
                                @if ($currentTanggal && ($currentTanggal !== $previousTanggal))
                                    @switch($dayName)
                                        @case('Monday') Senin @break
                                        @case('Tuesday') Selasa @break
                                        @case('Wednesday') Rabu @break
                                        @case('Thursday') Kamis @break
                                        @case('Friday') Jumat @break
                                        @default {{ $dayName }}
                                    @endswitch,
                                    {{ $tanggalFormatted }}
                                    @php $previousTanggal = $currentTanggal; @endphp
                                @endif
                            </td>
                            <td>{{ $jadwal->sesi }}</td>
                            <td>{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                            <td>{{ $jadwal->dosen->nama_dosen }}</td>
                            <td>{{ $jadwal->id_ruangan === 'Online' ? 'Online' : $jadwal->ruangan->kode_ruangan }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
