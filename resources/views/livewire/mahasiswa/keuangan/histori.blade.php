<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold">Histori Transaksi</h1>
                <p class="text-sm text-gray-500">Halaman ini ditunjukan untuk melihat histori transaksi yang telah
                    dilakukan
                </p>
            </div>
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="bg-customPurple text-white text-sm">
                        <th class="px-4 py-2 text-center">No.</th>
                        <th class="px-4 py-2 text-center">Tanggal</th>
                        <th class="px-4 py-2 text-center">Jam</th>
                        <th class="px-4 py-2 text-center">Atas Nama</th>
                        <th class="px-4 py-2 text-center">Guna Pembayaran</th>
                        <th class="px-4 py-2 text-center">Metode Pembayaran</th>
                        <th class="px-4 py-2 text-center">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginatedPembayaran as $data)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($data['tanggal'])->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-2 text-center">{{ $data['jam'] }}</td>
                            <td class="px-4 py-2 text-center">{{ $data['nama'] }}</td>
                            <td class="px-4 py-2 text-center">{{ $data['metode'] }}</td>
                            <td class="px-4 py-2 text-left font-italic ">
                                {{ $data['pembayaran'] }}
                            </td>
                            <td class="px-4 py-2 text-center">Rp {{ number_format($data['nominal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Controls -->
            <div class="py-4 mt-4 text-center">
                {{ $paginatedPembayaran->links('') }}
            </div>
        </div>
    </div>
</div>
