<div class="container mx-auto mt-10">
    <div class="flex justify-center">
        <div class="w-full max-w-md bg-white shadow-md rounded-lg px-8 py-6">
            <h2 class="text-xl font-bold mb-4">Verifikasi Email Anda</h2>
            <p class="mb-4">
                Sebelum melanjutkan, periksa email Anda untuk tautan verifikasi. 
                Jika Anda tidak menerima email, Anda dapat mengirim ulang tautan verifikasi.
            </p>
            <p class="mb-4">
                Email Dikirim ke: {{ Auth::user()->email }}
            </p>
            <div wire:loading>
                <div class="mt-2 w-full flex flex-row items-center space-x-2">
                    <div class="spinner"></div>
                    <div class="spinner-text">Memproses Permintaan...</div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            @if ($resent)
                <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
                    Tautan verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <button 
                wire:click="resendVerificationLink" 
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Kirim Ulang Tautan Verifikasi
            </button>
        </div>
    </div>
</div>
