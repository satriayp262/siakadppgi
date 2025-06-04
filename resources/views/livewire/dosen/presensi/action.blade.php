<div class="flex justify-center space-x-1">
    @php
        $now = new DateTime('now', new DateTimeZone('Asia/Bangkok'));
        $isExpired = $row->valid_until < $now->format('Y-m-d H:i:s');
    @endphp

    <button onclick="{{ !$isExpired ? 'copyToken(\'' . $row->token . '\')' : '' }}"
        class="px-2 py-1 text-white rounded text-center
           {{ $isExpired ? 'bg-gray-500 hover:bg-gray-600 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600' }}"
        {{ $isExpired ? 'disabled' : '' }}>
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z"
                clip-rule="evenodd" />
            <path fill-rule="evenodd"
                d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <button onclick="window.location='{{ route('dosen.detail_presensi', $row->token) }}'"
        class="px-2 py-1 text-white bg-yellow-500 hover:bg-yellow-600 rounded"><svg
            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2"
                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    </button>
</div>
