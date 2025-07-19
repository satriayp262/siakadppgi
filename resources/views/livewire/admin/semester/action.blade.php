@if ($row->is_active != 1)
    <button class="inline-block px-4 py-1 text-white bg-green-500 rounded hover:bg-green-700"
        onclick="confirmActive({{ $row->id_semester }})">
        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </button>
@endif
