<div class="max-w-screen-xl px-4 py-6 mx-auto">
    <!-- Header -->
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Jadwal ujian</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Tanggal -->
        <div class="text-sm font-medium text-gray-700">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    <!-- Filter & Tombol -->
   <div class="flex flex-wrap items-center justify-between gap-2 mt-4">
        <!-- Tombol-tombol -->
        <div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
            <button @click="isOpen=true"
                class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                Input Jadwal Ujian
            </button>
            <!-- Modal -->
            <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
                <div class="w-[90%] max-w-md bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                        <h3 class="text-xl font-semibold">Jadwal Ujian</h3>
                        <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                            <button class="text-gray-900">&times;</button>
                        </div>
                    </div>
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <form wire:submit='tanggal' class="space-y-4">
                            <!-- Jenis Ujian -->
                            <div>
                                <label class="block mb-1">Jenis Ujian</label>
                                <select name="jenis" wire:model="jenis"
                                    class="block w-full px-2 py-1 border border-gray-700 rounded shadow focus:border-indigo-500 sm:text-sm">
                                    <option value="" selected>Pilih Jenis</option>
                                    <option value="UTS">UTS</option>
                                    <option value="UAS">UAS</option>
                                </select>
                                @error('jenis')<span class="text-sm text-red-500">{{ $message }}</span>@enderror
                            </div>

                            <!-- Tanggal Ujian -->
                            <div>
                                <label class="block mb-1">Tanggal Pertama Ujian</label>
                                <input type="date" name="ujian" wire:model="ujian"
                                    class="block w-full px-2 py-1 border border-gray-700 rounded shadow focus:border-indigo-500 sm:text-sm">
                                @error('ujian')<span class="text-sm text-red-500">{{ $message }}</span>@enderror
                            </div>

                            <!-- Tanggal TTD -->
                            <div>
                                <label class="block mb-1">Tanggal TTD</label>
                                <input type="date" name="tanggalttd" wire:model="tanggalttd"
                                    class="block w-full px-2 py-1 border border-gray-700 rounded shadow focus:border-indigo-500 sm:text-sm">
                                @error('tanggalttd')<span class="text-sm text-red-500">{{ $message }}</span>@enderror
                            </div>

                            <!-- Tombol Modal -->
                            <div class="flex justify-end gap-2 pt-4 border-t">
                                <button type="button" @click="isOpen = false"
                                    class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Close</button>
                                <button type="submit"
                                    class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <button onclick="confirmDeleteAll()"
                class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                Hapus Jadwal Ujian
            </button>
            <button type="button"
                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                wire:click='generatePdf()'>
                Download Jadwal Perkuliahan
            </button>

        <!-- Pilih Prodi -->
        <div class="ml-auto">
            <select name="prodi" id="prodi" wire:model.live="prodi"
                class="px-4 py-2 pr-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                <option value="" selected>Pilih Prodi</option>
                @foreach ($prodis as $x)
                    <option value="{{ $x->kode_prodi }}">{{ $x->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- TABEL -->
    <div class="w-full mt-4 overflow-x-auto">
        <table class="w-full min-w-[900px] bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">Kelas</th>
                    <th class="px-3 py-2 text-center">Hari, Tanggal</th>
                    <th class="px-3 py-2 text-center">Sesi</th>
                    <th class="px-3 py-2 text-center">Mata Kuliah</th>
                    <th class="px-3 py-2 text-center">Dosen</th>
                    <th class="px-3 py-2 text-center">Ruangan</th>
                </tr>
            </thead>
            @if ($prodi)
                <tbody>
                    @php
                        $previousDay = null;
                        $previous = null;
                        $previousTanggal = null;
                    @endphp

                    <!-- Kelompokkan Jadwal Berdasarkan Semester -->
                    @foreach ($jadwals->groupBy('id_semester') as $idSemester => $jadwalsBySemester)
                        @php
                            $semester = $jadwalsBySemester->first()->semester->nama_semester ?? 'Semester Tidak Diketahui';
                        @endphp

                        <!-- Header Semester -->
                        <tr>
                            <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                Semester: {{ $semester }}
                            </td>
                        </tr>

                        <!-- Tampilkan Jadwal -->
                        @foreach ($jadwalsBySemester as $jadwal)
                                @if ($previous != null && $previous != $jadwal->kelas->nama_kelas)
                                    <tr class="border-t border-gray-500">
                                        <td colspan="8" class="py-4 bg-gray-100"></td>
                                    </tr>
                                @endif
                                @if ($previousTanggal != $jadwal->tanggal)
                                    <tr class="border-t border-gray-500" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                @else
                                    <tr class="border-t border-gray-300" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                @endif
                                    <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                    @php
                                        $ujian = $jadwal::where('id_kelas', $jadwal->id_kelas)->get('jenis_ujian')->first();
                                        if ($ujian->jenis_ujian == null) {
                                            $ujian->jenis_ujian = '-';
                                        }
                                    @endphp
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->kelas->nama_kelas != $previous)
                                            {{ $jadwal->kelas->nama_kelas }} ({{ $ujian->jenis_ujian }})
                                            @php
                                                $previous = $jadwal->kelas->nama_kelas;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->tanggal)
                                            @php
                                                $day = \Carbon\Carbon::parse($jadwal->tanggal)->format('l');
                                                $tanggalFormat = \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
                                            @endphp

                                            @if ($day != $previousDay || $jadwal->tanggal != $previousTanggal)
                                                @switch($day)
                                                    @case('Monday') Senin @break
                                                    @case('Tuesday') Selasa @break
                                                    @case('Wednesday') Rabu @break
                                                    @case('Thursday') Kamis @break
                                                    @case('Friday') Jumat @break
                                                @endswitch,
                                                {{ $tanggalFormat }}
                                                @php
                                                    $previousDay = $day;
                                                    $previousTanggal = $jadwal->tanggal;
                                                @endphp
                                            @endif
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        Sesi {{ $jadwal->sesi }} ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                                    </td>
                                    @if ($jadwal->matakuliah->jenis_mata_kuliah == 'P')
                                        <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }} (Grup {{ $jadwal->grup }})</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                    @endif
                                    <td class="px-3 py-1 text-center">{{ $jadwal->dosen->nama_dosen }}</td>
                                    @if ($jadwal->id_ruangan == 'Online')
                                        <td class="px-3 py-1 text-center">Online</td>
                                    @else
                                            <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                                    @endif
                                </tr>
                            @endforeach
                    @endforeach
                </tbody>
            @elseif ($semesterfilter)
                <tbody>
                    @php
                        $previousProdi = null;
                        $previousSemester = null;
                    @endphp

                    @foreach ($prodis as $prodi)
                        <!-- Nama Prodi -->
                        @if ($jadwals->where('kode_prodi', $prodi->kode_prodi)->isEmpty())
                            @if ($previousProdi != $prodi->nama_prodi)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-200">
                                        {{ $prodi->nama_prodi }}
                                    </td>
                                </tr>
                                @php
                                    $previousProdi = $prodi->nama_prodi;
                                @endphp
                            @endif
                        @endif

                        <!-- Jadwal untuk Prodi Berdasarkan Semester -->
                        @foreach ($jadwals->where('kode_prodi', $prodi->kode_prodi)->groupBy('id_semester') as $idSemester => $jadwalsBySemester)
                            @php
                                $previousDay = null;
                                $previous = null;
                                $previousTanggal = null;
                                $semester = $jadwalsBySemester->first()->semester->nama_semester ?? 'Semester Tidak Diketahui';
                            @endphp

                            <!-- Nama Semester -->
                            @if ($previousSemester != $semester)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                        {{ $prodi->nama_prodi }} {{ $semester }}
                                    </td>
                                </tr>
                                @php
                                    $previousSemester = $semester;
                                @endphp
                            @elseif ($previousSemester == $semester)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                        {{ $prodi->nama_prodi }} {{ $semester }}
                                    </td>
                                </tr>
                            @endif

                            <!-- Jadwal -->
                            @foreach ($jadwalsBySemester as $jadwal)
                                @if ($previous != null && $previous != $jadwal->kelas->nama_kelas)
                                    <tr class="border-t border-gray-500">
                                        <td colspan="8" class="py-4 bg-gray-100"></td>
                                    </tr>
                                @endif
                                @if ($previousTanggal != $jadwal->tanggal)
                                    <tr class="border-t border-gray-500" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                @else
                                    <tr class="border-t border-gray-300" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                @endif
                                    <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                    @php
                                        $ujian = $jadwal::where('id_kelas', $jadwal->id_kelas)->get('jenis_ujian')->first();
                                        if ($ujian->jenis_ujian == null) {
                                            $ujian->jenis_ujian = '-';
                                        }
                                    @endphp
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->kelas->nama_kelas != $previous)
                                            {{ $jadwal->kelas->nama_kelas }} ({{ $ujian->jenis_ujian }})
                                            @php
                                                $previous = $jadwal->kelas->nama_kelas;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->tanggal)
                                            @php
                                                $day = \Carbon\Carbon::parse($jadwal->tanggal)->format('l');
                                                $tanggalFormat = \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
                                            @endphp

                                            @if ($day != $previousDay || $jadwal->tanggal != $previousTanggal)
                                                @switch($day)
                                                    @case('Monday') Senin @break
                                                    @case('Tuesday') Selasa @break
                                                    @case('Wednesday') Rabu @break
                                                    @case('Thursday') Kamis @break
                                                    @case('Friday') Jumat @break
                                                @endswitch,
                                                {{ $tanggalFormat }}
                                                @php
                                                    $previousDay = $day;
                                                    $previousTanggal = $jadwal->tanggal;
                                                @endphp
                                            @endif
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->dosen->nama_dosen }}</td>
                                    @if ($jadwal->id_ruangan == 'Online')
                                        <td class="px-3 py-1 text-center">Online</td>
                                    @else
                                            <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach

                        <!-- Jika Tidak Ada Jadwal -->
                        @if ($jadwals->where('kode_prodi', $prodi->kode_prodi)->isEmpty())
                            <tr>
                                <td colspan="8" class="px-3 py-2 italic text-center text-gray-500">
                                    Tidak ada jadwal untuk prodi ini.
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            @else
                <tbody>
                    @php
                        $previousProdi = null;
                        $previousSemester = null;
                    @endphp

                    @foreach ($prodis as $prodi)
                        <!-- Nama Prodi -->
                        @if ($jadwals->where('kode_prodi', $prodi->kode_prodi)->isEmpty())
                            @if ($previousProdi != $prodi->nama_prodi)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-200">
                                        {{ $prodi->nama_prodi }}
                                    </td>
                                </tr>
                                @php
                                    $previousProdi = $prodi->nama_prodi;
                                @endphp
                            @endif
                        @endif

                        <!-- Jadwal untuk Prodi Berdasarkan Semester -->
                        @foreach ($jadwals->where('kode_prodi', $prodi->kode_prodi)->groupBy('id_semester') as $idSemester => $jadwalsBySemester)
                            @php
                                $previousDay = null;
                                $previous = null;
                                $previousTanggal = null;
                                $semester = $jadwalsBySemester->first()->semester->nama_semester ?? 'Semester Tidak Diketahui';
                            @endphp

                            <!-- Nama Semester -->
                            @if ($previousSemester != $semester)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                        {{ $prodi->nama_prodi }} {{ $semester }}
                                    </td>
                                </tr>
                                @php
                                    $previousSemester = $semester;
                                @endphp
                            @elseif ($previousSemester == $semester)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                        {{ $prodi->nama_prodi }} {{ $semester }}
                                    </td>
                                </tr>
                            @endif

                            <!-- Jadwal -->
                            @foreach ($jadwalsBySemester as $jadwal)
                                @if ($previous != null && $previous != $jadwal->kelas->nama_kelas)
                                    <tr class="border-t border-gray-500">
                                        <td colspan="8" class="py-4 bg-gray-100"></td>
                                    </tr>
                                @endif
                                @if ($previousTanggal != $jadwal->tanggal)
                                    <tr class="border-t border-gray-500" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                @else
                                    <tr class="border-t border-gray-300" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                @endif
                                    <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                    @php
                                        $ujian = $jadwal::where('id_kelas', $jadwal->id_kelas)->get('jenis_ujian')->first();
                                        if ($ujian->jenis_ujian == null) {
                                            $ujian->jenis_ujian = '-';
                                        }
                                    @endphp
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->kelas->nama_kelas != $previous)
                                            {{ $jadwal->kelas->nama_kelas }} ({{ $ujian->jenis_ujian }})
                                            @php
                                                $previous = $jadwal->kelas->nama_kelas;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->tanggal)
                                            @php
                                                $day = \Carbon\Carbon::parse($jadwal->tanggal)->format('l');
                                                $tanggalFormat = \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
                                            @endphp

                                            @if ($day != $previousDay || $jadwal->tanggal != $previousTanggal)
                                                @switch($day)
                                                    @case('Monday') Senin @break
                                                    @case('Tuesday') Selasa @break
                                                    @case('Wednesday') Rabu @break
                                                    @case('Thursday') Kamis @break
                                                    @case('Friday') Jumat @break
                                                @endswitch,
                                                {{ $tanggalFormat }}
                                                @php
                                                    $previousDay = $day;
                                                    $previousTanggal = $jadwal->tanggal;
                                                @endphp
                                            @endif
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        Sesi {{ $jadwal->sesi }} ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                                    </td>
                                    @if ($jadwal->matakuliah->jenis_mata_kuliah == 'P')
                                        <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }} (Grup {{ $jadwal->grup }})</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                    @endif
                                    <td class="px-3 py-1 text-center">{{ $jadwal->dosen->nama_dosen }}</td>
                                    @if ($jadwal->id_ruangan == 'Online')
                                        <td class="px-3 py-1 text-center">Online</td>
                                    @else
                                            <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach

                        <!-- Jika Tidak Ada Jadwal -->
                        @if ($jadwals->where('kode_prodi', $prodi->kode_prodi)->isEmpty())
                            <tr>
                                <td colspan="8" class="px-3 py-2 italic text-center text-gray-500">
                                    Tidak ada jadwal untuk prodi ini.
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            @endif
        </table>
    </div>

    <script>
        function confirmDeleteAll(id) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Jadwal Ujian?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('clear', id);
                }
            });
        }
    </script>
</div>
