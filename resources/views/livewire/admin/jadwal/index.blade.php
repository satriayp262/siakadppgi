<div class="max-w-screen-xl px-4 py-6 mx-auto">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="flex-1 min-w-[200px]">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Jadwal Perkuliahan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Tanggal -->
        <div class="text-sm font-medium text-gray-700">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    <!-- Filter & Actions -->
    <div class="flex flex-wrap items-center justify-between gap-2 mt-4">

        <!-- Modal Trigger -->
        <div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
            <button @click="isOpen=true"
                class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                Buat Jadwal
            </button>

            <!-- Modal -->
            <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-gray-600 bg-opacity-75">
                <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                        <h3 class="text-xl font-semibold">Pilih Semester</h3>
                        <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                            <button class="text-gray-900">&times;</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <form wire:submit.prevent="pilihSemester" class="space-y-4">
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

                            <div>
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

                            <div class="flex items-center space-x-4">
                                <button type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="pilihSemester"
                                    class="relative flex items-center justify-center px-6 py-2 font-semibold text-white bg-green-600 rounded hover:bg-green-700 disabled:opacity-50">
                                    <span wire:loading.remove wire:target="pilihSemester">Generate Jadwal</span>
                                    <svg wire:loading wire:target="pilihSemester" class="w-6 h-6 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
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

        <!-- Hapus & Download -->
        <button onclick="confirmDeleteAll()" class="flex items-center px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">
            Hapus Semua Jadwal
        </button>
        <button type="button" wire:click="generatePdf"
            class="flex items-center px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
            Download Jadwal Perkuliahan
        </button>

        <!-- Select Prodi -->
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

    <!-- Table -->
    <div class="p-4 mt-6 mb-4 overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full bg-white border border-gray-200">
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
            @if($prodi != null)
                <tbody>
                    @php
                        $previousProdi = null;
                        $previousSemester = null;
                        $previousDay = null;
                        $previous = null;
                    @endphp
                            <!-- Jadwal -->
                            @foreach ($jadwals as $jadwal)
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
                                            {{ $jadwal->hari }}
                                            @php
                                                $previousDay = $jadwal->hari;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        Sesi {{ $jadwal->sesi }} ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                                    </td>
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
                                $semester = $jadwalsBySemester->first()->semester;
                                $bulanMulai = \Carbon\Carbon::parse($semester->bulan_mulai)->format('m-Y');
                                $bulanSelesai = \Carbon\Carbon::parse($semester->bulan_selesai)->format('m-Y');
                            @endphp

                            <!-- Nama Semester -->
                            {{-- @if ($previousSemester != $semester)
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                        {{ $prodi->nama_prodi }} {{ $semester }}
                                    </td>
                                </tr>
                                @php
                                    $previousSemester = $semester;
                                @endphp --}}
                            {{-- @elseif ($previousSemester == $semester) --}}
                                <tr>
                                    <td colspan="8" class="px-3 py-2 font-bold text-left bg-gray-100">
                                        {{ $prodi->nama_prodi }} {{ $semester->nama_semester }} ({{ $bulanMulai }} sampai {{ $bulanSelesai }})
                                    </td>
                                </tr>
                            {{-- @endif --}}

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
                                            {{ $jadwal->hari }}
                                            @php
                                                $previousDay = $jadwal->hari;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="px-3 py-1 text-center">
                                        Sesi {{ $jadwal->sesi }} ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                                    </td>
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

    <!-- SweetAlert Scripts -->
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
                    @this.call('destroy', id);
                }
            });
        }

        Livewire.on('refreshPage', () => {
            window.location.reload();
        });
    </script>
</div>
