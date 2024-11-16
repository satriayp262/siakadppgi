<div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full mx-2">
    <div class="flex justify-between mb-4 items-center">
        <h2 class="text-lg  font-bold mb-4">Edit KRS {{ $mahasiswa->nama }} Semester {{ $semester }}</h2>
        <livewire:admin.krs.mahasiswa.create :nim="$NIM" :semester="$semester" />
    </div>
    <form wire:submit.prevent="save">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-[15px] text-left border">Matkul</th>
                    <th class="px-4 py-2 text-[15px] text-left border">Dosen</th>
                    <th class="px-4 py-2 text-[15px] text-left border">Kelas</th>
                    <th class="px-4 py-2 text-[15px] text-left border">Nilai Huruf</th>
                    <th class="px-4 py-2 text-[15px] text-left border">Nilai Indeks</th>
                    <th class="px-4 py-2 text-[15px] text-left border">Nilai Angka</th>
                    <th class="px-4 py-2 text-[15px] text-left border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($krsRecords as $index => $item)
                    <tr wire:key="krs-{{ $item['id_krs'] }}">
                        <td class="px-4 py-2 border">{{ $item['matkul']['nama_mata_kuliah'] }}</td>
                        <td class="px-4 py-2 border">{{ $item['matkul']['dosen']['nama_dosen'] }}</td>
                        <td class="px-4 py-2 border">
                            <select wire:model="selectedKelas.{{ $index }}" class="w-full px-2 py-1 border">
                                <option disabled value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k['id_kelas'] }}">
                                        {{ $k['nama_kelas'] }}
                                        ({{ $k['matkul']['dosen']['nama_dosen'] ?? 'Tidak Ada Dosen' }})
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="px-4 py-2 border">
                            <input type="text" wire:model="krsRecords.{{ $index }}.nilai_huruf"
                                class="w-24 px-2 py-1 border">
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="text" wire:model="krsRecords.{{ $index }}.nilai_index"
                                class="w-24 px-2 py-1 border">
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="number" wire:model="krsRecords.{{ $index }}.nilai_angka"
                                class="w-24 px-2 py-1 border">
                        </td>
                        <td class="px-4 py-2 border">
                            <button type="button" class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                onclick="confirmDelete('{{ $item['id_krs'] }}', '{{ $item['kelas']['nama_kelas'] }}')"><svg
                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('updatedKRS', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail[0],
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('warningKRS', event => {
            Swal.fire({
                title: 'Warning',
                text: event.detail[0],
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('destroyedKRS', event => {
            Swal.fire({
                title: 'Warning',
                text: event.detail[0].message,
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });

    function confirmDelete(id, nama_kelas) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus KRS kelas ${nama_kelas}?`,
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
</script>
