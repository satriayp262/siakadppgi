<div class="mx-5">
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-2 py-2 text-center w-1/12">No.</th>
                    <th class="px-4 py-2 text-center w-2/12">Semester</th>
                    <th class="px-4 py-2 text-center w-2/12">Prodi</th>
                    <th class="px-4 py-2 text-center w-1/12">NIDN</th>
                    <th class="px-4 py-2 text-center w-4/12">Nama Dosen</th> <!-- Lebih luas -->
                    <th class="px-4 py-2 text-center w-2/12">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jawaban as $item)
                    <tr class="border-t" wire:key="jawaban-{{ $item->id_jawaban }}">
                        <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td> <!-- Lebih kecil -->
                        <td class="px-4 py-2 text-center">{{ $item->nama_semester }}</td>
                        <td class="px-4 py-2 text-left">{{ $item->nama_prodi }}</td>
                        <td class="px-4 py-2 text-left">{{ $item->nidn }}</td>
                        <td class="px-4 py-2 text-left">{{ $item->nama_dosen }}</td> <!-- Lebih luas -->
                        @php
                            $color = $item->total_nilai > 200 ? 'text-green-500' : 'text-red-500';
                        @endphp
                        <td class="px-4 py-2 text-center font-black text-xl {{ $color }}">
                            {{ $item->total_nilai }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        {{-- <div class="py-8 mt-4 mb-4 text-center">
            {{ $jawaban->links('') }}
        </div> --}}
    </div>
</div>
