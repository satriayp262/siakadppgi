<div class="mx-5">
    @foreach ($krs as $item)
        <div class="flex flex-col justify-between mx-4 mt-4 mb-4">
            <div class="card bg-white shadow-lg p-4 rounded-lg max-w-full">
                <div class="card-header flex justify-between items-center">
                    <h3 class="card-title text-purple2 font-black text-lg text-justify">
                        {{ $item->matkul->dosen->nama_dosen }}</h3>
                    <a href="{{ route('mahasiswa.detail', ['id_kelas' => $item->id_kelas]) }}"
                        class="bg-purple2 text-white px-4 py-2 rounded-lg">
                        View Details
                    </a>
                </div>
                <div class="card-body justify-items-center">
                    <span>{{ $item->matkul->nama_mata_kuliah }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
