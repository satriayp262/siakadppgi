@if ($row->status_tagihan === 'Lunas')
    <a wire:navigate.hover href="{{ route('mahasiswa.download', $row->no_kwitansi) }}" target="_blank"
        class="inline-flex px-4 py-2 text-white bg-purple2 hover:bg-customPurple rounded-md">

        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
        </svg>
        Unduh
    </a>
@elseif($row->status_tagihan == 'Belum Lunas')
    <livewire:mahasiswa.keuangan.cicil :id_tagihan="$row->id_tagihan" wire:key="edit-{{ rand() . $row->id_tagihan }}" />
@else
    @if ($row->bisa_dicicil == '1')
        <div x-data="{ isOpen: false }" class="relative inline-block text-left">
            <button @click="isOpen = !isOpen"
                class="inline-flex px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-md transition-transform transform hover:scale-105"
                type="button" id="dropdownBayarButton-{{ $row->id_tagihan }}">
                <svg class="w-6 h-6 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M12 14a3 3 0 0 1 3-3h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a3 3 0 0 1-3-3Zm3-1a1 1 0 1 0 0 2h4v-2h-4Z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M12.293 3.293a1 1 0 0 1 1.414 0L16.414 6h-2.828l-1.293-1.293a1 1 0 0 1 0-1.414ZM12.414 6 9.707 3.293a1 1 0 0 0-1.414 0L5.586 6h6.828ZM4.586 7l-.056.055A2 2 0 0 0 3 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2h-4a5 5 0 0 1 0-10h4a2 2 0 0 0-1.53-1.945L17.414 7H4.586Z"
                        clip-rule="evenodd" />
                </svg>
                Bayar
            </button>

            <div x-show="isOpen" @click.away="isOpen = false" x-transition
                class="absolute right-0 z-10 mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <button wire:click="bayar({{ $row->id_tagihan }}, 'Midtrans')"
                            class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                            Bayar Penuh
                        </button>
                    </li>
                    <li>
                        <livewire:mahasiswa.keuangan.cicil :id_tagihan="$row->id_tagihan"
                            wire:key="edit-{{ rand() . $row->id_tagihan }}" />
                    </li>
                </ul>
            </div>
        </div>
    @else
        <button @click="isOpen = !isOpen"
            class="inline-flex px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-md transition-transform transform hover:scale-105"
            type="button" wire:click.prevent="bayar({{ $row->id_tagihan }}, 'Midtrans')">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 14a3 3 0 0 1 3-3h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a3 3 0 0 1-3-3Zm3-1a1 1 0 1 0 0 2h4v-2h-4Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M12.293 3.293a1 1 0 0 1 1.414 0L16.414 6h-2.828l-1.293-1.293a1 1 0 0 1 0-1.414ZM12.414 6 9.707 3.293a1 1 0 0 0-1.414 0L5.586 6h6.828ZM4.586 7l-.056.055A2 2 0 0 0 3 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2h-4a5 5 0 0 1 0-10h4a2 2 0 0 0-1.53-1.945L17.414 7H4.586Z"
                    clip-rule="evenodd" />
            </svg>
            Bayar
        </button>
    @endif

@endif
