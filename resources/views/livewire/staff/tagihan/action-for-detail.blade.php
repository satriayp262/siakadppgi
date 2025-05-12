@if ($row->status_tagihan == 'Lunas')

    <button class="flex items-center px-3 py-1 font-sm text-white bg-gray-300 rounded cursor-not-allowed" disabled>
        Update Bayar
    </button>
@elseif ($row->status_tagihan == 'Belum Lunas')
    <div x-data="{ isOpen: false }" class="relative inline-block text-left">
        <button @click="isOpen = !isOpen"
            class="inline-flex px-4 py-2 text-white hover:bg-customPurple bg-purple2 rounded-md transition-transform transform hover:scale-105"
            type="button" id="dropdownBayarButton-{{ $row->id_tagihan }}">
            Update Bayar
        </button>

        <div x-show="isOpen" @click.away="isOpen = false" x-transition
            class="absolute right-0 z-10 mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow">
            <ul class="py-2 text-sm text-gray-700">
                <li>
                    <livewire:staff.tagihan.update-cicilan :id_tagihan="$row->id_tagihan"
                        wire:key="edit-{{ rand() . $row->id_tagihan }}" />
                </li>
            </ul>
        </div>
    </div>
@else
    @if ($row->bisa_dicicil == '1')
        <div x-data="{ isOpen: false }" class="relative inline-block text-left">
            <button @click="isOpen = !isOpen"
                class="inline-flex px-4 py-2 text-white hover:bg-customPurple bg-purple2 rounded-md transition-transform transform hover:scale-105"
                type="button" id="dropdownBayarButton-{{ $row->id_tagihan }}">
                Update Bayar
            </button>

            <div x-show="isOpen" @click.away="isOpen = false" x-transition
                class="absolute right-0 z-10 mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <livewire:staff.tagihan.update :id_tagihan="$row->id_tagihan"
                            wire:key="edit-{{ rand() . $row->id_tagihan }}" />
                    </li>
                    <li>
                        <livewire:staff.tagihan.update-cicilan :id_tagihan="$row->id_tagihan"
                            wire:key="edit-{{ rand() . $row->id_tagihan }}" />
                    </li>
                </ul>
            </div>
        </div>
    @else
        <div x-data="{ isOpen: false }" class="relative inline-block text-left">
            <button @click="isOpen = !isOpen"
                class="inline-flex px-4 py-2 text-white hover:bg-customPurple bg-purple2 rounded-md transition-transform transform hover:scale-105"
                type="button" id="dropdownBayarButton-{{ $row->id_tagihan }}">
                Update Bayar
            </button>

            <div x-show="isOpen" @click.away="isOpen = false" x-transition
                class="absolute right-0 z-10 mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <livewire:staff.tagihan.update :id_tagihan="$row->id_tagihan"
                            wire:key="edit-{{ rand() . $row->id_tagihan }}" />
                    </li>
                </ul>
            </div>
        </div>
    @endif
@endif
