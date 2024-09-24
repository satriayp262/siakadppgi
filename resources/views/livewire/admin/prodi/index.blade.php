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
        <input type="text" wire:model.live="search" placeholder="   Search"
            class="ml-4 border border-gray-300 rounded-lg">
        {{-- <livewire:berita.create /> --}}
    </div>
    <table class="min-w-full mt-4 bg-white border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No.</th>
                <th class="px-4 py-2 text-center">Kode Prodi</th>
                <th class="px-4 py-2 text-center">Nama Prodi</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($beritas as $berita)
                <tr class="border-t" wire:key="berita-{{ $berita->id_berita }}">
                    <td class="max-w-xs px-4 py-2 break-words">{{ $berita->title_berita }}</td>
                    <td class="px-4 py-2">
                        {{ \Illuminate\Support\Str::limit($berita->description, 30, '...') }}
                    </td>
                    <td class="px-4 py-2">{{ $berita->tanggal }}</td>
                    <td class="px-4 py-2">{{ $berita->kategori }}</td>
                    <td class="px-4 py-2">
                        <img src="{{ asset('storage/' . $berita->picture) }}" alt="Main Picture" class="block w-24 mx-auto mt-2 mb-2">
                    </td>
                    <td class="px-4 py-2">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="flex space-x-2">
                                <livewire:berita.show :id_berita="$berita->id_berita" wire:key="show-{{ $berita->id_berita }}" />
                                <livewire:berita.form-edit :id_berita="$berita->id_berita" wire:key="edit-{{ $berita->id_berita }}" />
                            </div>
                            <button class="inline-block px-3 py-1 text-white bg-red-500 rounded hover:bg-red-700" 
                                    wire:click="destroy({{ $berita->id_berita }})" wire:confirm="Are you sure?">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{-- {{ $beritas->links('pagination::tailwind') }} --}}
    </div>
</div>
