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
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #7b4f79;
            color: white;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: justify;
            /* Membuat teks rata kanan-kiri */
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .fw-bold {
            font-weight: bold;
        }

        .fs-5 {
            font-size: 18px;
        }

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
        }

        h2 {
            text-align: center;
            color: #7b4f79;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>e-Monev Dosen PPGI</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 15%;">Semester</th>
                        <th style="width: 15%;">Prodi</th>
                        <th style="width: 10%;">NIDN</th>
                        <th style="width: 35%;">Nama Dosen</th>
                        <th style="width: 20%;">Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jawaban as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['nama_semester'] }}</td>
                            <td>{{ $item['nama_prodi'] }}</td>
                            <td>{{ $item['nidn'] }}</td>
                            <td>{{ $item['nama_dosen'] }}</td>
                            <td
                                class="fw-bold fs-5 
                                {{ $item['total_nilai'] > 200 ? 'text-success' : 'text-danger' }}">
                                {{ $item['total_nilai'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
