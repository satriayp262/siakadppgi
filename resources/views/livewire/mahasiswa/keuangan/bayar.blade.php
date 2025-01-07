<?php
$bulan = substr($tagihan->Bulan, 5, 2);
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
$tahun = substr($tagihan->Bulan, 0, 4);
?>

<div class="bg-white shadow-lg p-2 mt-4 rounded-lg justify-center size-fit mx-auto">
    <div class="flex flex-col items-center">
        <h1 class="text-xl font-semibold"> Anda Akan Membayar, </h1>
        <div class="flex flex-col items-left mt-2">
            <table>
                <tr>
                    <td class="text-left">Tagihan </td>
                    <td class="text-left">:</td>
                    <td class="text-left">&nbsp;BPP Bulan {{ $namaBulan }} {{ $tahun }}</td>
                </tr>
                <tr>
                    <td class="text-left">Atas Nama</td>
                    <td class="text-left">:</td>
                    <td class="text-left">&nbsp;{{ $tagihan->mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <td class="text-left">Semester</td>
                    <td class="text-left">:</td>
                    <td class="text-left">&nbsp;{{ $tagihan->semester->nama_semester }}</td>
                </tr>
                <tr>
                    <td class="text-left">Total Tagihan</td>
                    <td class="text-left">:</td>
                    <td class="text-left">&nbsp;Rp. {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>


        <div class="flex items-left space-x-2 mt-2">
            <a href="{{ route('mahasiswa.keuangan') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white rounded-md px-2 py-2 mt-2 inline-flex">
                Kembali
            </a>
            <button type="button"
                class="bg-blue-500 hover:bg-blue-700 text-white rounded-md px-2 py-2 mt-2 inline-flex"
                id="pay-button">Bayar
                Sekarang</button>
        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.serverKey') }}">
    </script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transaksi->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    window.location.href =
                        "{{ route('mahasiswa.transaksi.berhasil', $transaksi->id_transaksi) }}";

                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
</div>
