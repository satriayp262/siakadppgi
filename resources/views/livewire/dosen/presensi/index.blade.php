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
            <div class="flex space-x-4">
                <input type="date" wire:model="date" class="border p-2 rounded" />
                <select wire:model="kode_mata_kuliah" class="border p-2 rounded">
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach ($matkul as $matkulItem)
                        <option value="{{ $matkulItem->kode_mata_kuliah }}">{{ $matkulItem->nama_mata_kuliah }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>

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
                        {{ \Carbon\Carbon::parse($tokenItem->created_at)->format('d F Y / H:i:s') }}
                    </td>
                    <td class="px-2 py-1 text-center">{{ \Carbon\Carbon::parse($tokenItem->valid_until)->format('d F Y / H:i:s') }}</td>
                    <td class="px-2 py-1 text-center flex-col space-x-1 items-center">
                        <button onclick="copyToken('{{ $tokenItem->token }}')"
                            class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded text-center">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                              </svg>
                        </button>
                        <button onclick="window.location='{{ route('dosen.detail_presensi', $tokenItem->token) }}'"
                            class="px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                              </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


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
