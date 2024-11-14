<div class="mx-5 py-1">
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <h1 class="my-1">NIM : {{ $this->NIM }}</h1>
        <h1 class="my-1">Nama : {{ App\Models\Mahasiswa::where('NIM', $this->NIM)->first()->nama }}</h1>
        <h1 class="my-1">Prodi : {{ App\Models\Mahasiswa::where('NIM', $this->NIM)->first()->prodi->nama_prodi }}</h1>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        @foreach ($semester as $x)
            @php
                $krs = App\Models\KRS::where('id_semester', $x->id_semester)
                    ->where('NIM', $this->NIM)
                    ->get();
            @endphp
            @if (count($krs) != 0)
                <div class="flex justify-between items-center">
                    <h2>Semester {{ $x->nama_semester }}</h2>
                    <button class="px-3 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"><svg
                            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                        </svg></button>

                </div>
                <div class="my-4" wire:key="semester-{{ $x->id_semester }}">
                    <table class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-[15px] text-left border">Matkul</th>
                                <th class="px-4 py-2 text-[15px] text-left border">Dosen</th>
                                <th class="px-4 py-2 text-[15px] text-left border">Kelas</th>
                                <th class="px-4 py-2 text-[15px] text-left border">Nilai Huruf</th>
                                <th class="px-4 py-2 text-[15px] text-left border">Nilai Indeks</th>
                                <th class="px-4 py-2 text-[15px] text-left border">Nilai Angka</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($krs as $item)
                                <tr wire:key="krs-{{ $item->id_krs }}">
                                    <td class="px-4 py-2 border">{{ $item->matkul->nama_mata_kuliah }}</td>
                                    <td class="px-4 py-2 border">{{ $item->matkul->dosen->nama_dosen }}</td>
                                    <td class="px-4 py-2 border">{{ $item->kelas->nama_kelas }}</td>
                                    <td class="px-4 py-2 border">{{ $item->nilai_huruf }}</td>
                                    <td class="px-4 py-2 border">{{ $item->nilai_index }}</td>
                                    <td class="px-4 py-2 border">{{ $item->nilai_angka }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @php
                    $this->ada = true;
                @endphp
            @endif
        @endforeach
        @if (!$this->ada)
            <p>Belum ada data krs pada mahasiswa ini</p>
        @endif
    </div>
</div>
