<div class="">
    <div wire:loading wire:target="addRow,save"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
        <div class="spinner loading-spinner"></div>
    </div>
    <nav aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse px-2 mt-7 mb-6 mx-7">
            <li aria-current="page">
                <div class="flex items-center">
                    <a wire:navigate.hover  href="{{ route('admin.paketkrs') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Paket KRS</span>
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </a>
                    <a wire:navigate.hover  href="{{ route('admin.paketkrs.create') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Create</span>
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </a>
                </div>
            </li>
        </ol>
    </nav>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full mx-5">
        <div class="p-4 bg-white shadow-md rounded-md">
            <!-- Semester Selection -->
            <div class="flex justify-between items-center space-x-2">
                <div class="flex flex-col w-full justify-start">
                    <label for="semester" class="block text-sm font-medium">Pilih Semester:</label>
                </div>

                <div class="flex flex-col w-full justify-start">
                    <label for="kode_prodi" class="block mt-2 text-sm font-medium">Pilih Kode Prodi:</label>
                </div>
            </div>
            <div class="flex justify-between items-center space-x-2">
                <div class="flex flex-col w-full justify-start">
                    <select wire:model="selectedSemester" class="w-full px-2 py-1 border rounded">
                        <option value="">-- Pilih Semester --</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id_semester }}">{{ $semester->nama_semester }}</option>
                        @endforeach
                    </select>
                    @error('selectedSemester')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col w-full justify-start">
                    <select wire:model.live="selectedKodeProdi" class="w-full px-2 py-1 border rounded">
                        <option value="">-- Pilih Kode Prodi --</option>
                        @foreach ($kode_prodi_list as $prodi)
                            <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                    @error('selectedKodeProdi')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Tanggal Mulai & Tanggal Selesai -->
            <div class="mt-2 flex justify-between items-center space-x-2">
                <div class="w-full">
                    <label for="tanggal_mulai" class="block text-sm font-medium">Tanggal Mulai:</label>
                    <input type="date" wire:model="tanggal_mulai" class="w-full px-2 py-1 border rounded">
                    @error('tanggal_mulai')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full">
                    <label for="tanggal_selesai" class="block text-sm font-medium">Tanggal Selesai:</label>
                    <input type="date" wire:model="tanggal_selesai" class="w-full px-2 py-1 border rounded">
                    @error('tanggal_selesai')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex justify-between items-center space-x-2">
                <div class="flex flex-col w-full justify-start">
                    <label for="kelas" class="block mt-2 text-sm font-medium">Pilih Kelas:</label>

                </div>

                <div class="flex flex-col w-full justify-start">
                    <label for="kode_prodi" class="block mt-2 text-sm font-medium"></label>
                </div>
            </div>
            <div class="flex justify-between items-center space-x-2">
                <div class="flex flex-col w-full justify-start">
                    <select wire:model.live="selectedKelas" class="w-full py-1 border rounded">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('selectedKelas')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col w-full justify-start">
                    <button type="button" wire:click="addRow"
                        class="bg-green-500 text-[16px] text-white rounded hover:bg-green-700">Tambah Mata
                        Kuliah</button>
                </div>
            </div>

            <table class="min-w-full table-auto border-collapse mt-4">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border">Mata Kuliah</th>
                        <th class="px-4 py-2 text-left border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paketKrsRecords as $index => $record)
                        <tr wire:key="paket-krs-{{ $index }}">
                            <td class="px-4 py-2 border">
                                <select wire:model.live="paketKrsRecords.{{ $index }}.id_mata_kuliah"
                                    wire:change="handleMatkulChange" class="w-full px-2 py-1 border rounded">
                                    <option value="">-- Pilih Mata Kuliah --</option>
                                    @foreach ($matkul as $nama_mk => $items)
                                        @if (in_array($nama_mk, $selectedKRS))
                                            <optgroup hidden label="{{ $nama_mk }}">
                                                @foreach ($items as $x)
                                                    <option value="{{ $x['id_mata_kuliah'] }}">
                                                        {{ $x['nama_mata_kuliah'] }} - {{ $x['dosen']['nama_dosen'] }}
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <optgroup label="{{ $nama_mk }}">
                                                @foreach ($items as $x)
                                                    <option value="{{ $x['id_mata_kuliah'] }}">
                                                        {{ $x['nama_mata_kuliah'] }} - {{ $x['dosen']['nama_dosen'] }}
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <button type="button" wire:click="removeRow({{ $index }})"
                                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-700">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                @error('paketKrsRecords.*.id_mata_kuliah')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
                @error('paketKrsRecords')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </table>
            <button type="button" wire:click="save"
                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('updatedPaketKRS', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail[0],
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
                window.location.href = '{{ route('admin.paketkrs') }}';
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('warningPaketKRS', event => {
            Swal.fire({
                title: 'Warning!',
                text: event.detail[0],
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
