<!DOCTYPE html>
<html>

<head>
    <title>Informasi Tagihan</title>
</head>

@php
    $tanggal = date('d', strtotime($tagihan->created_at . ' +5 days'));
    $bulan = substr($tagihan->created_at, 5, 2);
    $bulantag = substr($tagihan->Bulan, 5, 2);
    $namaBulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ][$bulan];
    $namaBulan2 = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ][$bulantag];
    $tahun = substr($tagihan->created_at, 0, 4);
@endphp

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff;">
        <!-- Header -->
        <tr>
            <td align="center" style="padding: 20px;">
                <img style="width: 80px;" src="img/Politeknik_Piksi_Ganesha_Bandung.png">
                <span
                    style="font-weight: bold; font-size: 18px; color: #7b4f79; text-align: center; display: block; margin-top: 10px;">
                    POLITEKNIK PIKSI GANESHA INDONESIA
                </span>
        </tr>
        <tr>
            <td align="center"
                style="background-color: #A55BA5; padding: 10px; color: #ffffff; font-size: 18px; font-weight: bold;">
                INFORMASI TAGIHAN
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 20px; color: #333333; font-size: 14px;">
                <p>Kepada Yth. <strong>{{ $tagihan->mahasiswa->nama }}</strong>,</p>
                <p>Berikut informasi tagihan BPP anda bulan <span
                        style="font-weight: bold;">{{ $namaBulan2 . '' . substr($tagihan->Bulan, 0, 4) }}</span>
                </p>
                <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 14px;">
                    <tr>
                        <td style="width: 40%; font-weight: bold;">Semester</td>
                        <td>: <strong>{{ $tagihan->mahasiswa->Semester->nama_semester }}</strong></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Email</td>
                        <td>: <a href="mailto:{{ $tagihan->mahasiswa->email }}">{{ $tagihan->mahasiswa->email }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">No. Telepon</td>
                        <td>: <strong>{{ $tagihan->mahasiswa->no_hp }}</strong></td>
                    </tr>
                </table>
                <br>
                <!-- Box Tagihan -->
                <div style="background-color: #f3e5f5; padding: 15px; text-align: center;">
                    <p style="margin: 0; font-weight: bold; font-size: 14px;">Mohon melakukan pembayaran
                        paling lambat tanggal</p>
                    <p style="margin: 0; font-weight: bold;">
                        {{ $tanggal . ' ' . $namaBulan . ' ' . $tahun }}, 23:59:59</p>
                    <br>
                    <p style="margin: 0;">atas nama</p>
                    <p style="font-size: 18px; font-weight: bold;">{{ $tagihan->mahasiswa->nama }}</p>
                    <p style="margin: 0;">Nominal yang harus dibayar</p>
                    <p style="font-size: 22px; font-weight: bold;">Rp.
                        {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</p>
                </div>
                <br>
                <!-- Tata Cara Pembayaran -->
                <h3 style="color: #7b4f79;">Tata Cara Pembayaran</h3>
                <ol style="padding-left: 20px;">
                    <li style="margin: 0 0 10px 0">Datang ke bagian administrasi</li>
                    <li style="margin: 0 0 10px 0">Serahkan KTM kepada staff</li>
                    <li style="margin: 0 0 10px 0">Bayar tagihan sesuai nominal yang tertera</li>
                    <li style="margin: 0 0 10px 0">Pastikan status pembayaran berhasil di siakad</li>
                    <li style="margin: 0 0 10px 0">Unduh bukti pembayaran</li>
                </ol>
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
