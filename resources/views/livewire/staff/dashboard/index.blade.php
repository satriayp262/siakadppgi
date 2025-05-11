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

    <!-- Table Section -->
    <div class="bg-white shadow-lg p-4 mt-5 rounded-lg">
        <div class="flex justify-between mb-2">
            <div class="flex-col">
                <h1 class="text-2xl font-bold">Histori Pembayaran</h1>
                <p class="text-sm text-gray-500">Halaman ini ditunjukan untuk melihat histori pembayaran uang kuliah
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-3">
                <a wire:navigate.hover href="#"
                    class="relative block p-4 rounded-lg shadow-lg bg-purple-500 hover:bg-purple-600">
                    <h2 class="text-lg font-semibold text-white">Uang Masuk (Hari ini)</h2>
                    <p class="mt-1 text-xl font-bold text-yellow-300">{{ $formattedTotalBayar }}</p>
                </a>
            </div>
        </div>
        @livewire('table.staff.dashboard.history-table')
    </div>
</div>
