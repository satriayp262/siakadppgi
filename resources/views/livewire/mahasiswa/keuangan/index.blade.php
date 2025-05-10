<div>
    <div class="mx-5">
        <div class="flex flex-col justify-between mx-4 mt-4">
            <div>
                @if (session()->has('message'))
                    @php
                        $messageType = session('message_type', 'success'); // Default to success
                        $bgColor =
                            $messageType === 'error'
                                ? 'bg-red-500'
                                : ($messageType === 'warning'
                                    ? 'bg-blue-500'
                                    : 'bg-green-500');
                    @endphp
                    <div id="flash-message"
                        class="flex items-center justify-between p-2 mx-2 mt-4 text-white {{ $bgColor }} rounded">
                        <span>{{ session('message') }}</span>
                        <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                            class="font-bold text-white">
                            &times;
                        </button>
                    </div>
                @endif
            </div>
        </div>
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

        <div class="p-2 overflow-hidden bg-purple-300 rounded-lg shadow-lg">
            <p class="inline-block font-semibold text-purple-600 whitespace-nowrap text-md marquee-text"
                style="animation: marquee 20s linear infinite;">
                Halaman ini menampilkan informasi tagihan dan pembayaran Anda, Info Rekening PPGI
                <span class="text-yellow-300">13123213 </span>.
            </p>
        </div>

        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
            <div class="justify-between flex items-center mr-2">
                <div class="flex flex-col">
                    <h1 class="text-2xl font-bold">Pembayaran Anda</h1>
                    <p class="text-sm text-gray-500">Halaman ini ditunjukan untuk melihat tagihan dan pembayaran Anda
                    </p>
                </div>
                <a wire:navigate.hover href="{{ route('mahasiswa.transaksi.histori') }}" class=" text-blue-500">Histori
                    Pembayaran</a>
            </div>
            @livewire('table.mahasiswa.keuangan.tagihan-table')
        </div>
    </div>
</div>
