<div class="flex justify-center space-x-2 py-2">
    <a wire:navigate.hover  href="{{ route('admin.detailPresensiDosen', ['nidn' => $row->nidn]) }}"
        class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
        <p class="text-white">▶</p>
    </a>
</div>
