<!DOCTYPE html>
<html>

<head>
    <title>Tagihan</title>
</head>

<body>
    <h1>Tagihan Anda</h1>
    <p>Halo, {{ $nama }}!</p>
    <p>Berikut adalah rincian tagihan Anda:</p>
    <ul>
        <li>Jumlah Tagihan: {{ $jumlah_tagihan }}</li>
        <li>Tanggal Jatuh Tempo: {{ $tanggal_jatuh_tempo }}</li>
    </ul>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>
