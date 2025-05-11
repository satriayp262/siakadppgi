<div class="flex justify-center space-x-2 py-2">
    @php
        $sudahKirim = \App\Models\RiwayatSP::where('nim', $row->NIM)->exists();
    @endphp
    @if ($row->alpha_count == 2 && !$sudahKirim)
        <button class="py-2 px-4 bg-blue-500 text-white hover:bg-blue-700 rounded"
            wire:click="kirimEmail({{ $row->NIM }})">
            Kirim SP
        </button>
    @else
        <button class="py-2 px-4 bg-gray-400 text-white rounded" disabled>
            Kirim SP
        </button>
    @endif
</div>
