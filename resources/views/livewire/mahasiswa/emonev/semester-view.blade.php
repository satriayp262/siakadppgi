<div class="mx-5 mt-5">
    <h1 class="font-bold text-customPurple text-lg">Pilih Semester untuk mengisi Emonev</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mx-4 mt-4">
        @foreach ($semester as $item)
            @if ($item->id_semester >= $mahasiswa->mulai_semester || $item->is_active)
                <div class="card bg-white shadow-lg p-4 rounded-lg">
                    <div class="card-header flex justify-between items-center">
                        <h3 class="card-title text-purple2 font-black text-lg text-justify">
                            {{ $item->nama_semester }}
                        </h3>
                        <a href="{{ route('mahasiswa.emonev', ['nama_semester' => $item->nama_semester]) }}"
                            class="bg-purple2 text-white px-4 py-2 rounded-lg">
                            View Details
                        </a>
                    </div>
                    <div class="card-body justify-items-center">
                        {{-- <span>{{ $item->matkul->nama_mata_kuliah }}</span> --}}
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
