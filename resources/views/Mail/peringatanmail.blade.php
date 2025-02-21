<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Peringatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 shadow-lg rounded-lg">
        <!-- Kop Surat -->
        <div class="flex justify-center mb-6">
            <img src="cid:kop_surat.jpg" alt="Kop Surat" style="width:100%; height:auto;">
        </div>

        <!-- Isi Surat -->
        <p>Kepada Yth.
            <br class="font-semibold">{{ $nama }}</br> <!-- Nama Mahasiswa Dinamis -->
            <br>Di Tempat</br>
        </p>

        <p class="mt-6">Dengan hormat,</p>

        <p class="mt-4 text-justify">
            Surat ini kami sampaikan untuk memperingatkan Anda mengenai ketidakhadiran dalam mengikuti perkuliahan.
            Kami mencatat bahwa Anda telah tidak mengikuti perkuliahan sebanyak 2 kali, yang bertentangan
            dengan kebijakan Politeknik Piksi Ganesha Indonesia.
        </p>

        <p class="mt-4 text-justify">
            Kami berharap Anda dapat mematuhi semua aturan perguruan tinggi ke depannya dan mengambil tindakan yang
            tepat
            agar Anda dapat mengikuti kuliah dengan baik. Ini penting agar Anda tidak tertinggal dalam proses
            pembelajaran.
        </p>

        <div class="text-right">
            <p class="mt-6">Hormat kami,
                <br class="font-semibold">Wakil Direktur I Bidang Akademik</br>
            </p>
            <p class="mt-4 font-bold">Asni Tafrikhatin, M.Pd</p>
        </div>
    </div>
</body>

</html>
