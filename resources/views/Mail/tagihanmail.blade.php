<!DOCTYPE html>
<html>

<head>
    <title>Reminder Pembayaran BPP</title>
</head>

<body>
    <h1>Tagihan Anda</h1>
    <p>Halo, {{ $tagihan->mahasiswa->nama }}!</p>
    <p>Berikut adalah rincian tagihan Anda:</p>
    <ul>
        <li>Jumlah Tagihan : {{ $tagihan->total_tagihan }}</li>
        <li>Tanggal Jatuh Tempo : {{ $tagihan->created_at->addDays(3) }}</li>
    </ul>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>
