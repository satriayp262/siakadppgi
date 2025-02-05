<div class="py-1 mx-5">
    @php
        $mahasiswa = App\Models\Mahasiswa::where('NIM', $this->NIM)->first();
    @endphp
    @if ($mahasiswa)
        <div class="flex items-center justify-between max-w-full p-4 mt-4 mb-4 space-x-2 bg-white rounded-lg shadow-lg">
            <div class="flex justify-start space-x-2">
                <div class="flex-col my-2">
                    <p>NIM</p>
                    <p>Nama</p>
                    <p>Prodi</p>
                </div>
                <div class="flex-col my-2">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </div>
                <div class="flex-col my-2">
                    <p>{{ $mahasiswa->NIM }}</p>
                    <p>{{ $mahasiswa->nama }}</p>
                    <p>{{ $mahasiswa->prodi->nama_prodi }}</p>
                </div>
            </div>
            <div>
                <button wire:click="export"
                    class="flex items-center py-2 pr-4 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                        viewBox="0 0 48 48">
                        <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path>
                        <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z">
                        </path>
                        <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path>
                        <path fill="#17472a" d="M14 24.005H29V33.055H14z"></path>
                        <g>
                            <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"></path>
                            <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z">
                            </path>
                            <path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"></path>
                            <path fill="#129652" d="M29 24.005H44V33.055H29z"></path>
                        </g>
                        <path fill="#0c7238"
                            d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                        </path>
                        <path fill="#fff"
                            d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                        </path>
                    </svg>
                    Export
                </button>
            </div>
        </div>
        <div class="">
            @foreach ($semester as $x)
                @php
                    $krs = App\Models\KRS::where('id_semester', $x->id_semester)
                        ->where('NIM', $mahasiswa->NIM)
                        ->get();
                @endphp
                <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg ">
                    <div class="flex items-center justify-between my-2">
                        <h2>Semester {{ $x->nama_semester }}</h2>
                        <a href="{{ route('admin.krs.edit', ['semester' => $x->id_semester, 'NIM' => $mahasiswa->NIM]) }}"
                            class="px-3 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"><svg
                                class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                            </svg></a>

                    </div>
                    @if (count($krs) != 0)
                        <div class="my-4" wire:key="semester-{{ $x->id_semester }}">
                            <table class="min-w-full border-collapse table-auto">
                                <thead>
                                    <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                                        <th class="px-4 py-2 text-[15px] text-center border">Matkul</th>
                                        <th class="px-4 py-2 text-[15px] text-center border">Dosen</th>
                                        <th class="px-4 py-2 text-[15px] text-center border">SKS Tatap Muka</th>
                                        <th class="px-4 py-2 text-[15px] text-center border">SKS Praktek</th>
                                        <th class="px-4 py-2 text-[15px] text-center border">SKS Praktek Lapangan</th>
                                        <th class="px-4 py-2 text-[15px] text-center border">SKS Simulasi</th>
                                        <th class="px-4 py-2 text-[15px] text-center border">Jenis Mata Kuliah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($krs as $item)
                                        <tr wire:key="krs-{{ $item->id_krs }}">
                                            <td class="px-4 py-2 text-center border">{{ $item->matkul->nama_mata_kuliah }}</td>
                                            <td class="px-4 py-2 text-center border">{{ $item->matkul->dosen->nama_dosen }}</td>
                                            <td class="px-4 py-2 text-center border">{{ $item->matkul->sks_tatap_muka }}</td>
                                            <td class="px-4 py-2 text-center border">{{ $item->matkul->sks_praktek }}</td>
                                            <td class="px-4 py-2 text-center border">{{ $item->matkul->sks_praktek_lapangan }}</td>
                                            <td class="px-4 py-2 text-center border">{{ $item->matkul->sks_simulasi }}</td>
                                            <td class="px-4 py-2 text-center border">
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
                    @else
                    <p>Belum ada data krs pada semester ini</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p>Mahasiswa tidak ditemukan</p>
    @endif

</div>
