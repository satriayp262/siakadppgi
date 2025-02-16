<div class="mx-auto max-w-5xl px-4 py-8">
    <h1 class="font-bold text-customPurple text-2xl text-center mb-6">
        Bagikan Pendapatmu! Pilih Semester untuk E-Monev
    </h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @for ($i = $semestermulai->id_semester; $i < $semestermulai->id_semester + $totalsemester; $i++)
            @php
                // get id_semeter by $i
                $item = $semester->where('id_semester', $i)->first();
            @endphp
            @if ($item)
                <div
                    class="bg-white shadow-md border border-gray-200 p-4 rounded-xl hover:shadow-lg transition duration-300 flex flex-col items-center">
                    <div class="bg-customPurple p-3 rounded-full mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3M16 7V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-purple2 font-bold text-lg text-center mb-3">
                        {{ $item->nama_semester }}
                    </h3>
                    <a href="{{ route('mahasiswa.emonev', ['nama_semester' => $item->nama_semester]) }}"
                        class="bg-purple2 hover:bg-customPurple text-white px-4 py-2 rounded-lg transition-transform transform hover:scale-105 text-sm font-medium">
                        View Details
                    </a>
                </div>
            @endif
        @endfor
    </div>
</div>
