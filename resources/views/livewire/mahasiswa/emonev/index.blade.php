@php
    use Vinkla\Hashids\Facades\Hashids;
    use App\Models\MahasiswaEmonev;
@endphp

<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 mb-6">
        <div class="bg-white shadow-lg p-6 rounded-lg max-w-full text-center">

            {{-- Filter Semester --}}
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-4">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                    <span class="block font-medium text-gray-700 text-left">Semester :</span>
                    <select id="semester" wire:model="selectedSemester"
                        class="w-full md:w-48 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-purple-200">
                        <option value="" disabled>Pilih Semester</option>
                        @foreach ($semesters as $item)
                            @foreach ($item as $semester)
                                <option value="{{ $semester->nama_semester }}">{{ $semester->nama_semester }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-start md:items-end">
                    <button wire:click="loadData"
                        class="md:w-auto bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                        Tampilkan
                    </button>
                </div>
            </div>

            {{-- Tidak ada KRS --}}
            @if ($krs->isEmpty())
                <img src="{{ asset('img/boxempty.svg') }}" alt="not found" class="w-40 h-auto mx-auto">
                <p class="font-bold text-customPurple text-lg mt-4">Belum Ada KRS di Semester ini</p>

                {{-- Tidak ada periode --}}
            @elseif ($periode1 == null && $periode2 == null)
                <img src="{{ asset('img/calender.svg') }}" alt="not found" class="w-40 h-auto mx-auto">
                <p class="font-bold text-customPurple text-lg mt-4">Periode pengisian Emonev semester ini belum dibuat
                </p>

                {{-- Ada data --}}
            @else
                @php
                    //$now = now()->toDateString();

                    $now = '2025-06-11';

                    $isPeriode1 = $periode1 && $now >= $periode1->tanggal_mulai && $now <= $periode1->tanggal_selesai;
                    $isPeriode2 = $periode2 && $now >= $periode2->tanggal_mulai && $now <= $periode2->tanggal_selesai;
                    $periode = $isPeriode1 ? $periode1 : ($isPeriode2 ? $periode2 : null);

                @endphp

                {{-- Di luar periode --}}
                @if (!$isPeriode1 && !$isPeriode2)
                    <p class="font-semibold">
                        e-Monev Semester {{ $periode1->semester->nama_semester }} tidak dapat diakses saat ini.
                    </p>
                    <p>Periode 1: {{ $periode1->tanggal_mulai }} - {{ $periode1->tanggal_selesai }}</p>
                    <p>Periode 2: {{ $periode2->tanggal_mulai }} - {{ $periode2->tanggal_selesai }}</p>
                @else
                    {{-- Judul --}}
                    <h1 class="text-xl font-bold text-center mt-6"> e-Monev Dosen Semester
                        {{ $semester1->nama_semester }}
                    </h1>
                    <p>Periode 1: {{ $periode1->tanggal_mulai }} - {{ $periode1->tanggal_selesai }}</p>
                    <p>Periode 2: {{ $periode2->tanggal_mulai }} - {{ $periode2->tanggal_selesai }}</p>

                    {{-- Tabel versi desktop --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full mt-4 bg-white border border-gray-200 hidden md:table">
                            <thead class="bg-gray-100 text-gray-900">
                                <tr class="text-sm">
                                    <th class="px-4 py-2 text-center w-[10%]">#</th>
                                    <th class="px-4 py-2 text-center w-[30%]">Nama Dosen</th>
                                    <th class="px-4 py-2 text-center w-[20%]">NIDN</th>
                                    <th class="px-4 py-2 text-center w-[20%]">Mata Kuliah</th>
                                    <th class="px-4 py-2 text-center w-[20%]">Status</th>
                                    <th class="px-4 py-2 text-center w-[40%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($krs as $item)
                                    @php
                                        $emonev = MahasiswaEmonev::where('NIM', Auth::user()->nim_nidn)
                                            ->where('id_mata_kuliah', $item->matkul->id_mata_kuliah)
                                            ->where('id_semester', $semester1->id_semester)
                                            ->first();

                                        $sesi = $emonev?->sesi;

                                        if (($isPeriode1 && $sesi == 1) || ($isPeriode2 && $sesi == 2)) {
                                            $sudahIsi = 'sudah';
                                            $x = $periode->id_periode;
                                        } elseif ($isPeriode2 && $sesi == 0) {
                                            $sudahIsi = 'terlambat';
                                            $x = $periode->id_periode - 1;
                                        } else {
                                            $sudahIsi = 'belum';
                                            $x = $periode->id_periode;
                                        }

                                        $kode = Hashids::encode($item->matkul->id_mata_kuliah, $k->id_kelas, $x);
                                    @endphp
                                    <tr class="border-b border-gray-200 text-sm">
                                        <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-2 py-2">{{ $item->matkul->dosen->nama_dosen }}</td>
                                        <td class="px-2 py-2">{{ $item->matkul->nidn }}</td>
                                        <td class="px-2 py-2">{{ $item->matkul->nama_mata_kuliah . ' ' . $x }}</td>
                                        <td class="px-2 py-2 text-center">
                                            @if ($sudahIsi == 'sudah')
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-200 text-blue-800">
                                                    Sudah Mengisi
                                                </span>
                                            @elseif ($sudahIsi == 'terlambat')
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-200 text-yellow-800">
                                                    Terlambat Mengisi
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-red-200 text-red-800">
                                                    Belum Mengisi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            @if ($sudahIsi == 'sudah')
                                                <button
                                                    class="bg-gray-200 text-gray-500 px-5 py-2 rounded-lg text-sm font-medium"
                                                    disabled>
                                                    <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                    </svg>

                                                </button>
                                            @elseif ($sudahIsi == 'terlambat')
                                                <a href="{{ route('emonev.detail', ['id_mata_kuliah' => $kode, 'nama_semester' => $semester1->nama_semester]) }}"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition-transform transform hover:scale-105 text-sm font-medium inline-flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="{{ route('emonev.detail', ['id_mata_kuliah' => $kode, 'nama_semester' => $semester1->nama_semester]) }}"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition-transform transform hover:scale-105 text-sm font-medium inline-flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Versi Mobile --}}
                    <div class="space-y-4 mt-2 md:hidden">
                        @foreach ($krs as $item)
                            @php
                                $emonev = MahasiswaEmonev::where('NIM', Auth::user()->nim_nidn)
                                    ->where('id_mata_kuliah', $item->matkul->id_mata_kuliah)
                                    ->where('id_semester', $semester1->id_semester)
                                    ->first();

                                $sesi = $emonev?->sesi;

                                if (($isPeriode1 && $sesi == 1) || ($isPeriode2 && $sesi == 2)) {
                                    $sudahIsi = 'sudah';
                                    $x = $periode->id_periode;
                                } elseif ($isPeriode2 && $sesi == 0) {
                                    $sudahIsi = 'terlambat';
                                    $x = $periode->id_periode - 1;
                                } else {
                                    $sudahIsi = 'belum';
                                    $x = $periode->id_periode;
                                }

                                $kode = Hashids::encode($item->matkul->id_mata_kuliah, $k->id_kelas, $x);
                            @endphp
                            <div class="border rounded-lg p-4 shadow-sm">
                                <div class="font-semibold text-gray-700 mb-2">{{ $loop->iteration }}.
                                    {{ $item->matkul->dosen->nama_dosen }}</div>
                                <div class="text-sm text-gray-600"><strong>NIDN:</strong> {{ $item->matkul->nidn }}
                                </div>
                                <div class="text-sm text-gray-600"><strong>Matkul:</strong>
                                    {{ $item->matkul->nama_mata_kuliah }}</div>
                                <div class="text-sm text-gray-600 mt-2">
                                    <strong>Status:</strong>
                                    @if ($sudahIsi == 'sudah')
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-200 text-blue-800">
                                            Sudah Mengisi
                                        </span>
                                    @elseif ($sudahIsi == 'terlambat')
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-200 text-yellow-800">
                                            Terlambat Mengisi
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold bg-red-200 text-red-800">
                                            Belum Mengisi
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    @if ($sudahIsi == 'belum')
                                        <a href="{{ route('emonev.detail', ['id_mata_kuliah' => $kode, 'nama_semester' => $semester1->nama_semester]) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white w-full py-2 rounded-lg text-sm font-medium block text-center">
                                            Isi e-Monev
                                        </a>
                                    @elseif ($sudahIsi == 'terlambat')
                                        <a href="{{ route('emonev.detail', ['id_mata_kuliah' => $kode, 'nama_semester' => $semester1->nama_semester]) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white w-full py-2 rounded-lg text-sm font-medium block text-center">
                                            Isi e-Monev (Terlambat)
                                        </a>
                                    @else
                                        <button
                                            class="bg-gray-200 text-gray-500 w-full py-2 rounded-lg text-sm font-medium"
                                            disabled>
                                            Sudah Mengisi
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
