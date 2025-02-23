<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Peringatan</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { padding: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: gray; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Surat Peringatan Akademik</h2>

        <p>Yth. {{ $nama }},</p>

        <p>Kami informasikan bahwa Anda telah tercatat memiliki ketidakhadiran sebanyak {{ $alpha_count }} kali dalam kegiatan perkuliahan. Hal ini bertentangan dengan kebijakan Politeknik Piksi Ganesha Indonesia.</p>

        <p>Surat peringatan resmi telah kami lampirkan dalam bentuk PDF pada email ini. Silakan baca dan perhatikan informasi yang tertera dalam surat tersebut.</p>

        <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi bagian akademik.</p>

        <p>Terima kasih atas perhatian Anda.</p>

        <div class="footer">
            <p>Hormat Kami,<br>
            Wakil Direktur I Bidang Akademik<br>
            Politeknik Piksi Ganesha Indonesia</p>
        </div>
    </div>
</body>
</html>
