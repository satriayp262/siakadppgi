<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Peringatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            margin: auto;
            padding: 10px;
        }

        h3 {
            text-align: center;
            text-decoration: underline;
        }

        .content {
            margin-top: 20px;
        }

        .signature {
            margin-top: 50px;
            width: 40%;
            /* Lebar signature */
            float: right;
            /* Letakkan di kanan */
            text-align: left;
            /* Teks tetap rata kiri */
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('img/kop_surat.jpg') }}" alt="Kop Surat">
        </div>

        <h3>Surat Peringatan</h3>
        <p><strong>No. Surat:</strong> {{ $no_surat }}
        <br><strong>Perihal:</strong> Surat Peringatan Perilaku Mengganggu di Kelas</p>

        <p>Kepada Yth.<br>
            {{ $nama }}<br>
            Di Tempat</p>

        <div class="content">
            <p>Dengan hormat,</p>

            <p>Surat ini kami sampaikan untuk memperingatkan Anda mengenai ketidakhadiran dalam mengikuti perkuliahan.
                Kami mencatat bahwa Anda telah tidak mengikuti perkuliahan sebanyak {{ $alpha_count }} kali, yang
                bertentangan dengan kebijakan Politeknik Piksi Ganesha Indonesia.</p>

            <p>Kami berharap Anda dapat mematuhi semua aturan perguruan tinggi ke depannya dan mengambil tindakan yang
                tepat agar Anda dapat mengikuti kuliah. Ini penting agar Anda tidak tertinggal dalam pembelajaran di
                perkuliahan.</p>
            <div class="signature">
                <p class="font-medium">Hormat kami,<br>
                    Wakil Direktur I Bidang Akademik</p>

                <p class="font-bold">Asni Tafrikhatin, M.Pd</p>
            </div>
        </div>

    </div>
</body>

</html>
