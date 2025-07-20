<div class="w-full flex justify-center">
    <a wire:navigate.hover wire:key="edit-{{ rand() . $row->nidn }}" href="{{ route('admin.bobot.dosen', ['nidn' => $row->nidn]) }}">
        <p class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded"><svg xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M9 5l7 7-7 7" />
        </svg></p>
    </a>
    
</div>