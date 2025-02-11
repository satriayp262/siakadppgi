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
            </div>
        </div>
        <div class="">
            @foreach ($semester as $x)
                @php
                    if (auth()->user()->role == 'mahasiswa') {
                        $khs = App\Models\KHS::where('id_semester', $x->id_semester)
                            ->where('NIM', $mahasiswa->NIM)
                            // ->where('publish', 'yes')
                            ->get();
                    } else {
                        $khs = App\Models\KHS::where('id_semester', $x->id_semester)
                            ->where('NIM', $mahasiswa->NIM)
                            ->get();
                    }
                    $jumlahSKS = 0;
                    $jumlahNilai = 0;
                    $totalAngka = 0;
                @endphp
                <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg ">
                    <div class="flex items-center justify-between my-2">
                        <h2>Semester {{ $x->nama_semester }}</h2>
                        {{-- <a href="{{ route('admin.krs.edit', ['semester' => $x->id_semester, 'NIM' => $this->NIM]) }}" --}}
                        @if (!(auth()->user()->role == 'mahasiswa'))
                            <a wire:click="calculate({{ $mahasiswa->NIM }},{{ $x->id_semester }})"
                                class="px-3 py-3 font-bold text-white bg-amber-500 rounded hover:bg-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M13.5 2c-5.621 0-10.211 4.443-10.475 10h-3.025l5 6.625 5-6.625h-2.975c.257-3.351 3.06-6 6.475-6 3.584 0 6.5 2.916 6.5 6.5s-2.916 6.5-6.5 6.5c-1.863 0-3.542-.793-4.728-2.053l-2.427 3.216c1.877 1.754 4.389 2.837 7.155 2.837 5.79 0 10.5-4.71 10.5-10.5s-4.71-10.5-10.5-10.5z"
                                        fill="white" />
                                </svg></a>
                        @else
                            <a wire:click=""
                                class="px-3 py-3 font-bold text-white bg-purple2 rounded hover:bg-purple2">
                                <img width="24" height="24"
                                    src="https://img.icons8.com/material-sharp/24/download--v1.png"
                                    alt="download--v1" />
                            </a>
                        @endif
                    </div>
                    @if (count($khs) != 0)
                        <div class="my-4" wire:key="semester-{{ $x->id_semester }}">
                            <table class="min-w-full border-collapse table-auto">
                                <thead>
                                    <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Kode</th>
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Matkul</th>
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">SKS</th>
                                        {{-- <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">SKS Praktek</th>
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">SKS Praktek Lapangan</th>
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">SKS Simulasi</th> --}}
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Bobot</th>
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Angka</th>
                                        <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">S x N</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($khs as $item)
                                        <tr wire:key="khs-{{ $item->id_khs }}">
                                            <td class="px-4 py-2 text-left border border-gray-500">
                                                {{ $item->matkul->kode_mata_kuliah }}</td>
                                            <td class="px-4 py-2 text-left border border-gray-500">
                                                {{ $item->matkul->nama_mata_kuliah }}</td>
                                            <td class="px-4 py-2 text-center border border-gray-500">
                                                {{ $sks =
                                                    $item->matkul->sks_tatap_muka +
                                                    $item->matkul->sks_simulasi +
                                                    $item->matkul->sks_praktek +
                                                    $item->matkul->sks_praktek_lapangan }}
                                            </td>
                                            {{-- <td class="px-4 py-2 text-center border border-gray-500">{{ $item->matkul->sks_praktek }}
                                            </td>
                                            <td class="px-4 py-2 text-center border border-gray-500">
                                                {{ $item->matkul->sks_praktek_lapangan }}</td>
                                            <td class="px-4 py-2 text-center border border-gray-500">{{ $item->matkul->sks_simulasi }}
                                            </td> --}}
                                            <td class="px-4 py-2 text-center border border-gray-500">
                                                {{ $item->getGrade($item->bobot)['huruf'] }}</td>
                                            <td class="px-4 py-2 text-center border border-gray-500">
                                                {{ $item->getGrade($item->bobot)['angka'] }}</td>
                                            <td class="px-4 py-2 text-center border border-gray-500">
                                                {{ $item->getGrade($item->bobot)['angka'] * $sks }}</td>
                                        </tr>
                                        @php
                                            $jumlahSKS += $sks;
                                            $totalAngka += $item->getGrade($item->bobot)['angka'];
                                            $jumlahNilai += $item->getGrade($item->bobot)['angka'] * $sks;
                                            $IPS = round($jumlahNilai / $jumlahSKS,2);
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td class="px-4 py-2 text-left border border-gray-500"></td>
                                        <td class="px-4 py-2 font-bold text-left border border-gray-500">Jumlah</td>
                                        <td class="px-4 py-2 font-bold text-center border border-gray-500">{{ $jumlahSKS }}</td>
                                        <td class="px-4 py-2 text-left border border-gray-500"></td>
                                        <td class="px-4 py-2 font-bold text-center border border-gray-500">{{ $totalAngka }}</td>
                                        <td class="px-4 py-2 font-bold text-center border border-gray-500">{{ $jumlahNilai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-left border border-gray-500"></td>
                                        <td class="px-4 py-2 font-bold text-left border border-gray-500">IPS</td>
                                        <td class="px-4 py-2 text-center border border-gray-500"></td>
                                        <td class="px-4 py-2 text-left border border-gray-500"></td>
                                        <td class="px-4 py-2 text-center border border-gray-500"></td>
                                        <td class="px-4 py-2 font-bold text-center border border-gray-500">{{ $IPS }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Belum ada data KHS pada semester ini</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p>Mahasiswa tidak ditemukan</p>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('updatedKHS', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail[0],
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
