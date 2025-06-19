<div class="flex justify-center space-x-1">

    <livewire:admin.dosen.edit :id_dosen="$row->id_dosen" wire:key="edit-{{ rand() . $row->id_dosen }}" />
    <button class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
        onclick="confirmDelete('{{ $row->id_dosen }}', '{{ $row->nama_dosen }}')">
        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
        </svg>
    </button>
    {{-- <livewire:admin.dosen.create-user-dosen :id_dosen="$row->id_dosen" wire:key="create-{{ rand() . $row->id_dosen }}" /> --}}
</div>
