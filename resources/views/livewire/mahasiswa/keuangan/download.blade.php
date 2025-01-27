<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>

<body>
    <table style="width: 100%; border: none; margin:0%;">
        <tr>
            <!-- Logo Kiri -->
            <td style="width: 10%; text-align: left;">
                <img style="width: 80px;" src="img/Politeknik_Piksi_Ganesha_Bandung.png">
            </td>

            <!-- Informasi Kontak -->
            <td style="width: 80%; text-align: center;">
                <p style="color: darkviolet; font-size:24px; margin: 5px 0; font-family:'Segoe UI'">
                    <strong>POLITEKNIK
                        PIKSI
                        GANESHA
                        INDONESIA</strong>
                </p>
                <p style="color: darkviolet; margin: 5px 0; font-size:13px;">
                    Jln. Letnan Jendral Suprapto No. 73, Kranggan, Bumirejo, Kec. Kebumen, Kab. Kebumen, Jawa
                    Tengah,
                    Kebumen, Jawa Tengah, Indonesia 54311,
                </p>
                <p style="color: darkviolet; margin: 5px 0; font-size:12px">
                    Telepon/Faximile (0287) 381116, 383800 | email : info@politeknik-kebumen.ac.id
                </p>
            </td>


            <!-- Logo Kanan -->
            <td style="width: 10%; text-align: right;">
                <img style="width: 80px; color:darkviolet; opacity:50%" src="img/tut2.png">
            </td>

        </tr>
    </table>
    <hr style="border-top: 3px solid darkviolet; height: 2px; border-bottom: 1px solid darkviolet;">

    {{-- <h3 style="font-family: helvetica; margin-top: 30px;color:darkviolet;margin-top:2%">
        Bukti Pembayaran
    </h3> --}}

    <div style="justify-content: flex-start; margin-left: 20px; margin-top: 20px;">
        <!-- Tabel Pertama -->
        <table style="float: left;">
            <tr>
                <td style="padding: 5px;">NIM / Nama</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">{{ $NIM }} / {{ $nama }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Semester</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">{{ $semester }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Guna Pembayaran</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">SPP Bulan {{ $Bulan }} Tahun {{ $tahun }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Total Tagihan</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">{{ $total_tagihan }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Terbilang</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">{{ $x }} RUPIAH</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Sisa yang belum dibayar</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">{{ $kurang }}</td>
            </tr>
        </table>

        <!-- Tabel Kedua -->
        <table style="float: left; margin-right: auto; margin-left: 10%;">
            <tr>
                <td style="padding: 5px;">No. Kwitansi</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">x</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Jam</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">y</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Metode Pembayaran</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">z</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Status</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">a</td>
            </tr>
            <br>
            <br>
            <br>

        </table>
    </div>

    <div style="margin-top: 15%; float: right; margin-right: 15%;">
        <div class="col-md-4">
            <p style=" text-align:center; margin-bottom:0%"><strong>Kebumen, {{ $tanggal }}</strong></p>
            <p style=" text-align:center;position: relative; left: -60px; margin-top:0%"><strong>Penerima,</strong></p>
            <div style="position: relative; text-align: center;margin-bottom:30px">
                <img src="{{ $ttd }}" alt="Tanda Tangan"
                    style="width: auto; height:100px; position: absolute; top: 0; left: 50%; transform: translateX(-50%);">
                <img src="img/Politeknik_Piksi_Ganesha_Bandung.png" alt=""
                    style="opacity:50%; width:auto; height:90px; position: relative; left: -60px; transform: rotate(-10deg);">
            </div>
            <div style="margin-top:200px;text-align:center;margin-top:0%"><strong>{{ $staff }}</strong><br />
                Pembina Tk. I<br />
                NIP. {{ $nip }}
            </div>
        </div>
    </div>

    <br>
    <br>

    <h4 style="font-family: helvetica; margin-top: 20%; color:darkviolet;">
        Catatan
    </h4>
    <ul style="">
        <li style="padding:1px">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. repudiandae.
        </li>
        <li style="padding:1px">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. repudiandae
            alias sit, eaque est ut.
        </li>
    </ul>
</body>

</html>
