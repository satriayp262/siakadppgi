<div class="flex justify-center space-x-2">
    <a wire:navigate.hover  href="{{ route('admin.krs.mahasiswa', ['NIM' => $row->NIM]) }}"
        class="py-1 px-2 sm:py-2 sm:px-4 bg-blue-500 hover:bg-blue-700 rounded text-white">
        <p>▶</p>
    </a>
</div>