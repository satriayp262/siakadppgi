<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Monev Dosen PPGI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            color: #7b4f79;
            margin-bottom: 20px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #999;
            border-radius: 4px;
            overflow: hidden;
        }

        th:first-child {
            border-top-left-radius: 4px;
        }

        th:last-child {
            border-top-right-radius: 4px;
        }

        tbody tr:last-child td:first-child {
            border-bottom-left-radius: 4px;
        }

        tbody tr:last-child td:last-child {
            border-bottom-right-radius: 4px;
        }

        thead {
            background-color: #7b4f79;
            color: white;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 8px;
            word-wrap: break-word;
            text-align: center;
            vertical-align: middle;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <img style="width: 100%; height: min-content; margin-top: -5%;" src="img/kop_surat.jpg">
    @foreach ($jawaban as $index => $item)
        <h2 style="text-align: left; color: #7b4f79; margin-bottom: 1%;">Laporan e-Monev Dosen PPGI
            Periode{{ ' ' . $item['nama_periode'] }}
        </h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 6%;">Semester</th>
                    <th style="width: 5%;">Prodi</th>
                    <th style="width: 8%;">NIDN</th>
                    <th style="width: 8%;">Nama Dosen</th>
                    @foreach ($pertanyaan as $pertanyaanItem)
                        <th style="width: {{ 45 / count($pertanyaan) }}%;">{{ $pertanyaanItem->nama_pertanyaan }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama_periode'] }}</td>
                    <td>{{ $item['nama_prodi'] }}</td>
                    <td>{{ $item['nidn'] }}</td>
                    <td>{{ $item['nama_dosen'] }}</td>
                    @for ($i = 1; $i <= count($pertanyaan); $i++)
                        <td>{{ round($item['pertanyaan_' . $i]) }}</td>
                    @endfor
                </tr>
    @endforeach
    </tbody>
    </table>
</body>

</html>
