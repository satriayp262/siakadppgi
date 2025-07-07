<div class="container mx-auto px-4">
    {{-- Breadcrumb --}}
    <div class="flex flex-col justify-between mx-4 mt-4">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <a wire:navigate.hover href="{{ route('dosen.presensi') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                        E-Presensi
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" fill="none" viewBox="0 0 6 10"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a wire:navigate.hover
                            href="{{ route('dosen.presensiByKelas', ['id_mata_kuliah' => $matkul->id_mata_kuliah]) }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            {{ $matkul->nama_mata_kuliah }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" fill="none" viewBox="0 0 6 10"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center"
                            href="{{ route('dosen.presensiByToken', ['id_mata_kuliah' => $matkul->id_mata_kuliah, 'id_kelas' => $kelas->id_kelas]) }}">
                            {{ $kelas->nama_kelas }} / {{ $kelas->kode_prodi }} /
                            {{ substr($kelas->Semester->nama_semester, 3, 2) }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" fill="none" viewBox="0 0 6 10"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 flex items-center">
                            Rekap Presensi
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Tabel Rekap Responsif --}}
    <div class="bg-white shadow-lg mt-4 mb-4 rounded-lg p-4">
        <div class="max-w-[935px] overflow-x-auto overflow-y-hidden">
            <livewire:table.rekap-table :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
        </div>
    </div>

</div>
