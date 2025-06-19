<div class="">
    <div wire:loading wire:target="addRow,save"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
        <div class="spinner loading-spinner"></div>
    </div>
    <nav aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse px-2 mt-7 mb-6 mx-7">
            <li aria-current="page">
                <div class="flex items-center">
                    <a wire:navigate.hover href="{{ route('admin.paketkrs') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Paket KRS</span>
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </a>
                    <a wire:navigate.hover href="{{ route('admin.paketkrs.create') }}"
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
    <div class="shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-6xl mx-5">
        <div class="p-6 bg-white shadow-md rounded-lg max-w-6xl mx-auto space-y-6">
            <!-- Semester and Prodi -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="semester" class="block text-sm font-semibold mb-1">Pilih Semester:</label>
                    <select wire:model="selectedSemester" class="w-full px-3 py-2 border rounded">
                        <option value="">-- Pilih Semester --</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id_semester }}">{{ $semester->nama_semester }}</option>
                        @endforeach
                    </select>
                    @error('selectedSemester')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="kode_prodi" class="block text-sm font-semibold mb-1">Pilih Kode Prodi:</label>
                    <select wire:model.live="selectedKodeProdi" class="w-full px-3 py-2 border rounded">
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

            <!-- Tanggal -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-semibold mb-1">Tanggal Mulai:</label>
                    <input type="date" wire:model="tanggal_mulai" class="w-full px-3 py-2 border rounded">
                    @error('tanggal_mulai')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-semibold mb-1">Tanggal Selesai:</label>
                    <input type="date" wire:model="tanggal_selesai" class="w-full px-3 py-2 border rounded">
                    @error('tanggal_selesai')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Kelas + Button -->
            <div class="grid md:grid-cols-2 gap-4 items-end">
                <div>
                    <label for="kelas" class="block text-sm font-semibold mb-1">Pilih Kelas:</label>
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
            </div>
        </div>

        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full ">
            <div>
                <button type="button" wire:click="addRow"
                    class="bg-green-600 text-white p-2 rounded hover:bg-green-700">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor"
                            stroke-width="2" />
                        <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor"
                            stroke-width="2" />
                    </svg>
                </button>
            </div>
            <table class="min-w-full table-auto border-collapse mt-4">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-black text-left border">Mata Kuliah</th>
                        <th class="px-4 py-2 text-black text-left border w-12 md:w-36">Aksi</th>
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
                            <td class="px-2 py-2 border text-center w-12 md:w-36">
                                <button type="button" wire:click="removeRow({{ $index }})"
                                    class="p-1 bg-red-500 text-white rounded hover:bg-red-700" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
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
    document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('updatedPaketKRS', message => {
        Swal.fire({
            title: 'Success!',
            text: message,
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
