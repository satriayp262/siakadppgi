@php
    use Vinkla\Hashids\Facades\Hashids;
    use App\Models\MahasiswaEmonev;
@endphp

<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 mb-6">
        @if ($krs->isEmpty())
            <div class="bg-white shadow-lg p-6 rounded-lg max-w-full text-center">
                <!-- Dropdown Semester -->
                <div class="flex space-x-4 mb-4">
                    <!-- Dropdown Semester -->
                    <div class="flex space-x-4 items-center">
                        <span class="block font-medium text-gray-700 text-left ">Semester :</span>
                        <select id="semester" wire:model="selectedSemester"
                            class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                            @foreach ($semesters as $item)
                                @foreach ($item as $semester)
                                    <option value="{{ $semester->nama_semester }}">{{ $semester->nama_semester }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Tampilkan -->
                    <div class="flex items-end space-x-2">
                        <button wire:click="loadData"
                            class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                            Tampilkan
                        </button>
                    </div>
                </div>
                <div class="">
                    <img src="{{ asset('img/boxempty.svg') }}" alt="not found" class="w-40 h-auto mx-auto">
                    <p class="font-bold text-customPurple text-lg mt-4">Belum Ada KRS di Semester ini</p>
                </div>
            </div>
        @else
            @if ($periode1 == null && $periode2 == null)
                <div class="bg-white shadow-lg p-6 rounded-lg max-w-full text-center">
                    <!-- Dropdown Semester -->
                    <div class="flex space-x-4 mb-4">
                        <!-- Dropdown Semester -->
                        <div class="flex space-x-4 items-center">
                            <span class="block font-medium text-gray-700 text-left ">Semester :</span>
                            <select id="semester" wire:model="selectedSemester"
                                class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                                @foreach ($semesters as $item)
                                    @foreach ($item as $semester)
                                        <option value="{{ $semester->nama_semester }}">{{ $semester->nama_semester }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Tampilkan -->
                        <div class="flex items-end space-x-2">
                            <button wire:click="loadData"
                                class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                    <div class="">
                        <img src="{{ asset('img/calender.svg') }}" alt="not found" class="w-40 h-auto mx-auto">
                        <p class="font-bold text-customPurple text-lg mt-4">Periode pengisian Emonev semester ini belum
                            di buat
                        </p>
                    </div>
                </div>
            @else
                <!-- Jika diluar periode 1 dan periode 2 -->
                @php
                    $now = now(); // Ambil tanggal sekarang
                    $isPeriode1 = $periode1 && $now >= $periode1->tanggal_mulai && $now <= $periode1->tanggal_selesai;
                    $isPeriode2 = $periode2 && $now >= $periode2->tanggal_mulai && $now <= $periode2->tanggal_selesai;
                @endphp
                @if (!$isPeriode1 && !$isPeriode2)
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg text-center">
                        <p class="font-semibold">e-Monev Semester {{ $periode1->semester->nama_semester }}tidak dapat
                            diakses saat ini.</p>
                        <p>Periode 1: {{ $periode1->tanggal_mulai }} -
                            {{ $periode1->tanggal_selesai }}</p>
                        <p>Periode 2: {{ $periode2->tanggal_mulai }} -
                            {{ $periode2->tanggal_selesai }}</p>
                    </div>
                @else
                    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
                        <div class="flex space-x-4 mb-4">
                            <!-- Dropdown Semester -->
                            <div class="flex space-x-4 items-center">
                                <span class="block font-medium text-gray-700 text-left ">Semester :</span>
                                <select id="semester" wire:model="selectedSemester"
                                    class="w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                                    @foreach ($semesters as $item)
                                        @foreach ($item as $semester)
                                            <option value="{{ $semester->nama_semester }}">
                                                {{ $semester->nama_semester }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tombol Tampilkan -->
                            <div class="flex items-end space-x-2">
                                <button wire:click="loadData"
                                    class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                                    Tampilkan
                                </button>
                            </div>
                        </div>

                        <h1 class=" text-xl font-bold text-center mt-6">Dosen yang mengajar di kelas
                            {{ $k->nama_kelas }} di semester
                            {{ $semester1->nama_semester }}</h1>

                        <table class="min-w-full mt-4 bg-white border border-gray-200">
                            <thead class="bg-purple2 text-white">
                                <thead>
                                    <tr class="bg-customPurple text-white text-sm">
                                        <th class="px-4 py-2 text-center w-[10%]">#</th>
                                        <th class="px-4 py-2 text-center w-[30%]">Nama Dosen</th>
                                        <th class="px-4 py-2 text-center w-[20%]">NIDN</th>
                                        <th class="px-4 py-2 text-center w-[20%]">Mata Kuliah</th>
                                        <th class="px-4 py-2 text-center w-[20%]">Status</th>
                                        <th class="px-4 py-2 text-center w-[40%]">Aksi</th>
                                    </tr>
                                </thead>
                            </thead>
                            <tbody>
                                @foreach ($krs as $item)
                                    <tr class="border-b border-gray-200">
                                        <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-2 py-2 text-left">{{ $item->matkul->dosen->nama_dosen }}</td>
                                        <td class="px-2 py-2 text-left">{{ $item->matkul->nidn }}</td>
                                        <td class="px-2 py-2 text-left">{{ $item->matkul->nama_mata_kuliah }}</td>
                                        <td class="px-2 py-2 text-center">
                                            @php
                                                $emonev = MahasiswaEmonev::where('NIM', Auth::user()->nim_nidn)
                                                    ->where('id_mata_kuliah', $item->matkul->id_mata_kuliah)
                                                    ->where('id_semester', $semester1->id_semester)
                                                    ->first();
                                            @endphp
                                            @if ($isPeriode1 == true && $emonev?->sesi == 1)
                                                <span
                                                    class="px-2 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-semibold">Sudah
                                                    Mengisi</span>
                                            @elseif ($isPeriode2 == true && $emonev?->sesi == 1)
                                                <span
                                                    class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs font-semibold">Belum
                                                    Mengisi</span>
                                            @elseif ($isPeriode2 == true && $emonev?->sesi == 2)
                                                <span
                                                    class="px-2 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-semibold">Sudah
                                                    Mengisi</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs font-semibold">Belum
                                                    Mengisi</span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            @php
                                                $kode = Hashids::encode($item->matkul->id_mata_kuliah, $k->id_kelas);
                                            @endphp

                                            @if ($isPeriode1 == true && $emonev?->sesi == 1)
                                                <button
                                                    class="bg-gray-200 text-gray-500 px-5 py-2 rounded-lg text-sm font-medium ">
                                                    <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            @elseif ($isPeriode2 == true && $emonev?->sesi == 2)
                                                <button
                                                    class="bg-gray-200 text-gray-500 px-5 py-2 rounded-lg text-sm font-medium ">
                                                    <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            @else
                                                <button
                                                    onclick="window.location.href='{{ route('emonev.detail', ['id_mata_kuliah' => $kode, 'nama_semester' => $semester1->nama_semester]) }}'"
                                                    class="bg-purple2 hover:bg-customPurple text-white px-5 py-2 rounded-lg transition-transform transform hover:scale-105 text-sm font-medium">
                                                    <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        @endif
    </div>
</div>
