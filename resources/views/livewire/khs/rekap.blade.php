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
    <div style="width: 100%; text-align: center;">
        <h2>TRANSRIP NILAI AKADEMIK</h2>
    </div>
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
            <td style="width: 50%; vertical-align: top;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding: 3px 10px;">PROGRAM STUDI</td>
                        <td style="padding: 3px 10px;">:</td>
                        <td style="padding: 3px 10px;">{{ $mahasiswa->prodi->nama_prodi }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 10px;">TAHUN MASUK</td>
                        <td style="padding: 3px 10px;">:</td>
                        <td style="padding: 3px 10px;">{{ substr($mahasiswa->semester->nama_semester, 0, 4) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @php
        $total = count($khs);
        $half = ceil($total / 2);
        $khs1 = $khs->slice(0, $half);
        $khs2 = $khs->slice($half);
        $jumlahSKS = 0;
        $jumlahNilai = 0;
    @endphp

    @php
        $rowCount1 = count($khs1);
        $rowCount2 = count($khs2);
        $maxRows = max($rowCount1, $rowCount2);
    @endphp

    <table style="width: 100%; table-layout: fixed; font-size: 11px;">
        <tr>
            <!-- Left Table -->
            <td style="width: 40%; vertical-align: top; margint-right:2px;">
                <table class="table" style="width: 100%;">
                    <thead>
                        <tr>

                            <th style="width: 8%">Kode MK</th>
                            <th style="width: 40%">Mata Kuliah</th>
                            <th style="width: 8%">SKS</th>
                            <th style="width: 12%">Nilai Mutu</th>
                            <th style="width: 12%">Nilai Angka</th>
                            <th style="width: 12%">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($khs1 as $index => $item)
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
                                    $jumlahNilai += $nilaiAngka * $sks;
                                }
                            @endphp
                            <tr>
                                <td style="height: 25px">{{ $item->matkul->kode_mata_kuliah }}</td>
                                <td style="height: 25px">{{ $item->matkul->nama_mata_kuliah }}</td>
                                <td style="height: 25px">{{ $sks }}</td>
                                <td style="height: 25px">{{ $nilaiHuruf }}</td>
                                <td style="height: 25px">{{ $nilaiAngka }}</td>
                                <td style="height: 25px">{{ $totalNilai }}</td>
                            </tr>
                        @endforeach
                        @for ($i = $rowCount1; $i < $maxRows; $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </td>

            <!-- Right Table -->
            <td style="width: 40%; vertical-align: top; margint-left: 2px;">
                <table class="table" style="width: 100%;">
                    <thead>
                        <tr>

                            <th style="width: 8%">Kode MK</th>
                            <th style="width: 40%">Mata Kuliah</th>
                            <th style="width: 8%">SKS</th>
                            <th style="width: 12%">Nilai Mutu</th>
                            <th style="width: 12%">Nilai Angka</th>
                            <th style="width: 12%">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($khs2 as $index => $item)
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
                                    $jumlahNilai += $nilaiAngka * $sks;
                                }
                            @endphp
                            <tr>

                                <td style="height: 25px">{{ $item->matkul->kode_mata_kuliah }}</td>
                                <td style="height: 25px">{{ $item->matkul->nama_mata_kuliah }}</td>
                                <td style="height: 25px">{{ $sks }}</td>
                                <td style="height: 25px">{{ $nilaiHuruf }}</td>
                                <td style="height: 25px">{{ $nilaiAngka }}</td>
                                <td style="height: 25px">{{ $totalNilai }}</td>
                            </tr>
                        @endforeach
                        <!-- Total row -->
                        <tr>
                            <td colspan="2" style="text-align: right"><strong>Jumlah SKS</strong></td>
                            <td><strong>{{ $jumlahSKS }}</strong></td>
                            <td colspan="2" style="text-align: right;"><strong>Total Nilai</strong></td>
                            <td><strong>{{ $jumlahNilai }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
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
