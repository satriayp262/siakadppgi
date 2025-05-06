<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li>
                        <a wire:navigate.hover  href="{{ route('dosen.berita_acara') }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            Berita Acara
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a wire:navigate.hover  href="{{ route('dosen.berita_acara.detail_matkul', ['id_mata_kuliah' => $matkul->id_mata_kuliah]) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                {{ $matkul->nama_mata_kuliah }}
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $kelas->nama_kelas }} / {{ $kelas->kode_prodi }} /
                                {{ substr($kelas->Semester->nama_semester, 3, 2) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex justify-between">
                <livewire:dosen.berita_acara.create :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
                <input type="text" wire:model.live="search" placeholder="   Search"
                    class="px-2 ml-4 border border-gray-300 rounded-lg">
            </div>
        </div>
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success');
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-2 mx-2 mt-2 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1"
                        onclick="document.getElementById('flash-message').style.display='none'">&times;</button>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Tanggal</th>
                    <th class="px-4 py-2 text-center">Nama Dosen</th>
                    <th class="px-4 py-2 text-center">Mata Kuliah</th>
                    <th class="px-4 py-2 text-center">Materi</th>
                    <th class="px-4 py-2 text-center">Jumlah Mahasiswa</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if ($this->CheckDosen) --}}
                    @foreach ($beritaAcara as $acara)
                        <tr wire:key="berita_acara-{{ $acara->id_berita_acara }}">
                            <td class="px-4 py-2 text-center">
                                {{ ($beritaAcara->currentPage() - 1) * $beritaAcara->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($acara->tanggal)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-2 text-center">{{ $acara->dosen->nama_dosen }}</td>
                            <td class="px-4 py-2 text-center">{{ $acara->matakuliah->nama_mata_kuliah }}</td>
                            <td class="px-4 py-2 text-center">{{ $acara->materi }}</td>
                            <td class="px-4 py-2 text-center">{{ $acara->jumlah_mahasiswa }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex flex-col">
                                    <div class="flex justify-center space-x-2">
                                        <livewire:dosen.berita_acara.edit :id_berita_acara="$acara->id_berita_acara"
                                            wire:key="edit-{{ $acara->id_berita_acara }}" />
                                        <button
                                            class="inline-block px-4 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                            wire:key="delete-{{ $acara->id_berita_acara }}"
                                            onclick="confirmDelete('{{ $acara->id_berita_acara }}')">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                {{-- @else
                    <tr>
                        <td colspan="7" class="px-2 py-4 text-center">Belum ada Berita Acara</td>
                    </tr>
                @endif --}}
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">
            {{ $beritaAcara->links() }}
        </div>
    </div>
</div>

<script>
    function confirmDelete(id_berita_acara) {
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus Berita Acara ini?',
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', id_berita_acara);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const events = ['updated', 'created', 'destroyed'];
        events.forEach(eventType => {
            window.addEventListener(eventType, event => {
                Swal.fire({
                    title: 'Success!',
                    text: event.detail.params.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });
    });
</script>
