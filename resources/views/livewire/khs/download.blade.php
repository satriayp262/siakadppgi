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
    <table style="width: 100%; border: none; margin: 0; border-spacing: 0;">
        <tr style="vertical-align: top;">
            <!-- Logo Kiri -->
            <td style="width: 5%; text-align: left;">
                <img style="width: 64px;" src="img/Politeknik_Piksi_Ganesha_Bandung.png">
            </td>

            <!-- Informasi Kontak -->
            <td style="width: 40%; text-align: center;">
                <p
                    style="color: darkviolet; font-size: 14px; margin: 5px 0; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">
                    <strong>SK. MENDIKBUDRISTEK RI NO. 122/D/OT/2021</strong>
                </p>
                <p
                    style="color: darkviolet; font-size: 20px; margin: 5px 0; font-family: Arial, Helvetica, sans-serif; letter-spacing: 2px; font-weight: bold;">
                    <strong>POLITEKNIK PIKSI GANESHA INDONESIA</strong>
                </p>
                <p style="color: darkviolet; margin: 5px 0; font-size: 10px;">
                    Jln. Letnan Jendral Suprapto No. 73, Kranggan, Bumirejo, Kec. Kebumen, Kab. Kebumen, Jawa Tengah,
                    Kebumen, Jawa Tengah, Indonesia 54316
                </p>
                <p style="color: darkviolet; margin: 5px 0; font-size: 10px;">
                    Telepon/Faximile 0287-383 800, 381 116 0287-381 149 | email : info@politeknik-kebumen.ac.id
                </p>
            </td>

            <!-- Logo Kanan -->
            <td style="width: 5%; text-align: right;">
                <img style="width: 64px; opacity: 50%;" src="img/tut2.png">
            </td>
        </tr>
        <!-- Garis Horizontal -->
        <tr>
            <td colspan="3" style="padding: 0;">
                <hr
                    style="border-top: 3px solid darkviolet; height: 2px; border-bottom: 1px solid darkviolet; margin: 0;">
            </td>
        </tr>
    </table>
    <table
        style=" border-collapse: collapse; font-size: 12px; margin-bottom: 10px; margin-top: 10px;
            margin-left: 15%;">
        <tr>
            <td style="padding: 3px 10px;">Nama</td>
            <td style="padding: 3px 10px;">:</td>
            <td style="padding: 3px 10px;">{{ $mahasiswa->nama }}</td>
        </tr>
        <tr>
            <td style="padding: 3px 10px;">NIM</td>
            <td style="padding: 3px 10px;">:</td>
            <td style="padding: 3px 10px;">{{ $mahasiswa->NIM }}</td>
        </tr>
        <tr>
            <td style="padding: 3px 10px;">Program Studi</td>
            <td style="padding: 3px 10px;">:</td>
            <td style="padding: 3px 10px;">{{ $mahasiswa->prodi->nama_prodi }}</td>
        </tr>
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
        <tr>
            <td style="padding: 3px 10px;">Semester</td>
            <td style="padding: 3px 10px;">:</td>
            <td style="padding: 3px 10px;">{{ $semesterText }}</td>
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
                @if ($item->bobot < 59)
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
        </tbody>
    </table>

    <div class="signature">
        <p>Kebumen, {{ date('d F Y') }}<br>
            Politeknik Piksi Ganesha Indonesia</p>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <p><strong>................................................</strong><br></p>
        <p style="background-color: black; size: 20px;"></p>
    </div>

    <p>Tanggal Print: {{ date('Y-m-d H:i:s') }}</p>
</body>

</html>
