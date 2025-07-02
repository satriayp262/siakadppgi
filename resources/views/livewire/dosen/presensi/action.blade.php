<div class="flex justify-center flex-col items-center space-y-1">
    @php
        $now = new DateTime('now', new DateTimeZone('Asia/Bangkok'));
        $isExpired = $row->valid_until < $now->format('Y-m-d H:i:s');
    @endphp
    <div class="flex justify-center space-x-1">
        <button onclick="{{ !$isExpired ? 'copyToken(\'' . $row->token . '\')' : '' }}"
            class="px-2 py-1 text-white rounded text-center
           {{ $isExpired ? 'bg-gray-500 hover:bg-gray-600 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600' }}"
            {{ $isExpired ? 'disabled' : '' }}>
            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                fill="currentColor" viewBox="0 0 22 22">
                <path fill-rule="evenodd"
                    d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        <button onclick="window.location='{{ route('dosen.detail_presensi', $row->token) }}'"
            class="px-2 py-1 text-white bg-yellow-500 hover:bg-yellow-600 rounded"><svg class="w-4 h-4 text-white"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                viewBox="0 0 22 22">
                <path stroke="currentColor" stroke-width="2"
                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </button>
    </div>

    @php
        $exists = \App\Models\BeritaAcara::where('token', $row->token)->exists();
    @endphp

    @if (!$exists)
        <livewire:dosen.berita-acara.create :token="$row->token" wire:key="create-berita-acara-{{ $row->token }}" />
    @else
        <button
            class="flex items-center p-1 text-sm font-bold text-white bg-gray-500 rounded hover:bg-gray-700 cursor-not-allowed"
            disabled>
            <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4" />
            </svg>
            <span>Jurnal</span>
        </button>
    @endif
</div>
