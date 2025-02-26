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
        </tr>
        <!-- Garis Horizontal -->
        <tr>
            <td colspan="3" style="padding: 0;">
                <hr
                    style="border-top: 3px solid darkviolet; height: 2px; border-bottom: 1px solid darkviolet; margin: 0;">
            </td>
        </tr>
    </table>

    <!-- Content -->
    <div>
        <span style="display: flex; text-align: center; margin-top: 0.5rem; font-size: 1.125rem; font-weight: bold;">
            KARTU {{ $z }} SEMESTER {{ $c }} TAHUN AJARAN {{ $y }}/{{ $y + 1 }}
        </span>
    </div>

    <!-- Nama, NIM, dan Prodi di kiri, tabel di kanan -->
    <div style="display: flex; margin-top: 2%;">
        
        <!-- Nama, NIM, dan Prodi di kiri -->
        <table style="float: left; text-align: left; margin-right: 2%">

                @php
                    $nama = $mahasiswa->nama;
                    $pisah = explode(" ", $nama);
                    $cont = null;
                    $cont2 = null;
                    $cont3 = null;

                    if (count($pisah) > 2) {
                        $nama = implode(" ", array_slice($pisah, 0, 2));
                        $cont = implode(" ", array_slice($pisah, 2, 2));
                        $cont2 = implode(" ", array_slice($pisah, 4, 2));
                        $cont3 = implode(" ", array_slice($pisah, 6, 2));
                    }
                @endphp

            <tr>
                <td style=" font-weight: 500; color: #4b5563;">Nama</td>
                <td style=" text-align: center;">:</td>
                <td style="flex-grow: 1; color: #1f2937;">{{ $nama }}</td>
            </tr>

            @if ($cont)
            <tr>
                <td></td>
                <td></td>
                <td style="flex-grow: 1; color: #1f2937;">{{ $cont }}</td>
            </tr>
            @endif

            @if ($cont2)
            <tr>
                <td></td>
                <td></td>
                <td style="flex-grow: 1; color: #1f2937;">{{ $cont2 }}</td>
            </tr>
            @endif

            @if ($cont3)
            <tr>
                <td></td>
                <td></td>
                <td style="flex-grow: 1; color: #1f2937;">{{ $cont3 }}</td>
            </tr>
            
            @endif
            <tr>
                <td style=" font-weight: 500; color: #4b5563;">NIM</td>
                <td style=" text-align: center;">:</td>
                <td style="flex-grow: 1; color: #1f2937;">{{ $mahasiswa->NIM }}</td>
            </tr>
            <tr>
                <td style=" font-weight: 500; color: #4b5563;">Prodi</td>
                <td style=" text-align: center;">:</td>
                <td style="flex-grow: 1; color: #1f2937;">{{ $mahasiswa->prodi->nama_prodi }}</td>
            </tr>
            <tr>
                <td style=" font-weight: 500; color: #4b5563;">Kelas</td>
                <td style=" text-align: center;">:</td>
                <td style="flex-grow: 1; color: #1f2937;">{{ $kelas->kelas->nama_kelas }}</td>
            </tr>
        </table>

        <!-- Tabel di kanan -->
        <div style="float: left;">
            <div style="border-left: 3px solid darkviolet;">
                <table style="width: 90%; background-color: white; border-collapse: collapse; border: 2px solid black; margin-left: 2%;">
                    <thead>
                        <tr style="text-align: center; font-size: 0.775rem; color: black;">
                            <th style="padding: 0.5rem; border: 2px solid black;">Hari</th>
                            <th style="padding: 0.5rem; border: 2px solid black;">Sesi</th>
                            <th style="padding: 0.5rem; border: 2px solid black;">Mata Kuliah</th>
                            <th style="padding: 0.5rem; border: 2px solid black;">Dosen</th>
                            <th style="padding: 0.5rem; border: 2px solid black;">Kelas</th>
                            <th style="padding: 0.5rem; border: 2px solid black;">Ruangan</th>
                            <th style="padding: 0.5rem; border: 2px solid black;">paraf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $previousDay = null;
                        @endphp

                        @foreach ($jadwals as $jadwal)
                            @if ($jadwal->hari != $previousDay)
                                <tr style="border-top: 2px solid black; font-size: 0.775rem;" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                            @else
                                <tr wire:key="jadwal-{{ $jadwal->id_jadwal }}" style="font-size: 0.775rem;">
                            @endif
                                <td style="padding: 0.25rem 0.5rem; text-align: center;">
                                    @if ($jadwal->hari != $previousDay)
                                        <div>
                                            @if ($jadwal->hari == 'Monday')
                                                Senin
                                            @elseif ($jadwal->hari == 'Tuesday')
                                                Selasa
                                            @elseif ($jadwal->hari == 'Wednesday')
                                                Rabu
                                            @elseif ($jadwal->hari == 'Thursday')
                                                Kamis
                                            @elseif ($jadwal->hari == 'Friday')
                                                Jumat
                                            @endif
                                        </div>
                                        <div style="font-size: 0.875rem;">
                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </div>
                                        @php
                                            $previousDay = $jadwal->hari;
                                        @endphp
                                    @endif
                                </td>
                                <td style="padding: 0.25rem 0.5rem; text-align: center; border: 2px solid black;">{{ $jadwal->sesi }}</td>
                                <td style="padding: 0.25rem 0.5rem; text-align: center; border: 2px solid black;">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                <td style="padding: 0.25rem 0.5rem; text-align: center; border: 2px solid black;">{{ $jadwal->dosen->nama_dosen }}</td>
                                <td style="padding: 0.25rem 0.5rem; text-align: center; border: 2px solid black;">{{ $jadwal->kelas->nama_kelas }}</td>
                                <td style="padding: 0.25rem 0.5rem; text-align: center; border: 2px solid black;">
                                    {{ $jadwal->id_ruangan == 'Online' ? 'Online' : $jadwal->ruangan->kode_ruangan }}
                                </td>
                                <td style="padding: 0.25rem 0.5rem; text-align: center; border: 2px solid black;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
