<div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">Mata Kuliah</th>
                    <th class="px-4 py-2 text-center">Dosen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matkuls as $x)
                    <tr class="border-t" wire:key="x-{{ $x->id_mata_kuliah }}">
                        <td class="w-1/4 px-4 py-2 text-center">{{ $x->nama_mata_kuliah }}</td>
                        <td class="w-1/4 px-4 py-2 text-center">{{ $x->dosen->nama_dosen }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>