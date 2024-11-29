<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <form wire:submit.prevent="submit">
        <div class="container mx-auto">
            <p class="text-xl font-semibold text-gray-700 text-center">
                Absensi Mahasiswa
            </p>
        </div>

        @csrf
        <div class="mb-4">
            <label for="nama" class="font-semibold block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="nama" wire:model="nama"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label for="nim" class="font-semibold block text-sm font-medium text-gray-700">NIM</label>
            <input type="text" id="nim" wire:model="nim"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label for="token" class="font-semibold block text-sm font-medium text-gray-700">Token</label>
            <input type="text" id="token" wire:model="token"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('token')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="keterangan" class="font-semibold block text-sm font-medium text-gray-700">Keterangan</label>
            <div class="mt-2 flex justify-start items-center space-x-2" type="radio-group">
                <label class="flex items-center">
                    <input type="radio" id="hadir" wire:model="keterangan" value="Hadir"
                        class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Hadir</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" id="ijin" wire:model="keterangan" value="Ijin"
                        class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Ijin</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" id="sakit" wire:model="keterangan" value="Sakit"
                        class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Sakit</span>
                </label>
            </div>
            @error('keterangan')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
            class="w-full px-4 py-2 bg-purple2 text-white rounded-md hover:bg-customPurple focus:outline-none">Submit
            Presensi</button>
    </form>

    @if (session()->has('message') || session()->has('error'))
        <div id="alert-message"
            class="mt-4 p-2 rounded
        {{ session()->has('message') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ session('message') ?? session('error') }}
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Menghilangkan pesan setelah 3 detik
                setTimeout(() => {
                    const alertMessage = document.getElementById('alert-message');
                    if (alertMessage) {
                        alertMessage.style.transition = 'opacity 0.5s ease';
                        alertMessage.style.opacity = '0'; // Menyembunyikan dengan efek pelan
                        setTimeout(() => alertMessage.remove(), 500); // Menghapus elemen setelah efek selesai
                    }
                }, 3000); // 3000 milidetik = 3 detik
            });
        </script>
    @endif



</div>
