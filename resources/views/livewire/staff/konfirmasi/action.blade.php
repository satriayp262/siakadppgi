<div x-data="{ isOpen: false }" class="relative inline-block text-left">
    <button @click="isOpen = !isOpen"
        class="flex items-center px-3 py-1 font-sm text-white bg-purple2 rounded hover:bg-customPurple">
        Update Status
    </button>

    <div x-show="isOpen" @click.away="isOpen = false" x-transition
        class="absolute right-0 z-10 mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow">
        <ul class="py-2 text-sm text-gray-700">
            <li>
                <button wire:click="updateStatus({{ $row->id_konfirmasi }}, 'Diterima')"
                    class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                    Diterima
                </button>
            </li>
            <li>
                <button wire:click="updateStatus({{ $row->id_konfirmasi }}, 'Ditolak')"
                    class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                    Ditolak
                </button>
            </li>
        </ul>
    </div>
</div>
