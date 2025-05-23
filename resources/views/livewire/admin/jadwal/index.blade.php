<div class="container p-4 mx-auto">
    <div class="flex items-center justify-between">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Jadwal Perkuliahan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="text-right">
            <ol class="breadcrumb">
                <li class="text-sm font-medium text-gray-700 breadcrumb-item">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </li>
            </ol>
        </div>
    </div>
    <div class="flex mt-4">
        <div class="absolute right-4">
            <select name="prodi" id="prodi" wire:model.live="prodi" class="items-center px-4 py-2 pr-2 ml-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                <option value="" selected>Pilih Prodi</option>
                @foreach ($prodis as $x)
                <option value="{{ $x->kode_prodi }}">{{ $x->nama_prodi }}</option>
                @endforeach
            </select>

            <select name="semesterfilter" id="semesterfilter" wire:model.live="semesterfilter" class="items-center px-4 py-2 pr-2 ml-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                <option value="" selected>Pilih semester</option>
                @foreach ($semesterfilters as $v)
                    <option value="{{ $v->id_semester }}">{{ $v->nama_semester }}</option>
                @endforeach
            </select>
        </div>

        <div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
        <!-- Button to open the modal -->
        <button @click="isOpen=true"
            class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
            Buat Jadwal
        </button>

        <!-- Modal Background -->
            <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
                <!-- Modal Content -->
                <div class="w-1/2 bg-white rounded-lg shadow-lg">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                        <h3 class="text-xl font-semibold">Pilih Semester</h3>
                        <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                            <button class="text-gray-900">&times;</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <form wire:submit.prevent="pilihSemester" class="p-4 space-y-4">
                            <!-- Input Batas Pengajuan -->
                            <div>
                                <label for="batas" class="block mb-2 font-semibold text-gray-700">
                                    Batas Pengajuan Ubah Jadwal
                                </label>
                                <input type="date" name="batas" id="batas" wire:model="batas"
                                       class="block w-full px-2 py-1 mt-1 border border-gray-700 rounded shadow focus:border-indigo-500 sm:text-sm">
                                @error('batas')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Pilih Semester -->
                            <div class="mb-4">
                                <label for="semester" class="block mb-2 font-semibold text-gray-700">Pilih Semester</label>
                                <select id="semester" wire:model="Semester"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                    <option value="">Pilih Semester</option>
                                    @foreach ($semesters as $z)
                                        <option value="{{ $z->id_semester }}">{{ $z->nama_semester }}</option>
                                    @endforeach
                                </select>
                                @error('Semester')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tombol Generate dengan Loading -->
                            <div class="flex items-center space-x-4">
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        wire:target="pilihSemester"
                                        class="relative flex items-center justify-center px-6 py-2 font-semibold text-white bg-green-600 rounded hover:bg-green-700 disabled:opacity-50">
                                    <!-- Teks tombol -->
                                    <span wire:loading.remove wire:target="pilihSemester">
                                        Generate Jadwal
                                    </span>

                                    <!-- Spinner -->
                                    <svg wire:loading wire:target="pilihSemester"
                                         class="w-6 h-6 text-white animate-spin"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" />
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button onclick="confirmDeleteAll()" class='flex items-center px-4 py-2 ml-2 font-bold text-white bg-red-500 rounded hover:bg-red-700'>
            Hapus Semua Jadwal
        </button>
    </div>

    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <table class="w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">Kelas</th>
                    <th class="px-3 py-2 text-center">Hari</th>
                    <th class="px-3 py-2 text-center">Sesi</th>
                    <th class="px-3 py-2 text-center">Mata Kuliah</th>
                    <th class="px-3 py-2 text-center">Dosen</th>
                    <th class="px-3 py-2 text-center">Ruangan</th>
                    <th class="px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            @if ($prodi)
                <tbody>
                    @php
                        $previousDay = null;
                        $previous = null;
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
                            <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                    <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->kelas->nama_kelas != $previous)
                                            {{ $jadwal->kelas->nama_kelas }}
                                            @php
                                                $previous = $jadwal->kelas->nama_kelas;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->hari != $previousDay)
                                            @switch($jadwal->hari)
                                                @case('Monday') Senin @break
                                                @case('Tuesday') Selasa @break
                                                @case('Wednesday') Rabu @break
                                                @case('Thursday') Kamis @break
                                                @case('Friday') Jumat @break
                                            @endswitch
                                            @php
                                                $previousDay = $jadwal->hari;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                                    {{-- @if ($jadwal->tanggal == null)
                                        <td class="px-3 py-1 text-center">Belum ada tanggal Ujian</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    @endif
                                    @if ($jadwal->jenis_ujian == null)
                                        <td class="px-3 py-1 text-center">Belum ada jenis Ujian</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ $jadwal->jenis_ujian }}</td>
                                    @endif --}}
                                    <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->dosen->nama_dosen }}</td>
                                    @if ($jadwal->id_ruangan == 'Online')
                                        <td class="px-3 py-1 text-center">Online</td>
                                    @else
                                            <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                                    @endif
                                    <td class="px-3 py-1 text-center">
                                        <div class="flex flex-row justify-center">
                                            <livewire:admin.jadwal.edit :id_jadwal="$jadwal->id_jadwal"
                                                wire:key="edit-{{ $jadwal->id_jadwal }}" />
                                            <button
                                                class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                                onclick="confirmDelete({{ $jadwal->id_jadwal }}, '{{ $jadwal->kelas->nama_kelas }}')">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                    @endforeach
                </tbody>
            @elseif ($semesterfilter)
                <tbody>
                    @php
                        $previousDay = null;
                        $previousProdi = null;
                        $previousSemester = null;
                    @endphp

                    @foreach ($prodis as $prodi)
                        <!-- Nama Prodi -->
                        {{-- @if ($previousProdi != $prodi->nama_prodi)
                            <tr>
                                <td colspan="5" class="px-3 py-2 font-bold text-left bg-gray-200">
                                    {{ $prodi->nama_prodi }}
                                </td>
                            </tr>
                            @php
                                $previousProdi = $prodi->nama_prodi;
                            @endphp
                        @endif --}}

                        <!-- Jadwal untuk Prodi Berdasarkan Semester -->
                        @foreach ($jadwals->where('kode_prodi', $prodi->kode_prodi)->groupBy('id_semester') as $idSemester => $jadwalsBySemester)
                            @php
                                $previous = null;
                                $semester = $jadwalsBySemester->first()->semester->nama_semester ?? 'Semester Tidak Diketahui';
                            @endphp

                            <!-- Nama Semester -->
                            @if ($previousSemester != $semester)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                        {{ $prodi->nama_prodi }} {{ $semester }}
                                    </td>
                                </tr>
                            @endif

                            <!-- Jadwal -->
                            @foreach ($jadwalsBySemester as $jadwal)
                                @if ($previous != null && $previous != $jadwal->kelas->nama_kelas)
                                    <tr class="border-gray-500 ">
                                        <td colspan="8" class="py-4 bg-gray-100"></td>
                                    </tr>
                                @endif
                                <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                    <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->kelas->nama_kelas != $previous)
                                            {{ $jadwal->kelas->nama_kelas }}
                                            @php
                                                $previous = $jadwal->kelas->nama_kelas;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->hari != $previousDay)
                                            @switch($jadwal->hari)
                                                @case('Monday') Senin @break
                                                @case('Tuesday') Selasa @break
                                                @case('Wednesday') Rabu @break
                                                @case('Thursday') Kamis @break
                                                @case('Friday') Jumat @break
                                            @endswitch
                                            @php
                                                $previousDay = $jadwal->hari;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                                    {{-- @if ($jadwal->tanggal == null)
                                        <td class="px-3 py-1 text-center">Belum ada tanggal Ujian</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    @endif
                                    @if ($jadwal->jenis_ujian == null)
                                        <td class="px-3 py-1 text-center">Belum ada jenis Ujian</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ $jadwal->jenis_ujian }}</td>
                                    @endif --}}
                                    <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->dosen->nama_dosen }}</td>
                                    @if ($jadwal->id_ruangan == 'Online')
                                        <td class="px-3 py-1 text-center">Online</td>
                                    @else
                                            <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                                    @endif
                                    <td class="px-3 py-1 text-center">
                                        <div class="flex flex-row justify-center">
                                            <livewire:admin.jadwal.edit :id_jadwal="$jadwal->id_jadwal"
                                                wire:key="edit-{{ $jadwal->id_jadwal }}" />
                                            <button
                                                class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                                onclick="confirmDelete({{ $jadwal->id_jadwal }}, '{{ $jadwal->kelas->nama_kelas }}')">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
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
                                    <tr class="border-gray-500 ">
                                        <td colspan="8" class="py-4 bg-gray-100"></td>
                                    </tr>
                                @endif
                                <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                    <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->kelas->nama_kelas != $previous)
                                            {{ $jadwal->kelas->nama_kelas }}
                                            @php
                                                $previous = $jadwal->kelas->nama_kelas;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        @if ($jadwal->hari != $previousDay)
                                            @switch($jadwal->hari)
                                                @case('Monday') Senin @break
                                                @case('Tuesday') Selasa @break
                                                @case('Wednesday') Rabu @break
                                                @case('Thursday') Kamis @break
                                                @case('Friday') Jumat @break
                                            @endswitch
                                            @php
                                                $previousDay = $jadwal->hari;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                                    {{-- @if ($jadwal->tanggal == null)
                                        <td class="px-3 py-1 text-center">Belum ada tanggal Ujian</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    @endif
                                    @if ($jadwal->jenis_ujian == null)
                                        <td class="px-3 py-1 text-center">Belum ada jenis Ujian</td>
                                    @else
                                        <td class="px-3 py-1 text-center">{{ $jadwal->jenis_ujian }}</td>
                                    @endif --}}
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
                                    <td class="px-3 py-1 text-center">
                                        <div class="flex flex-row justify-center">
                                            <livewire:admin.jadwal.edit :id_jadwal="$jadwal->id_jadwal"
                                                wire:key="edit-{{ $jadwal->id_jadwal }}" />
                                            <button
                                                class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                                onclick="confirmDelete({{ $jadwal->id_jadwal }}, '{{ $jadwal->kelas->nama_kelas }}')">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
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
                title: `Apakah anda yakin ingin menghapus Jadwal?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil method Livewire jika konfirmasi diterima
                    @this.call('destroy2', id);
                }
            });
        }

        function confirmDelete(id, nama_kelas) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus jadwal ${nama_kelas}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil method Livewire jika konfirmasi diterima
                    @this.call('destroy', id);
                }
            });
        }
    </script>
</div>
