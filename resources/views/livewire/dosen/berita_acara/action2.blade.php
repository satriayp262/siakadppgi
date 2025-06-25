<div class="flex items-center justify-center gap-x-2">
    <livewire:dosen.berita_acara.edit :id_berita_acara="$row->id_berita_acara" wire:key="edit-{{ Rand() . $row->id_berita_acara }}" />

    <button wire:key="delete-{{ $row->id_berita_acara }}" onclick="confirmDelete('{{ $row->id_berita_acara }}')"
        class="w-10 h-10 flex items-center justify-center bg-red-500 text-white rounded hover:bg-red-700">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 7h14M10 11v6m4-6v6M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1zM6 7h12v13a1 1 0 01-1 1H7a1 1 0 01-1-1V7z" />
        </svg>
    </button>

</div>
