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

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
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
            padding: 8px;
        }

        .info {
            width: 100%;
            margin-bottom: 10px;
        }

        .info td {
            padding: 4px;
            font-size: 12px;
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
    <div class="header">
        <h2>Politeknik Piksi Ganesha Indonesia</h2>
        <h3>Kartu Hasil Studi (KHS)</h3>
    </div>

    <table class="info">
        <tr>
            <td>Nama</td>
            <td>: {{ $mahasiswa->nama }}</td>
            <td>Semester</td>
            <td>: {{ $x->nama_semester }}</td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>: {{ $mahasiswa->NIM }}</td>
            <td>Program Studi</td>
            <td>: {{ $mahasiswa->prodi->nama_prodi }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai Mutu</th>
                <th>Nilai Angka</th>
                <th>Total Nilai</th>
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
                    $jumlahSKS += $sks;
                    $jumlahNilai += $totalNilai;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->matkul->kode_mata_kuliah }}</td>
                    <td style="text-align: left;">{{ $item->matkul->nama_mata_kuliah }}</td>
                    <td>{{ $sks }}</td>
                    <td>{{ $nilaiHuruf }}</td>
                    <td>{{ $nilaiAngka }}</td>
                    <td>{{ $totalNilai }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Jumlah SKS</strong></td>
                <td><strong>{{ $jumlahSKS }}</strong></td>
                <td colspan="2"><strong>Indeks Prestasi Semester (IPS)</strong></td>
                <td><strong>{{ round($jumlahNilai / $jumlahSKS, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Kebumen, {{ now()->format('d F Y') }}<br>
            Politeknik Piksi Ganesha Indonesia</p>
        <br><br>
        <p><strong>........................</strong><br></p>
        <p style="background-color: black; size: 20px;"></p>
    </div>

    <p>Tanggal Print: {{ now() }} <br> Operator: {{ auth()->user()->name }}</p>
</body>

</html>
