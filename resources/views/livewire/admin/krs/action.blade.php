<div class="flex justify-center space-x-2">
    <a wire:navigate.hover  href="{{ route('admin.krs.mahasiswa', ['NIM' => $row->NIM]) }}"
        class="py-1 px-2 sm:py-2 sm:px-4 bg-blue-500 hover:bg-blue-700 rounded text-white">
        <p><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                    d="M9 5l7 7-7 7" />
                            </svg></p>
    </a>
</div>