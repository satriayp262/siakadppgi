<div class="p-4">
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(120%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
    <?php
    
    $formattedTotalBayar = 'Rp ' . number_format($total_bayar, 0, ',', '.');
    ?>

    <!-- Header Section -->
    <div class="overflow-hidden bg-purple-300 shadow-lg rounded-lg p-2">
        <p class="inline-block whitespace-nowrap text-md font-semibold text-purple-600 marquee-text"
            style="animation: marquee 15s linear infinite;">
            Selamat Datang di halaman Staff
            <span class="text-purple-600">SISTEM INFORMASI AKADEMIK POLITEKNIK PIKSI GANESHA INDONESIA</span>.
        </p>
    </div>

    <!-- Uang Masuk Section -->
    <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-2 lg:grid-cols-4 bg-white shadow-lg rounded-lg p-4">
        <div class="border-l-4 border-purple-600 relative p-4 bg-purple-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Uang Masuk</h2>
            <p class="mt-1 text-lg font-extrabold text-yellow-300">{{ $formattedTotalBayar }}</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white shadow-lg p-4 mt-5 rounded-lg">
        <h1 class="mb-3 text-xl ">
            Rekapitulasi Pembayaran Uang KUliah Mahasiswa
        </h1>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-customPurple text-white text-sm">
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Tanggal</th>
                    <th class="px-4 py-2 text-center">Jam</th>
                    <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                    <th class="px-4 py-2 text-center">Guna Pembayaran</th>
                    <th class="px-4 py-2 text-center">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginatedPembayaran as $data)
                    <tr class="border-t">
                        <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($data['tanggal'])->format('d-m-Y') }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $data['jam'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $data['nama'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $data['metode'] }}</td>
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
