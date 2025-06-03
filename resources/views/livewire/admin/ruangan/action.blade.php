<div class="flex justify-center space-x-2">
    <livewire:admin.ruangan.edit :id_ruangan="$row->id_ruangan" wire:key="edit-{{ $row->id_ruangan }}" />

    <button class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
        onclick="confirmDelete('{{ $row->id_ruangan }}', '{{ $row->nama_ruangan }}')"><svg
            class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
        </svg>
    </button>
</div>

