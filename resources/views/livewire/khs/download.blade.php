<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Hasil Studi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
            text-align: center;
        }

        .table th,
        .table td {
            padding: 4px;
        }

        .info td {
            padding: 4px;
            font-size: 10px;
        }

        .signature {
            text-align: right;
            margin-top: 40px;
        }

        .signature img {
            width: 100px;
        }
    </style>
</head>

<body>
    <img src="{{ public_path('img/kop_surat.jpg') }}" alt="Kop Surat" style="width: 100%; margin-bottom: 10px;">

    <table style="width: 100%; margin-top: 10px; margin-bottom: 10px; font-size: 12px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding: 3px 10px;">NAMA</td>
                        <td style="padding: 3px 10px;">:</td>
                        <td style="padding: 3px 10px;">{{ $mahasiswa->nama }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 10px;">NIM</td>
                        <td style="padding: 3px 10px;">:</td>
                        <td style="padding: 3px 10px;">{{ $mahasiswa->NIM }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 10px;">JENIS KELAMIN</td>
                        <td style="padding: 3px 10px;">:</td>
                        <td style="padding: 3px 10px;">{{ $mahasiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                </table>
            </td>
            @php
                $semesterMap = [
                    1 => '1 (SATU)',
                    2 => '2 (DUA)',
                    3 => '3 (TIGA)',
                    4 => '4 (EMPAT)',
                    5 => '5 (LIMA)',
                    6 => '6 (ENAM)',
                    7 => '7 (TUJUH)',
                    8 => '8 (DELAPAN)',
                    9 => '9 (SEMBILAN)',
                    10 => '10 (SEPULUH)',
                    11 => '11 (SEBELAS)',
                    12 => '12 (DUABELAS)',
                ];
                $semesterText =
                    $semesterMap[$mahasiswa->getSemester($x->id_semester)] ?? $mahasiswa->getSemester($x->id_semester);
            @endphp
            <td style="width: 50%; vertical-align: top;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding: 3px 10px;">PROGRAM STUDI</td>
                        <td style="padding: 3px 10px;">:</td>
                        <td style="padding: 3px 10px;">{{ $mahasiswa->prodi->nama_prodi }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 10px;">SEMESTER</td>
                        <td style="padding: 3px 10px;">:</td>
                        <td style="padding: 3px 10px;">{{ $semesterText }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table class="table">
        <thead>
            <tr>
                <th style="width: 3%">No</th>
                <th style="width: 8%">Kode MK</th>
                <th style="width: 45%">Mata Kuliah</th>
                <th style="width: 8%">SKS</th>
                <th style="width: 12%">Nilai Mutu</th>
                <th style="width: 12%">Nilai Angka</th>
                <th style="width: 12%">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @php
                $jumlahSKS = 0;
                $jumlahNilai = 0;
            @endphp
            @foreach ($khs as $index => $item)
                @php
                    $sks =
                        $item->matkul->sks_tatap_muka +
                        $item->matkul->sks_simulasi +
                        $item->matkul->sks_praktek +
                        $item->matkul->sks_praktek_lapangan;
                    $nilaiAngka = $item->getGrade($item->bobot)['angka'];
                    $nilaiHuruf = $item->getGrade($item->bobot)['huruf'];
                    $totalNilai = $nilaiAngka * $sks;
                    if ($item->bobot > 59) {
                        $jumlahSKS += $sks;
                        $jumlahNilai += $item->getGrade($item->bobot)['angka'] * $sks;
                    }
                @endphp
                @if ($item->bobot <= 59)
                    <tr style="background-color: #dc2626;">

                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->matkul->kode_mata_kuliah }}</td>
                        <td style="text-align: left;">{{ $item->matkul->nama_mata_kuliah }}</td>
                        <td>{{ $sks }}</td>
                        <td>{{ $nilaiHuruf }}</td>
                        <td>{{ $nilaiAngka }}</td>
                        <td>{{ $totalNilai }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->matkul->kode_mata_kuliah }}</td>
                        <td style="text-align: left;">{{ $item->matkul->nama_mata_kuliah }}</td>
                        <td>{{ $sks }}</td>
                        <td>{{ $nilaiHuruf }}</td>
                        <td>{{ $nilaiAngka }}</td>
                        <td>{{ $totalNilai }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right"><strong>Jumlah SKS</strong></td>
                <td><strong>{{ $jumlahSKS }}</strong></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="1"><strong>{{ $jumlahNilai }}</strong></td>
            </tr>
            <tr>
                @php
                    function terbilang($number)
                    {
                        $numberMap = [
                            0 => 'NOL',
                            1 => 'SATU',
                            2 => 'DUA',
                            3 => 'TIGA',
                            4 => 'EMPAT',
                            5 => 'LIMA',
                            6 => 'ENAM',
                            7 => 'TUJUH',
                            8 => 'DELAPAN',
                            9 => 'SEMBILAN',
                        ];

                        $array = str_split(str_replace('.', '', number_format($number, 2, '.', '')));

                        $terbilang =
                            $numberMap[$array[0]] . ' KOMA ' . $numberMap[$array[1]] . ' ' . $numberMap[$array[2]];

                        return '(' . $terbilang . ')';
                    }

                    $ips = number_format(round($jumlahNilai / $jumlahSKS, 2), 2, '.', '');
                    date_default_timezone_set('Asia/Bangkok'); // Set timezone to GMT+7

                    $id_semester = $x->id_semester;
                    $NIM = $mahasiswa->NIM;

                    $presensi = App\Models\Mahasiswa::select('nim')
                        ->where('nim', $NIM)
                        ->with([
                            'presensi' => function ($query) use ($id_semester) {
                                $query
                                    ->select('nim', 'keterangan', 'created_at')
                                    ->whereHas('token', function ($tokenQuery) use ($id_semester) {
                                        $tokenQuery->where('id_semester', intval($id_semester));
                                    });
                            },
                        ])
                        ->withCount([
                            'presensi as hadir_count' => function ($query) use ($id_semester) {
                                $query
                                    ->where('keterangan', 'Hadir')
                                    ->whereHas('token', function ($tokenQuery) use ($id_semester) {
                                        $tokenQuery->where('id_semester', intval($id_semester));
                                    });
                            },
                            'presensi as alpa_count' => function ($query) use ($id_semester) {
                                $query
                                    ->where('keterangan', 'Alpha')
                                    ->whereHas('token', function ($tokenQuery) use ($id_semester) {
                                        $tokenQuery->where('id_semester', intval($id_semester));
                                    });
                            },
                            'presensi as ijin_count' => function ($query) use ($id_semester) {
                                $query
                                    ->where('keterangan', 'Ijin')
                                    ->whereHas('token', function ($tokenQuery) use ($id_semester) {
                                        $tokenQuery->where('id_semester', intval($id_semester));
                                    });
                            },
                            'presensi as sakit_count' => function ($query) use ($id_semester) {
                                $query
                                    ->where('keterangan', 'Sakit')
                                    ->whereHas('token', function ($tokenQuery) use ($id_semester) {
                                        $tokenQuery->where('id_semester', intval($id_semester));
                                    });
                            },
                        ])
                        ->first();
                @endphp
                <td colspan="3" style="text-align: right"><strong>Indeks Prestasi Semester
                        {{ $mahasiswa->getSemester($x->id_semester) }}</strong></td>
                <td><strong>{{ number_format(round($jumlahNilai / $jumlahSKS, 2), 2, '.', '') }}</strong></td>
                <td colspan="3"><strong>{{ terbilang(round($jumlahNilai / $jumlahSKS, 2)) }}</strong></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right"><strong>Indeks Prestasi Kumulatif</strong></td>
                <td><strong>{{ $IPK }}</strong></td>
                <td colspan="3"><strong>{{ terbilang($IPK) }}</strong></td>
            </tr>
            <tr>
                <td colspan="3" rowspan="3" style="text-align: right;"><strong>Ketidak Hadiran</strong></td>
                <td style="text-align: left; border-right: none;"><strong>Izin<strong></td>
                <td colspan="3" style="text-align: left; border-left: none;"><strong>=
                        {{ ($presensi->ijin_count ?? 0) == 0 ? '0' : $presensi->ijin_count }} Jam<strong></td>
            </tr>
            <tr>
                <td style="text-align: left; border-right: none;"><strong>Sakit<strong></td>
                <td colspan="3" style="text-align: left; border-left: none;"><strong>=
                        {{ ($presensi->sakit_count ?? 0) == 0 ? '0' : $presensi->sakit_count }} Jam<strong></td>
            </tr>
            <tr>
                <td style="text-align: left; border-right: none;"><strong>Alpa<strong></td>
                <td colspan="3" style="text-align: left; border-left: none;"><strong>=
                        {{ ($presensi->alpa_count ?? 0) == 0 ? '0' : $presensi->alpa_count }} Jam<strong></td>
            </tr>

        </tbody>
    </table>

    <div class="signature" style="text-align: right;">
        <div style="display: inline-block; text-align: left;">
            <p>Kebumen, {{ date('d F Y') }}<br>
                Politeknik Piksi Ganesha Indonesia</p>

            @php
                $ttd = App\Models\Ttd::where('jabatan', 'Pudir I Bidang Akademik')->first();
            @endphp

            <img src="{{ public_path('storage/' . $ttd->ttd) }}" style="width: 100px; height: auto;">

            <p><strong>{{ $ttd->nama }}</strong><br></p>
            <p><strong>{{ $ttd->jabatan }}</strong><br></p>
        </div>
    </div>

    <p style="background-color: black; size: 20px;"></p>

    <p>Tanggal Print: {{ date('Y-m-d H:i:s') }}</p>
</body>

</html>
