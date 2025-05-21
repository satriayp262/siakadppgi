<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <a wire:navigate.hover  href="{{ route('dosen.aktifitas') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Aktifitas</span>
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- <livewire:dosen.presensi.create-token /> --}}
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 py-2 border border-gray-300 rounded-lg">
        </div>
    </div>

    @foreach ($matakuliah as $matkul)
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-purple2">{{ $matkul->nama_mata_kuliah }}</span>
                    <span class="text-sm font-bold text-gray-400">Kode Mata Kuliah :
                        {{ $matkul->kode_mata_kuliah }}</span>
                </div>
                <div class="flex justify-center space-x-2 py-2">
                    <a wire:navigate.hover  href="{{ route('dosen.aktifitas.kelas', ['kode_mata_kuliah' => $matkul->kode_mata_kuliah]) }}">
                        <p class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                    d="M9 5l7 7-7 7" />
                            </svg></p>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{ $matakuliah->links('') }}
    </div>
</div>
