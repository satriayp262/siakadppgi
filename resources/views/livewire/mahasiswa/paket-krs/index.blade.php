<div class="py-1 mx-5">
    <div class="">
        @php
            // $mahasiswa = App\Models\Mahasiswa::where('NIM', auth()->user()->nim_nidn)->first();
            // $maxSemester = App\Models\Semester::orderByDesc('nama_semester')->first()->nama_semester;
            $krsThisSemester = App\Models\KRS::where('id_semester', $semester->id_semester)
                ->where('NIM', auth()->user()->nim_nidn)
                ->exists();

        @endphp
        @if ($paketKRS)
            @if (
                $paketKRS->first()->tanggal_mulai < Carbon\Carbon::now('Asia/Bangkok')->toDateString() &&
                    $paketKRS->first()->tanggal_selesai > Carbon\Carbon::now('Asia/Bangkok')->toDateString())
                <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg ">
                    <div class="flex items-center justify-between my-2">
                        <h2>Semester {{ $mahasiswa->getSemester($semester->id_semester) }}</h2>
                        @if ($krsThisSemester)
                            <a class="px-3 py-2 font-bold text-white bg-blue-500 rounded">
                                Diajukan</a>
                        @else
                            <button wire:click="create({{ $semester->id_semester }})"
                                class="px-3 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                                Ajukan</button>
                        @endif
                    </div>
                    <div class="my-4" wire:key="semester-{{ $semester->id_semester }}">
                        <table class="min-w-full border-collapse table-auto md:text-[15px] text-[6px]">
                            <thead>
                                <tr class="items-center w-full text-white align-middle bg-customPurple">
                                    <th class="px-2 py-1 text-center border">Matkul</th>
                                    <th class="px-2 py-1 text-center border">Dosen</th>
                                    <th class="px-2 py-1 text-center border">Kelas</th>
                                    <th class="px-2 py-1 text-center border">SKS Tatap Muka</th>
                                    <th class="px-2 py-1 text-center border">SKS Praktek</th>
                                    <th class="px-2 py-1 text-center border">SKS Praktek Lapangan</th>
                                    <th class="px-2 py-1 text-center border">SKS Simulasi</th>
                                    <th class="px-2 py-1 text-center border">Jenis Mata Kuliah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paketKRS as $item)
                                    <tr wire:key="krs-{{ $item->id_krs }}">
                                        <td class="px-2 py-1 text-center border">
                                            {{ $item->matkul->nama_mata_kuliah }}</td>
                                        <td class="px-2 py-1 text-center border">
                                            {{ $item->matkul->dosen->nama_dosen }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->kelas->nama_kelas }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->sks_tatap_muka }}
                                        </td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->sks_praktek }}
                                        </td>
                                        <td class="px-2 py-1 text-center border">
                                            {{ $item->matkul->sks_praktek_lapangan }}</td>
                                        <td class="px-2 py-1 text-center border">{{ $item->matkul->sks_simulasi }}
                                        </td>
                                        <td class="px-2 py-1 text-center border">
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
                </div>
            @else
                <div class="w-full flex items-center justify-center mt-20 text-[25px] font-bold">
                    <p>Masa Pengajuan dimulai pada
                        {{ \Carbon\Carbon::parse($paketKRS->first()->tanggal_mulai)->format('d/m/Y') }} dan
                        berakhir pada
                        {{ \Carbon\Carbon::parse($paketKRS->first()->tanggal_selesai)->format('d/m/Y') }}</p>

                </div>
            @endif
        @else
            <div class="w-full flex items-center justify-center mt-20 text-[25px] font-bold">
                <p>Belum ada paket KRS </p>
            </div>
        @endif
    </div>
    <script>
        function confirm() {
            Swal.fire({
                title: `Apakah anda yakin untuk mengajukan KRS ini?`,
                text: "Aksi ini tidak bisa di batalkan!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Ajukan'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('create');
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('asd', event => {
                console.log(event.detail)
                Swal.fire({
                    title: 'Success!',
                    text: event.detail[0],
                    icon: 'success',
                }).then(() => {
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });
    </script>
