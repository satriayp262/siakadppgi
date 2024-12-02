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
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Jadwal Mengajar</span>
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
        {{-- <button wire:click="generate" class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
            Generate Jadwal
        </button> --}}
        
        <select name="prodi" id="prodi" wire:model.live="prodi" class="absolute items-center px-4 py-2 pr-2 ml-2 font-bold text-white bg-blue-500 rounded right-4 hover:bg-blue-700">
            <option value="" selected>Pilih Prodi</option>
            @foreach ($prodis as $x)
                <option value="{{ $x->kode_prodi }}">{{ $x->nama_prodi }}</option>
            @endforeach
        </select>
        
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
                        <div class="p-4 max-h-[500px] overflow-y-auto">
                            <div class="grid grid-cols-4 gap-4 mb-4">
                                @foreach ($semesters as $z)
                                    <button type="button" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                                            wire:click="pilihSemester({{ $z->id_semester }})">
                                        {{ $z->nama_semester }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button onclick="confirmDelete()" class='flex items-center px-4 py-2 ml-2 font-bold text-white bg-red-500 rounded hover:bg-red-700'>
            Hapus Jadwal
        </button>
    </div>

    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <table class="w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">Hari</th>
                    <th class="px-3 py-2 text-center">Sesi</th>
                    <th class="px-3 py-2 text-center">Kelas</th>
                    <th class="px-3 py-2 text-center">Dosen</th>
                    <th class="px-3 py-2 text-center">Ruangan</th>
                </tr>
            </thead>
            @if ($prodi)
                <tbody>
                    @php
                        $previousDay = null;
                    @endphp

                    @foreach ($jadwals as $jadwal)
                        <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                            <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                            <td class="px-3 py-1 text-center">
                                @if ($jadwal->hari != $previousDay)
                                    @if ($jadwal->hari == 'Monday')
                                        Senin
                                    @elseif ($jadwal->hari == 'Tuesday')
                                        Selasa
                                    @elseif ($jadwal->hari == 'Wednesday')
                                        Rabu
                                    @elseif ($jadwal->hari == 'Thursday')
                                        Kamis
                                    @elseif ($jadwal->hari == 'Friday')
                                        Jumat
                                    @endif
                                    @php
                                        $previousDay = $jadwal->hari;
                                    @endphp
                                @endif
                            </td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->kelas->nama_kelas }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->kelas->matkul->dosen->nama_dosen }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody>
                    @php
                        $previousDay = null;
                    @endphp
                    
                    @foreach ($prodis as $prodi)
                        <!-- Nama Prodi -->
                        <tr>
                            <td colspan="5" class="px-3 py-2 font-bold text-left bg-gray-100">
                                {{ $prodi->nama_prodi }}
                            </td>
                        </tr>
                        
                        <!-- Jadwal untuk Prodi -->
                        @foreach ($jadwals->where('kelas.kode_prodi', $prodi->kode_prodi) as $jadwal)
                            <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                                <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                                <td class="px-3 py-1 text-center">
                                    @if ($jadwal->hari != $previousDay)
                                        @if ($jadwal->hari == 'Monday')
                                            Senin
                                        @elseif ($jadwal->hari == 'Tuesday')
                                            Selasa
                                        @elseif ($jadwal->hari == 'Wednesday')
                                            Rabu
                                        @elseif ($jadwal->hari == 'Thursday')
                                            Kamis
                                        @elseif ($jadwal->hari == 'Friday')
                                            Jumat
                                        @endif
                                        @php
                                            $previousDay = $jadwal->hari;
                                        @endphp
                                    @endif
                                </td>
                                <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                                <td class="px-3 py-1 text-center">{{ $jadwal->kelas->nama_kelas }}</td>
                                <td class="px-3 py-1 text-center">{{ $jadwal->kelas->matkul->dosen->nama_dosen }}</td>
                                <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                            </tr>
                        @endforeach

                        <!-- Jika Tidak Ada Jadwal -->
                        @if ($jadwals->where('kelas.kode_prodi', $prodi->kode_prodi)->isEmpty())
                            <tr>
                                <td colspan="5" class="px-3 py-2 italic text-center text-gray-500">
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
        function confirmDelete(id, nama_mata_kuliah) {
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
                    @this.call('destroy', id);
                }
            });
        }
    </script>
</div>
