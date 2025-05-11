<div class="py-1 mx-5">
    <div class="">
        @foreach ($semester as $x)
            @php
                $krs = App\Models\KRS::where('id_semester', $x->id_semester)
                    ->where('NIM', auth()->user()->nim_nidn)
                    ->get();
                $mahasiswa = App\Models\Mahasiswa::where('NIM', auth()->user()->nim_nidn)->first();
            @endphp
            @if (count($krs) != 0)
                <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg ">
                    <div class="flex items-center justify-between my-2">
                        <h2>Semester {{ $mahasiswa->getSemester($x->id_semester) }}</h2>
                        {{-- <a wire:navigate.hover  href="{{ route('admin.krs.edit', ['semester' => $x->id_semester, 'NIM' => auth()->user()->nim_nidn]) }}" class="px-3 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"><svg
                                class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                            </svg></a> --}}
                    </div>
                    <div class="my-4" wire:key="semester-{{ $x->id_semester }}">
                        <table class="min-w-full border-collapse table-auto md:text-[15px] text-[6px]">
                            <thead>
                                <tr class="items-center w-full text-white align-middle bg-customPurple">
                                    <th class="px-2 py-1 text-center border">Matkul</th>
                                    <th class="px-2 py-1 text-center border">Dosen</th>
                                    <th class="px-2 py-1 text-center border">Kelas</th>
                                    <th class="px-2 py-1 text-center border">SKS Tatap Muka</th>
                                    <th class="px-2 py-1 text-center border">SKS Praktek</th>
                                    <th class="px-2 py-1 text-center border">SKS Praktek Lapangan</th>
                                    <th class="px-2 py-1 text-center border">SKS Simulasi</th>
                                    <th class="px-2 py-1 text-center border">Jenis Mata Kuliah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($krs as $item)
                                    <tr wire:key="krs-{{ $item->id_krs }}">
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->nama_mata_kuliah }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->dosen->nama_dosen }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->kelas->nama_kelas }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->sks_tatap_muka }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->sks_praktek }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->sks_praktek_lapangan }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->sks_simulasi }}</td>
                                        <td class="px-2 py-1 text-center border">
                                            @if ($item->matkul->jenis_mata_kuliah == 'A')
                                                Wajib Program Studi
                                            @elseif ($item->matkul->jenis_mata_kuliah == 'B')
                                                Pilihan
                                            @elseif ($item->matkul->jenis_mata_kuliah == 'C')
                                                Peminatan
                                            @elseif ($item->matkul->jenis_mata_kuliah == 'S')
                                                TA/SKRIPSI/THESIS/DISERTASI
                                            @elseif ($item->matkul->jenis_mata_kuliah == 'W')
                                                Wajib Nasional
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
        {{-- @if (!$this->krs)
            <p>Belum ada data krs pada mahasiswa ini</p>
        @endif --}}
    </div>
</div>
