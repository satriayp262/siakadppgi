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
        <button wire:click="generate" class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
            Generate Jadwal
        </button>
        <button wire:click='destroy' class='flex items-center px-4 py-2 ml-2 font-bold text-white bg-red-500 rounded hover:bg-red-700'>
            Hapus Jadwal
        </button>
    </div>
    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <table class="w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">Kelas</th>
                    <th class="px-3 py-2 text-center">Dosen</th>
                    <th class="px-3 py-2 text-center">Hari</th>
                    <th class="px-3 py-2 text-center">Sesi</th>
                    <th class="px-3 py-2 text-center">Ruangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwals as $jadwal)
                    <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                        <td class="px-3 py-1 text-center">{{ $jadwal->kelas->nama_kelas }}</td>
                        <td class="px-3 py-1 text-center">{{ $jadwal->kelas->matkul->dosen->nama_dosen }}</td>
                        <td class="px-3 py-1 text-center">
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
                        </td>
                        <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                        <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
