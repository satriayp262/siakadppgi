<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.periode.create />
            </div>
        </div>
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                        <th class="px-4 py-2 text-center">No.</th>
                        <th class="px-4 py-2 text-center">Semester</th>
                        <th class="px-4 py-2 text-center">Sesi</th>
                        <th class="px-4 py-2 text-center">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-center">Tanggal Selesai</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periode as $item)
                        <tr class="border-t" wire:key="periode-{{ $item->id_periode }}">
                            <td class="px-4 py-2 text-center">
                                {{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center w-1/4">{{ $item->semester->nama_semester }}</td>
                            <td class="px-4 py-2 text-center w-1/4">{{ $item->sesi }}</td>
                            <td class="px-4 py-2 text-center w-1/4">{{ $item->tanggal_mulai }}</td>
                            <td class="px-4 py-2 text-center w-1/4">{{ $item->tanggal_selesai }}</td>
                            <td class="px-4 py-2 text-center w-1/2">
                                <div class="flex justify-center space-x-2">
                                    {{-- <livewire:admin.periode.edit :id_periode="$item->id_periode" wire:key="edit-{{ $item->id_periode }}" /> --}}
                                    <button
                                        class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                        onclick="confirmDelete('{{ $item->id_periode }}', '{{ $item->nama_periode }}')"><svg
                                            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Controls -->
            {{-- <div class="py-8 mt-4 mb-4 text-center">
            {{ $prodis->links('') }}
        </div> --}}
        </div>
    </div>
</div>
