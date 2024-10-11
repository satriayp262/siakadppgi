<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <form  wire:submit.prevent="submit">
        <div class="container mx-auto">
            <p class="text-xl font-semibold text-gray-700 text-center">
                Absensi Mahasiswa
            </p>
        </div>

        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="nama" value="{{ $nama }}"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
            <input type="text" id="nim" value="{{ $nim }}"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label for="token" class="block text-sm font-medium text-gray-700">Token</label>
            <input type="text" id="token" wire:model="token"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('token')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
            class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none">Submit
            Presensi</button>
    </form>

    @if (session()->has('message'))
        <div class="mt-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
