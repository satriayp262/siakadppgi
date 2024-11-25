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
    $bayar = $tagihans->where('updated_at', '>=', \Carbon\Carbon::today())->sum('total_bayar');
    $bayar = 'Rp ' . number_format($bayar, 0, ',', '.');
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
            <p class="mt-1 text-lg font-extrabold text-yellow-300">{{ $bayar }}</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white shadow-lg p-4 mt-5 rounded-lg">
        <h1 class="mb-3 text-xl ">
            Rekapitulasi Pembayaran
        </h1>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-customPurple text-white text-sm">
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Tanggal</th>
                    <th class="px-4 py-2 text-center">Jam</th>
                    <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                    <th class="px-4 py-2 text-center">Nominal</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($tagihans as $tagihan1)
                    <tr class="border-t" wire:key="tagihan-{{ $tagihan1->id_tagihan }}">
                        <td class="px-4 py-2 text-center">
                            {{ ($tagihans->currentPage() - 1) * $tagihans->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $tagihan1->updated_at->translatedFormat('d F Y') }}</td>

                        <td class="px-4 py-2 text-center">
                            {{ $tagihan1->updated_at->setTimezone('Asia/Jakarta')->format('H:i') }}</td>

                        <td class="px-4 py-2 text-center">{{ $tagihan1->mahasiswa->nama }}</td>
                        <td class="px-4 py-2 text-center">Rp {{ number_format($tagihan1->total_bayar, 0, ',', '.') }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="py-4 mt-4 text-center">
            {{ $tagihans->links('') }}
        </div>
    </div>
</div>
