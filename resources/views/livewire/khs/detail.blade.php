<div class="py-1 mx-5">

    <div class="flex justify-between items-center mt-4 ml-4">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <a href="{{ route('dosen.khs') }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">KHS</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                        <a href="{{ route('dosen.khs.detail', ['NIM' => $NIM]) }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            <span class="text-sm font-medium text-gray-500 ">Detail</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </li>
            </ol>
        </nav>
        <input type="text" wire:model.live="search" placeholder="   Search"
            class="px-2 ml-4 py-2 border border-gray-300 rounded-lg">
    </div>
    @php
        $mahasiswa = App\Models\Mahasiswa::where('NIM', $NIM)->first();
        $IPK = 0;
        $nilaiKumulatif = 0;
    @endphp
    @if ($mahasiswa)
        <div class="flex items-center justify-between max-w-full p-4 mt-4 mb-4 space-x-2 bg-white rounded-lg shadow-lg">
            <div class="flex justify-start text-gray-700">
                <div class="flex-col my-2">
                    <p class="px-2 font-bold text-[20px]">NIM</p>
                    <p class="px-2 font-bold text-[20px]">Nama</p>
                    <p class="px-2 font-bold text-[20px]">Prodi</p>
                </div>
                <div class="flex-col my-2">
                    <p class="px-2 font-bold text-[20px]">:</p>
                    <p class="px-2 font-bold text-[20px]">:</p>
                    <p class="px-2 font-bold text-[20px]">:</p>
                </div>
                <div class="flex-col my-2">
                    <p class="px-2 font-bold text-[20px]">
                        {{ $mahasiswa->NIM }}
                    </p>
                    <p class="px-2 font-bold text-[20px]">
                        {{ $mahasiswa->nama }}
                    </p>
                    <p class="px-2 font-bold text-[20px]">
                        {{ $mahasiswa->prodi->nama_prodi }}
                    </p>
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

                    $cekTagihan = App\Models\Tagihan::where('id_semester', $x->id_semester)
                        ->where('NIM', $mahasiswa->NIM)
                        ->where('status_tagihan', 'Lunas')
                        ->exists();

                    foreach ($khs as $y) {
                        if (
                            !App\Models\MahasiswaEmonev::where('id_semester', $x->id_semester)
                                ->where('NIM', $mahasiswa->NIM)
                                ->where('id_mata_kuliah', $y->id_mata_kuliah)
                                ->where('sesi', 2)
                                ->exists()
                        ) {
                            $cekEmonev = false;
                            break;
                        } else {
                            $cekEmonev = true;
                        }
                    }
                @endphp
                @if (count($khs) != 0)
                    @if ($cekTagihan == true && $cekEmonev == true)
                        <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg ">
                            <div class="flex items-center justify-between my-2">
                                <h2 class="font-bold text-[18px] ml-1 text-gray-700">Semester
                                    {{ $mahasiswa->getSemester($x->id_semester) }}</h2>
                                {{-- <a href="{{ route('admin.krs.edit', ['semester' => $x->id_semester, 'NIM' => $this->NIM]) }}" --}}
                                @if (auth()->user()->role == 'mahasiswa')
                                    <a href="{{ route('mahasiswa.khs.download', [$mahasiswa->NIM, $x->id_semester]) }}"
                                        class="px-3 py-3 font-bold text-white bg-purple2 rounded hover:bg-purple2">
                                        <img width="24" height="24"
                                            src="https://img.icons8.com/material-sharp/24/download--v1.png"
                                            alt="download--v1" />
                                    </a>
                                @endif
                            </div>
                            <div class="my-4" wire:key="semester-{{ $x->id_semester }}">
                                <table class="min-w-full border-collapse table-auto">
                                    <thead>
                                        <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                                            <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Kode
                                            </th>
                                            <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">
                                                Matkul
                                            </th>
                                            <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">SKS
                                            </th>
                                            <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Angka
                                            </th>
                                            <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Angka
                                                Mutu
                                            </th>
                                            <th class="px-4 py-2 text-[15px] text-center border border-x-gray-500">Huruf
                                                Mutu</th>
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
                                                <td class="px-4 py-2 text-center border border-gray-500">
                                                    {{ $item->getGrade($item->bobot)['angka'] }}</td>
                                                <td class="px-4 py-2 text-center border border-gray-500">
                                                    {{ $item->getGrade($item->bobot)['angka'] * $sks }}</td>
                                                <td class="px-4 py-2 text-center border border-gray-500">
                                                    {{ $item->getGrade($item->bobot)['huruf'] }}</td>
                                            </tr>
                                            @php
                                                $jumlahSKS += $sks;
                                                $totalAngka += $item->getGrade($item->bobot)['angka'];
                                                $jumlahNilai += $item->getGrade($item->bobot)['angka'] * $sks;
                                                $IPS = round($jumlahNilai / $jumlahSKS, 2);
                                            @endphp
                                        @endforeach
                                        @php
                                            $nilaiKumulatif += $IPS;
                                            $IPK = round($nilaiKumulatif / $mahasiswa->getSemester($x->id_semester), 2);
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-2 text-left border border-gray-500"></td>
                                            <td class="px-4 py-2 font-bold text-left border border-gray-500">Jumlah</td>
                                            <td class="px-4 py-2 font-bold text-center border border-gray-500">
                                                {{ $jumlahSKS }}</td>
                                            <td class="px-4 py-2 font-bold text-center border border-gray-500">
                                                {{ $totalAngka }}</td>
                                            <td class="px-4 py-2 font-bold text-center border border-gray-500">
                                                {{ $jumlahNilai }}</td>
                                            <td class="px-4 py-2 text-left border border-gray-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 text-left border border-gray-500"></td>
                                            <td class="px-4 py-2 font-bold text-left border border-gray-500">IPS</td>
                                            <td class="px-4 py-2 text-center border border-gray-500"></td>
                                            <td class="px-4 py-2 text-left border border-gray-500"></td>
                                            <td class="px-4 py-2 text-center border border-gray-500"></td>
                                            <td class="px-4 py-2 font-bold text-center border border-gray-500">
                                                {{ $IPS }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h2 class="font-bold text-[18px] ml-1 text-gray-700">IPK : {{ $IPK }}</h2>
                        </div>
                    @else
                        <div
                            class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg flex-col items-center justify-between my-2">
                            <h2 class="font-bold text-[18px] ml-1 text-gray-700">Semester
                                {{ $mahasiswa->getSemester($x->id_semester) }}</h2>
                            @if ($cekTagihan == false)
                                <div class="flex items-center justify-between my-2">
                                    <h2 class="font-bold text-[18px] ml-1 text-gray-700">Mohon Lunasi Tagihan</h2>
                                    @if (auth()->user()->role == 'mahasiswa')
                                        <a href="{{ route('mahasiswa.keuangan') }}"
                                            class="px-3 py-3 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                            <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M12 14a3 3 0 0 1 3-3h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a3 3 0 0 1-3-3Zm3-1a1 1 0 1 0 0 2h4v-2h-4Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M12.293 3.293a1 1 0 0 1 1.414 0L16.414 6h-2.828l-1.293-1.293a1 1 0 0 1 0-1.414ZM12.414 6 9.707 3.293a1 1 0 0 0-1.414 0L5.586 6h6.828ZM4.586 7l-.056.055A2 2 0 0 0 3 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2h-4a5 5 0 0 1 0-10h4a2 2 0 0 0-1.53-1.945L17.414 7H4.586Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                            @if ($cekEmonev == false)
                                <div class="flex items-center justify-between my-2">
                                    <h2 class="font-bold text-[18px] ml-1 text-gray-700">Mohon Selesaikan E-monev
                                    </h2>
                                    @if (auth()->user()->role == 'mahasiswa')
                                        <a href="{{ route('mahasiswa.emonev') }}"
                                            class="px-3 py-3 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                            <svg class="flex-shrink-0 w-6 h-6 transition duration-75  }}"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M3 15v3c0 .5523.44772 1 1 1h10M3 15v-4m0 4h9m-9-4V6c0-.55228.44772-1 1-1h16c.5523 0 1 .44772 1 1v3M3 11h11m-2-.2079V19m3-4h1.9909M21 15c0 1.1046-.8954 2-2 2s-2-.8954-2-2 .8954-2 2-2 2 .8954 2 2Z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
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
