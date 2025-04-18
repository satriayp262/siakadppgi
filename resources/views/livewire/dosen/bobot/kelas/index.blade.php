<div class="mx-5 max-w-full overflow-hidden">
    <div class="flex items-center justify-between mx-4 mt-4">
        {{-- <div class="flex flex-wrap justify-between items-center w-full overflow-hidden"> --}}
            <nav aria-label="Breadcrumb" class="flex-1 min-w-0">
                <ol class="flex flex-wrap items-center space-x-1 md:space-x-2 rtl:space-x-reverse overflow-hidden">
                    <li aria-current="page">
                        <div class="flex items-center flex-wrap">
                            <a href="{{ route('dosen.bobot') }}"
                                class="text-xs md:text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center truncate">
                                <span class="text-xs md:text-sm font-medium text-gray-500 ms-1 md:ms-2">Bobot</span>
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                            <a href="{{ route('dosen.bobot.kelas', ['kode_mata_kuliah' => $kode_mata_kuliah]) }}"
                                class="text-xs md:text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center truncate">
                                <span class="text-xs md:text-sm font-medium text-gray-500">{{ $kode_mata_kuliah }}</span>
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
            <div class="mt-2 md:mt-0">
                <input type="text" wire:model.live="search" placeholder="   Search"
                    class="md:px-2 py-2 border border-gray-300 rounded-lg  w-24 md:w-full max-w-xs">
            </div>
        {{-- </div> --}}
    </div>


    @foreach ($kelas as $item)
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-purple2">{{ $item->nama_kelas }}</span>
                    <span class="text-sm font-bold text-gray-400">Nama Prodi :
                        {{ $item->prodi->nama_prodi }}</span>
                </div>
                <div class="flex justify-center space-x-2">
                    <livewire:dosen.bobot.kelas.edit :id_kelas="$item->id_kelas" :kode_mata_kuliah="$this->kode_mata_kuliah"
                        wire:key="edit-{{ rand() . $item->id_kelas }}" />
                </div>
            </div>
        </div>
    @endforeach
</div>
