<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li>
                        <a wire:navigate.hover href="{{ route('dosen.berita_acara') }}"
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
                            <a wire:navigate.hover
                                href="{{ route('dosen.berita_acara.detail_matkul', ['id_mata_kuliah' => $matkul->id_mata_kuliah]) }}"
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
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $kelas->nama_kelas }} /
                                {{ $kelas->kode_prodi }} /
                                {{ substr($kelas->Semester->nama_semester, 3, 2) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex justify-between">
                <livewire:dosen.berita_acara.create :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
            </div>
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <livewire:table.berita-acara-dosen :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
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
            Livewire.on(eventType, (data) => {
                Swal.fire({
                    title: 'Sukses!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });
    });
</script>
