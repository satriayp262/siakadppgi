<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ 'kartu '. $z . ' Semester ' . $c . ' Tahun Ajaran ' . $y . "/" . $y + 1  }}
    </title>
</head>

<body style="margin-top:-3%; margin-left: -1%;">

    {{-- <table style="width: 100%; border: none; margin: 0; border-spacing: 0;">
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
        </tr>
        <!-- Garis Horizontal -->
        <tr>
            <td colspan="3" style="padding: 0;">
                <hr
                    style="border-top: 2px solid darkviolet; border-bottom: 1px solid darkviolet; border-left: none; border-right: none; height: 0; margin-top: 6px;">
            </td>
        </tr>
    </table> --}}

    <img src="{{ public_path('img/kop_surat.jpg') }}" alt="Kop Surat" style="width: 100%; margin-bottom: 10px;">

    <!-- Content -->
    <div>
        <span style="display: flex; text-align: center; font-size: 16px; font-weight: bold;">
            @if ($z == 'UTS')
                KARTU PESERTA UJIAN TENGAH SEMESTER (UTS)
            @elseif ($z == 'UAS')
                KARTU PESERTA UJIAN AKHIR SEMESTER (UAS)
            @endif
        </span>
    </div>

    <table style="width: 100%; margin-top: 0.5rem; font-size: 12px;">
    <tr>
        <!-- Kolom kiri -->
        <td style="width: 50%; vertical-align: top;">
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="width: 25%;">Semester</td>
                    <td style="width: 5%;">:</td>
                    <td>{{ $c }} {{ $y }}/{{ $y + 1 }}</td>
                </tr>
                <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td>{{ $mahasiswa->prodi->nama_prodi }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $mahasiswa->nama }}</td>
                </tr>
            </table>
        </td>

        <!-- Kolom kanan -->
        <td style="width: 50%; vertical-align: top;">
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="width: 10%;">NPM</td>
                    <td style="width: 5%;">:</td>
                    <td>{{ $mahasiswa->NIM }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $kelas->kelas->nama_kelas }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>


    <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 0.5rem;">
        <thead>
            <tr style="background-color: #d1d5db;">
                <th style="padding: 1px; border: 1px solid black; text-align: center;">Hari</th>
                <th style="padding: 1px; border: 1px solid black; text-align: center;">Sesi</th>
                <th style="padding: 1px; border: 1px solid black; text-align: center;">Mata Kuliah</th>
                <th style="padding: 1px; border: 1px solid black; text-align: center;">Dosen</th>
                <th style="padding: 1px; border: 1px solid black; text-align: center;">Ruangan</th>
                <th style="padding: 1px; border: 1px solid black; text-align: center;">Paraf</th>
                <th style="padding: 1px; border: 1px solid black; text-align: center;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedJadwals as $hari => $items)
                @foreach ($items as $index => $jadwal)
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ count($items) }}" style="padding: 1px; text-align: center; border: 1px solid black;">
                                <div>
                                    @switch($hari)
                                        @case('Monday') Senin @break
                                        @case('Tuesday') Selasa @break
                                        @case('Wednesday') Rabu @break
                                        @case('Thursday') Kamis @break
                                        @case('Friday') Jumat @break
                                        @default {{ $hari }}
                                    @endswitch
                                </div>
                                <div style="font-size: 12px; margin-top: 1px;">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </div>
                            </td>
                        @endif
                        <td style="padding: 1px; text-align: center; border: 1px solid black;">
                            {{ $jadwal->sesi }}
                        </td>
                        <td style="padding: 1px; text-align: center; border: 1px solid black;">
                            {{ $jadwal->matakuliah->nama_mata_kuliah }}
                        </td>
                        <td style="padding: 1px; text-align: center; border: 1px solid black;">
                            {{ $jadwal->dosen->nama_dosen }}
                        </td>
                        <td style="padding: 1px; text-align: center; border: 1px solid black;">
                            {{ $jadwal->id_ruangan == 'Online' ? 'Online' : $jadwal->ruangan->kode_ruangan }}
                        </td>
                        <td style="padding: 1px; border: 1px solid black;"></td>
                        <td style="padding: 1px; border: 1px solid black;"></td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div style="position: fixed; bottom: 0; width: 100%; font-size: 12px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <table style="width: 70%; border: 1px solid black; border-collapse: collapse;">
                    <tr>
                        <td colspan="2" style="padding-left: 5px;">
                            <span>Keterangan :</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%; vertical-align: top; padding-left: 5px;">
                            <div style="margin: 0;">Sesi 1 : 08.00 - 09.30</div>
                            <div style="margin: 0;">Sesi 2 : 09.30 - 11.00</div>
                            <div style="margin: 0;">Sesi 3 : 11.00 - 12.30</div>
                            <div style="margin: 0;">Sesi 4 : 12.30 - 14.00</div>
                        </td>
                        <td style="width: 50%; vertical-align: top;">
                            <div style="margin: 0;">Sesi 5 : 14.00 - 15.30</div>
                            <div style="margin: 0;">Sesi 6 : 15.30 - 17.00</div>
                            <div style="margin: 0;">Sesi 7 : 17.00 - 18.30</div>
                            <div style="margin: 0;">Sesi 8 : 18.30 - 20.00</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top; padding-left: 184px;">
                <div>
                    <div>Kebumen, {{ \Carbon\Carbon::parse($komponen->tanggal_dibuat)->locale('id')->isoFormat('DD MMMM YYYY') }}</div>
                    <div>{{ $komponen->jabatan }}</div>
                    <div style="padding-left: 5px;">
                        <img style="width: 85px;" src="storage/{{ $komponen->ttd }}" alt="Tanda Tangan">
                    </div>
                    <div>{{ $komponen->nama }}</div>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>

</html>
