<div class="min-h-screen flex items-center justify-center bg-green-600">
    <div class="bg-white shadow-lg p-6 rounded-lg text-center w-96">
        <!-- Icon dan Judul -->
        <div class="flex flex-col items-center space-y-4">
            <div class="bg-green-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <h1 class="text-xl font-semibold text-gray-800">Pembayaran Berhasil</h1>
            <p class="text-gray-600 text-sm">
                Terima kasih, pembayaran Anda telah berhasil diproses.
            </p>
        </div>
        <!-- Tombol Kembali -->
        <div class="mt-6">
            <a wire:navigate.hover  href="{{ route('mahasiswa.keuangan') }}"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg">
                Kembali ke Halaman Keuangan
            </a>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "{{ route('mahasiswa.keuangan') }}";
            }, 2000);
        </script>
    </div>
</div>
