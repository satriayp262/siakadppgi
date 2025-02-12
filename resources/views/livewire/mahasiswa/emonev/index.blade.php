<div class="mx-5 mt-5">
    <nav aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('mahasiswa.emonev.semester') }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                    Semester
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $semester->nama_semester }}</span>
                </div>
            </li>
        </ol>
    </nav>

    @if ($krs->isEmpty())
        <div class="flex justify-center mx-4 mt-4 mb-4">
            <div class="card bg-white shadow-lg p-4 rounded-lg max-w-full">
                <div class="card-body justify-items-center">
                    <img src="{{ asset('img/empty-box_18864389.png') }}" alt="not found" class="w-auto h-40 mx-auto">
                    <br>
                    <span class="font-bold text-customPurple text-lg">Belum Ada KRS di Semester
                        ini</span>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mx-4">
            @foreach ($krs as $item)
                <div class="flex flex-col justify-between mx-4 mt-4 mb-4">
                    <div class="card bg-white shadow-lg p-4 rounded-lg max-w-full">
                        <div class="card-header flex justify-between items-center">
                            <h3 class="card-title text-purple2 font-black text-lg text-justify">
                                {{ $item->matkul->dosen->nama_dosen }}</h3>

                        </div>
                        <div class="card-body justify-items-center">
                            <span>{{ $item->matkul->nama_mata_kuliah }}</span>
                        </div>
                        <br>
                        <a href="{{ route('emonev.detail', ['id_mata_kuliah' => $item->matkul->id_mata_kuliah]) }}"
                            class="bg-purple2 text-white px-4 py-2 rounded-lg">
                            Isi Emonev
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
