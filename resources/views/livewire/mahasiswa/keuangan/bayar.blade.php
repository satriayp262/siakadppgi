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

<div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg size-fit justify-center mx-auto">
    <div class="flex flex-col items-center">
        <div class="border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800 text-center">Konfirmasi Pembayaran</h1>
            <p class="text-center text-gray-600 mt-2 text-sm">Harap periksa detail tagihan Anda sebelum melanjutkan
                pembayaran.</p>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-6 text-gray-700">
            <div class="font-medium">Tagihan</div>
            <div class="text-center">:</div>
            <div class="font-semibold text-gray-800">BPP Bulan {{ $namaBulan }} {{ $tahun }}</div>

            <div class="font-medium">Atas Nama</div>
            <div class="text-center">:</div>
            <div class="text-gray-800">{{ $tagihan->mahasiswa->nama }}</div>

            <div class="font-medium">Semester</div>
            <div class="text-center">:</div>
            <div class="text-gray-800">{{ $tagihan->semester->nama_semester }}</div>

            <div class="font-medium">Total Pembayaran</div>
            <div class="text-center">:</div>
            <div class="font-bold">Rp. {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</div>
        </div>

        <br>


        <div class="flex items-left space-x-2 mt-2">
            <button wire:click.prevent="hapus({{ $transaksi->id_transaksi }})"
                class="bg-gray-500 hover:bg-gray-700 text-white rounded-md px-2 py-2 mt-2 inline-flex">
                Kembali
            </button>
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
