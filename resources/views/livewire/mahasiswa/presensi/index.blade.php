<div class="max-w-md mx-auto mt-5 p-6 bg-white shadow-md rounded-lg">
    <div>
        @if (session()->has('message'))
            @php
                $messageType = session('message_type', 'success');
                $bgColor =
                    $messageType === 'error'
                        ? 'bg-red-500'
                        : ($messageType === 'warning'
                            ? 'bg-blue-500'
                            : 'bg-green-500');
            @endphp
            <div id="flash-message"
                class="flex items-center justify-between p-2 mx-2 mt-2 text-white {{ $bgColor }} rounded">
                <span>{{ session('message') }}</span>
                <button class="p-1"
                    onclick="document.getElementById('flash-message').style.display='none'">&times;</button>
            </div>
        @endif
    </div>
    <form wire:submit.prevent="submit">
        <div class="container mx-auto text-center mb-6">
            <p class="text-xl font-semibold text-gray-700">Absensi Mahasiswa</p>
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="nama" wire:model="nama"
                class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
            <input type="text" id="nim" wire:model="nim"
                class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label for="token" class="block text-sm font-medium text-gray-700">Token</label>
            <input type="text" id="token" wire:model="token"
                class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500">
            @error('token')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
            <div class="mt-2 flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="radio" id="hadir" wire:model.live="keterangan" value="Hadir"
                        class="form-radio h-4 w-4 text-indigo-600" onclick="toggleRadio(event, this)">
                    <span class="ml-2">Hadir</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" id="ijin" wire:model.live="keterangan" value="Ijin"
                        class="form-radio h-4 w-4 text-indigo-600" onclick="toggleRadio(event, this)">
                    <span class="ml-2">Ijin</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" id="sakit" wire:model.live="keterangan" value="Sakit"
                        class="form-radio h-4 w-4 text-indigo-600" onclick="toggleRadio(event, this)">
                    <span class="ml-2">Sakit</span>
                </label>
            </div>
            @error('keterangan')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        @if ($keterangan == 'Ijin')
            <div class="mb-4">
                <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan</label>
                <input type="text" id="alasan" wire:model="alasan"
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-indigo-500">
                @error('alasan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <button type="submit"
            class="w-full px-4 py-2 bg-purple2 text-white rounded-md hover:bg-customPurple focus:outline-none">
            Submit Presensi
        </button>
    </form>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('error', function(eventData) {
            Swal.fire({
                icon: 'error',
                title: eventData.message,
                text: 'Terjadi kesalahan saat proses presensi.',
                confirmButtonText: 'OK'
            });
        });`
    });

    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('created', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
