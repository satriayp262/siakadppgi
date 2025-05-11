<div class="flex justify-center space-x-2">
    <livewire:admin.pengumuman.detail :id_pengumuman="$row->id_pengumuman" wire:key="selengkapnya-{{ rand() . $row->id_pengumuman }}" />
    <livewire:admin.pengumuman.edit :id_pengumuman="$row->id_pengumuman" wire:key="edit-{{ rand() . $row->id_pengumuman }}" />
    <button class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
        onclick="confirmDelete({{ $row->id_pengumuman }}, '{{ $row->title }}')">
        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
        </svg>
    </button>
</div>
