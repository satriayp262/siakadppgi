@php
    use Vinkla\Hashids\Facades\Hashids;
@endphp
<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 mb-6">
        <div class="bg-white shadow-lg p-6 rounded-lg max-w-full text-center">
            <h1 class=" text-customPurple font-semibold justify-center ">Pilih Mata Kuliah</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">

                @foreach ($matkul as $mk)
                    @php
                        $kode = Hashids::encode($mk->id_mata_kuliah);
                    @endphp
                    <a href="{{ route('dosen.emonev.show', $kode) }}"
                        class="block max-w-sm p-6 bg-purple2 border border-gray-200 rounded-lg shadow-sm hover:bg-customPurple">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">{{ $mk->nama_mata_kuliah }}</h5>
                        <p class="font-normal text-xs text-gray-300">{{ $mk->kode_mata_kuliah }}</p>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</div>
