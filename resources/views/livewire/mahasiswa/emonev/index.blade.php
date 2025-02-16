<div class="mx-auto max-w-7xl px-5 py-10">
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('mahasiswa.emonev.semester') }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                    Emonev
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="text-sm font-medium text-gray-500">{{ $semester->nama_semester }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Title -->
    <h1 class="font-bold text-customPurple text-2xl text-center mb-6">
        Pilih Dosen dan Mata Kuliah
    </h1>

    @if ($krs->isEmpty())
        <div class="flex justify-center">
            <div class="bg-white shadow-lg p-6 rounded-lg max-w-lg text-center">
                <img src="{{ asset('img/empty-box_18864389.png') }}" alt="not found" class="w-40 h-auto mx-auto">
                <p class="font-bold text-customPurple text-lg mt-4">Belum Ada KRS di Semester ini</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($krs as $item)
                <div
                    class="bg-white shadow-lg border border-gray-200 p-6 rounded-2xl hover:shadow-2xl transition duration-300 flex flex-col">
                    <!-- Icon User -->
                    <div class="bg-customPurple p-3 rounded-full w-fit mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14c4.418 0 8 1.79 8 4v1a1 1 0 01-1 1H5a1 1 0 01-1-1v-1c0-2.21 3.582-4 8-4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>

                    <!-- Nama Dosen -->
                    <h3 class="text-purple2 font-bold text-lg text-center mb-2">
                        {{ $item->matkul->dosen->nama_dosen }}
                    </h3>

                    <!-- Nama Mata Kuliah -->
                    <p class="text-gray-600 text-center text-sm mb-4">
                        {{ $item->matkul->nama_mata_kuliah }}
                    </p>

                    <!-- Button -->
                    <button
                        onclick="window.location.href='{{ route('emonev.detail', ['id_mata_kuliah' => $item->matkul->id_mata_kuliah, 'nama_semester' => $semester->nama_semester]) }}'"
                        class="bg-purple2 hover:bg-customPurple text-white px-5 py-2 rounded-lg transition-transform transform hover:scale-105 text-sm font-medium">
                        Isi Emonev
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>
