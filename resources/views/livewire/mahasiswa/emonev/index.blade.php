<div class="mx-5">
    @foreach ($dosen as $item)
        <div class="flex flex-col justify-between mx-4 mt-4 mb-4">
            <div class="card bg-white shadow-lg p-4 rounded-lg max-w-full">
                <div class="card-header">
                    <h3 class="card-title text-purple2 font-black text-lg text-justify">{{ $item->nama_dosen }}</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Informasi tambahan tentang dosen bisa ditambahkan di sini.</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
