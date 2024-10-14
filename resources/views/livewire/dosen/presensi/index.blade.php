<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
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
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    {{-- <button id="copyToken" class="ml-4 bg-white text-black px-2 rounded" onclick="copyToken()">Salin</button> --}}
                    <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:dosen.presensi.create-token />
            {{-- <div class="flex space-x-4">
                <input type="date" wire:model="date" class="border p-2 rounded" />
                <select wire:model="kode_mata_kuliah" class="border p-2 rounded">
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach ($matkul as $matkulItem)
                        <option value="{{ $matkulItem->kode_mata_kuliah }}">{{ $matkulItem->nama_mata_kuliah }}</option>
                    @endforeach
                </select>
            </div> --}}
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>

    <!-- Tabel Token -->
    <table class="min-w-full mt-2 bg-white text-sm">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Token</th>
                <th class="px-4 py-2 text-center">Tanggal</th>
                <th class="px-4 py-2 text-center">Valid Sampai</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tokens as $index => $tokenItem)
                <tr>
                    <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="px-2 py-1 text-center">{{ $tokenItem->matkul->nama_mata_kuliah }}</td>
                    <td class="px-2 py-1 text-center">{{ $tokenItem->token }}</td>
                    <td class="px-2 py-1 text-center">
                        {{ \Carbon\Carbon::parse($tokenItem->created_at)->format('d F Y / H:i:s') }}</td>
                    <td class="px-2 py-1 text-center">
                        {{ \Carbon\Carbon::parse($tokenItem->valid_until)->format('d F Y / H:i:s') }}</td>
                    <td class="px-2 py-1 text-center flex-col space-x-1 items-center">
                        <button onclick="copyToken('{{ $tokenItem->token }}')"
                            class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded text-center">Copy</button>
                        <button onclick="window.location='{{ route('dosen.detail_presensi', $tokenItem->token) }}'"
                            class="px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded">Detail</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{ $tokens->links() }} <!-- Gunakan $tokens di sini -->
    </div> --}}

    <script>
        function copyToken(token) {
            navigator.clipboard.writeText(token).then(function() {
                alert('Token berhasil disalin: ' + token);
            }, function(err) {
                console.error('Error copying text: ', err);
            });
        }
    </script>
</div>
