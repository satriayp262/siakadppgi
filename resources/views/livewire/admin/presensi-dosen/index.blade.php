<div class="mx-5">
    <div class="flex justify-between mb-4 mt-4 items-center mx-4">
        <div>
            <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 shadow-md">
                Export
            </button>
        </div>

        <div class="flex bg-purple2 rounded-md items-center p-2 space-x-4 shadow-md">
            <!-- Month Filter -->
            <div class="mr-4">
                <span class="font-semibold text-white">Bulan:</span>
                <select wire:model="month" class="border rounded px-2 py-1">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}">
                            {{ \Carbon\Carbon::createFromFormat('m', $m)->locale('id')->monthName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <span class="font-semibold text-white">Tahun:</span>
                <select wire:model="year" class="border rounded px-2 py-1">
                    @foreach (range(now()->year - 5, now()->year) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Search Input -->
        <div class="ml-4 flex items-center">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Search"
                class="px-2 py-2 border border-gray-300 rounded-lg shadow-md">
        </div>
    </div>

    <table class="min-w-full mt-4 bg-white text-sm">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Nama Dosen</th>
                <th class="px-4 py-2 text-center">NIDN</th>
                <th class="px-4 py-2 text-center">Prodi</th>
                <th class="px-4 py-2 text-center">Jumlah Token</th>
                <th class="px-4 py-2 text-center">Jumlah Jam</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dosenWithTokens as $index => $dosen)
                <tr>
                    <td class="px-3 py-2 text-center">
                        {{ ($dosenWithTokens->currentPage() - 1) * $dosenWithTokens->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-2 text-center">{{ $dosen->nama_dosen }}</td>
                    <td class="px-4 py-2 text-center">{{ $dosen->nidn }}</td>
                    <td class="px-4 py-2 text-center">{{ $dosen->prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center">{{ $dosen->tokens_count }}</td>
                    <td class="px-4 py-2 text-center">{{ $dosen->total_jam }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="mt-4 mb-4 text-center">
        {{ $dosenWithTokens->links() }}
    </div>
</div>
