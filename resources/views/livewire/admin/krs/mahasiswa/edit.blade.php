<div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full mx-2">
    <h2 class="text-lg font-bold mb-4">Edit KRS {{ $mahasiswa->nama }} Semester {{ $semester }}</h2>
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
                </tr>
            </thead>
            <tbody>
                @foreach ($krsRecords as $index => $item)
                    <tr wire:key="krs-{{ $item['id_krs'] }}">
                        <td class="px-4 py-2 border">{{ $item['matkul']['nama_mata_kuliah'] }}</td>
                        <td class="px-4 py-2 border">{{ $item['matkul']['dosen']['nama_dosen'] }}</td>
                        <td class="px-4 py-2 border">{{ $item['kelas']['nama_kelas'] }}</td>
                        <td class="px-4 py-2 border">
                            <input type="text" wire:model="krsRecords.{{ $index }}.nilai_huruf" class="w-full px-2 py-1 border">
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="text" wire:model="krsRecords.{{ $index }}.nilai_index" class="w-full px-2 py-1 border">
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="number" wire:model="krsRecords.{{ $index }}.nilai_angka" class="w-full px-2 py-1 border">
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
</script>