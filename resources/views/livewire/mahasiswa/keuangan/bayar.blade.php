<div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg size-fit justify-center mx-auto">
    <div class="flex flex-col items-center">
        <div class="border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800 text-center">Konfirmasi Pembayaran</h1>
            <p class="text-center text-gray-600 mt-2 text-sm">Harap periksa detail tagihan Anda sebelum melanjutkan
                pembayaran.</p>
        </div>

        <table class="table-auto w-full mt-6 text-gray-700">
            <tbody>
                <!-- Tagihan -->
                <tr>
                    <td class="font-medium text-left w-1/3">Tagihan</td>
                    <td class="text-center w-1/12">:</td>
                    <td class="font-semibold text-gray-800 ">{{ $tagihan->jenis_tagihan }}</td>

                </tr>
                <!-- Atas Nama -->
                <tr>
                    <td class="font-medium text-left">Atas Nama</td>
                    <td class="text-center">:</td>
                    <td class="text-gray-800 ">{{ $tagihan->mahasiswa->nama }}</td>
                </tr>
                <!-- Semester -->
                <tr>
                    <td class="font-medium text-left">Semester</td>
                    <td class="text-center">:</td>
                    <td class="text-gray-800 ">{{ $tagihan->semester->nama_semester }}</td>
                </tr>
                <!-- Total Pembayaran -->
                <tr>
                    <td class="font-medium text-left">Total Pembayaran + biaya admin</td>
                    <td class="text-center">:</td>
                    <td class="font-bold ">Rp. {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <br>


        <div class="flex items-left space-x-2 mt-2">
            <button wire:click.prevent="hapus({{ $transaksi->id_transaksi }})"
                class="bg-gray-500 hover:bg-gray-700 text-white rounded-md px-2 py-2 mt-2 inline-flex">
                Kembali
            </button>
            <button type="button"
                class="bg-blue-500 hover:bg-blue-700 text-white rounded-md px-2 py-2 mt-2 inline-flex transition-transform transform hover:scale-105"
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
