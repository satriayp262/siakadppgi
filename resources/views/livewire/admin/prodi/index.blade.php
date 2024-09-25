<div class="mx-5">
    <div class="flex justify-between mx-4 mt-4">
        <h1 class="text-2xl font-bold ">Prodi Table</h1>
        <div>
            @if (session()->has('message'))
                <div id="flash-message"
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white bg-green-500 rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:admin.prodi.create />
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">Kode Prodi</th>
                <th class="px-4 py-2 text-center">Nama Prodi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prodis as $prodi)
                <tr class="border-t" wire:key="prodi-{{ $prodi->id_prodi }}">
                    <td class="px-4 py-2 text-center">{{ $prodi->kode_prodi }}</td>
                    <td class="px-4 py-2 text-center">{{ $prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="flex space-x-2">
                                <livewire:admin.matkul.edit :id_mata_kuliah="$matkul->id_mata_kuliah" {{-- wire:key="edit-{{ $matkul->id_mata_kuliah }}" /> --}} </div>
                                    {{-- <button
                                        class="inline-block px-3 py-1 mt-2 text-white bg-red-500 rounded hover:bg-red-700"
                                        onclick="confirmDelete({{ $matkul->id_mata_kuliah }}, '{{ $matkul->nama_mata_kuliah }}')">Delete</button> --}}
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{-- {{ $beritas->links('pagination::tailwind') }} --}}
    </div>
</div>
