<div class="flex justify-center items-center space-x-2">
    <livewire:admin.matkul.selengkapnya :id_mata_kuliah="$row->id_mata_kuliah" wire:key="selengkapnya-{{ rand(). $row->id_mata_kuliah }}" />
    <livewire:admin.matkul.edit :id_mata_kuliah="$row->id_mata_kuliah" wire:key="edit-{{ rand(). $row->id_mata_kuliah }}" />
    <button class="px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
        onclick="confirmDelete({{ $row->id_mata_kuliah }}, '{{ $row->nama_mata_kuliah }}')">
        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
        </svg>
    </button>
</div>
