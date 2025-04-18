<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>

<body style="margin-top:-3%; margin-left: -1%;">
    <table style="width: 100%; border: none; margin: 0; border-spacing: 0;">
        <tr style="vertical-align: top;">
            <!-- Logo Kiri -->
            <td style="width: 5%; text-align: left;">
                <img style="width: 64px;" src="img/Politeknik_Piksi_Ganesha_Bandung.png">
            </td>

            <!-- Informasi Kontak -->
            <td style="width: 40%; text-align: center;">
                <p
                    style="color: darkviolet; font-size: 14px; margin: 5px 0; font-family: Arial, Helvetica, sans-serif; letter-spacing: 2px; font-weight: bold;">
                    <strong>POLITEKNIK PIKSI GANESHA INDONESIA</strong>
                </p>
                <p style="color: darkviolet; margin: 5px 0; font-size: 9px;">
                    Jln. Letnan Jendral Suprapto No. 73, Kranggan, Bumirejo, Kec. Kebumen, Kab. Kebumen, Jawa Tengah,
                    Kebumen, Jawa Tengah, Indonesia 54311
                </p>
                <p style="color: darkviolet; margin: 5px 0; font-size: 9px;">
                    Telepon/Faximile (0287) 381116, 383800 | email : info@politeknik-kebumen.ac.id
                </p>
            </td>

            <!-- Logo Kanan -->
            <td style="width: 5%; text-align: right;">
                <img style="width: 64px; opacity: 50%;" src="img/tut2.png">
            </td>

            <!-- Judul -->
            <td style="width: 40%; text-align: center;">
                <h3
                    style="font-size: x-large; color: darkviolet; font-family: sans-serif; font-weight: 900; margin-top: -0%;">
                    BUKTI
                    PEMBAYARAN</h3>
            </td>
        </tr>
        <!-- Garis Horizontal -->
        <tr>
            <td colspan="3" style="padding: 0;">
                <hr
                    style="border-top: 3px solid darkviolet; height: 2px; border-bottom: 1px solid darkviolet; margin: 0;">
            </td>
            <td style="padding: 2;">
                <hr
                    style="border-top: 3px solid darkviolet; height: 2px; border-bottom: 1px solid darkviolet; margin-top: -7%;">
            </td>
        </tr>
    </table>




    {{-- <h3 style="font-family: helvetica; margin-top: 30px;color:darkviolet;margin-top:2%">
        Bukti Pembayaran
    </h3> --}}

    <div style="justify-content: flex-start; margin-top: 1%;">
        <!-- Tabel Pertama -->
        <table style="float: left;">
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    NIM / Nama</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    {{ $NIM }} /
                    {{ $nama }}</td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    Semester</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    {{ $semester }}</td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    Guna Pembayaran</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    {{ $pembayaran }}
                </td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    Total Tagihan</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    {{ $total_tagihan }}</td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    Terbilang</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    {{ $x }} RUPIAH</td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    Sisa yang belum dibayar</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif;">
                    {{ $kurang }}</td>
            </tr>
        </table>

        <!-- Tabel Kedua -->
        <table style="float: left; margin-right: auto; margin-left: 18%; margin-top: -3%;">
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    No. Kwitansi</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    {{ $kwitansi }}</td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    Jam</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    {{ $jam }}</td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    Status Tagihan</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    {{ $status }}</td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    Kelas</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    :</td>
                <td
                    style="font-size: 12px; margin-bottom: 1%; letter-spacing: 3px; font-family: Arial, Helvetica, sans-serif\;">
                    {{ $kelas }}</td>
            </tr>

        </table>
    </div>

    <div style="margin-top: 4%; float: right; margin-right: 15%;">
        <div class="col-md-4">
            <p style=" text-align:center; margin-bottom:0%; font-size: 14px;"><strong>Kebumen,
                    {{ $tanggal }}</strong></p>
            <p style=" text-align:center;position: relative; left: -50px; margin-top:0%; font-size: 14px;">
                <strong>Penerima,</strong>
            </p>
            <div style="position: relative; text-align: center; margin-bottom: 10%;">
                <img src="{{ $ttd }}" alt="Tanda Tangan"
                    style="width: auto; height:80px; position: absolute; top: 0; left: 50%; transform: translateX(-50%);">
                <img src="img/Politeknik_Piksi_Ganesha_Bandung.png" alt=""
                    style="opacity:50%; width:auto; height:80px; position: relative; left: -60px; transform: rotate(-5deg);">
            </div>
            <div style="margin-top:0%;text-align:center; font-size: 14px; margin-bottom: -7%;">
                <strong>{{ $staff }}</strong><br />
                NIP. {{ $nip }}
            </div>
        </div>
    </div>

    <br>
    <br>

    <h4 style="font-family: helvetica; margin-top: 10%; color:darkviolet; font-size: 14px;">
        Catatan
    </h4>
    <ul style="margin-top: -1%">
        <li style="padding:1px; font-size: 12px;">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. repudiandae.
        </li>
        <li style="padding:1px; font-size: 12px;">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. repudiandae
            alias sit, eaque est ut.
        </li>
    </ul>
</body>

</html>
