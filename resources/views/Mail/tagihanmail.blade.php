<!DOCTYPE html>
<html>

<head>
    <title>Informasi Tagihan</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff;">
        <!-- Header -->
        <tr>
            <td align="center" style="padding: 20px;">
                <img style="width: 80px;" src="{{ public_path('img/Politeknik_Piksi_Ganesha_Bandung.png') }}">
                <span
                    style="font-weight: bold; font-size: 18px; color: #7b4f79; text-align: center; display: block; margin-top: 10px;">
                    POLITEKNIK PIKSI GANESHA INDONESIA
                </span>
        </tr>
        <tr>
            <td align="center"
                style="background-color: #A55BA5; padding: 10px; color: #ffffff; font-size: 18px; font-weight: bold;">
                INFORMASI TAGIHAN UANG KULIAH
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 20px; color: #333333; font-size: 14px;">
                <p>Kepada Yth. <strong>{{ $tagihan->mahasiswa->nama }}</strong>,</p>
                <p>Berikut informasi tagihan anda,
                </p>
                <br>
                <!-- Box Tagihan -->
                <div style="background-color: #f3e5f5; padding: 15px; text-align: left;">
                    <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 14px;">
                        <tr>
                            <td style="font-weight: bold;">Tagihan</td>
                            <td>: <strong>{{ $tagihan->jenis_tagihan }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">
                                <P>Periode Tagihan</P>
                            </td>
                            <td>: <strong>{{ $tagihan->Bulan }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">
                                <P>Atas Nama</P>
                            </td>
                            <td>: <strong>{{ $tagihan->mahasiswa->nama }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Semester</td>
                            <td>: <strong>{{ $tagihan->semester->nama_semester }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Nominal Tagihan</td>
                            <td>: <strong>Rp.
                                    {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Status Pembayaran</td>
                            <td>: <strong>{{ $tagihan->status_tagihan }}</strong></td>
                        </tr>
                    </table>
                </div>
                <br>
                <!-- Tata Cara Pembayaran -->
                <h3 style="color: #7b4f79;">Tata Cara Pembayaran Uang Kuliah PPGI</h3>
                <ol style="padding-left: 20px;">
                    <li style="margin: 0 0 10px 0">Silahkan Login Siakad PPGI</li>
                    <li style="margin: 0 0 10px 0">Masuk Pada Menu Keuangan, Pembayaran</li>
                    <li style="margin: 0 0 10px 0">Bayar tagihan sesuai nominal yang tertera</li>
                    <li style="margin: 0 0 10px 0">Pastikan status pembayaran berhasil di siakad</li>
                    <li style="margin: 0 0 10px 0">Unduh bukti pembayaran</li>
                    <li style="margin: 0 0 10px 0">Atau bisa melakukan pembayaran melalui, </li>

                </ol>
                <a href="http://127.0.0.1:8000/mahasiswa/keuangan" target="_blank"
                    style="background-color: #A55BA5; justify-items: center; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-top: 10px; cursor: pointer;">
                    Bayar Disini
                </a>
                <p>Jika ada pertanyaan lebih lanjut, silakan hubungi kami di 08515600000 atau email ke
                    <a href="mailto:ppgi.ac.id">ppgi.ac.id</a>.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="padding: 10px; background-color: #f4f4f4; font-size: 12px; color: #777777;">
                <p>&copy; 2024 Politeknik Piksi Ganesha Indonesia. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>

</html>
