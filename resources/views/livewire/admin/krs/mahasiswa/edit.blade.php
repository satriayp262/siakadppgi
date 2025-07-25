<div>
    <div class="flex justify-between items-center mt-4 ml-4 mb-4">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <a wire:navigate.hover href="{{ route('admin.krs') }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">KHS</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                        <a wire:navigate.hover href="{{ route('admin.krs.mahasiswa', ['NIM' => $NIM]) }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            <span class="text-sm font-medium text-gray-500 ">Detail</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                        <a wire:navigate.hover href="{{ route('admin.krs.edit', ['NIM' => $NIM,'semester'=>$semester]) }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                            <span class="text-sm font-medium text-gray-500 ">Edit</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full mx-2">
        <div wire:loading wire:target="export,destroy,save"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-60">
            <div class="spinner loading-spinner"></div>
        </div>
        <div class="flex md:flex-row flex-col  justify-between mb-4 items-center">
            <h2 class="text-lg  font-bold mb-4">KRS {{ $mahasiswa->nama }} Semester
                {{ $mahasiswa->getSemester($semester) }}</h2>
            <div class="flex space-x-2">
                <button wire:click="export"
                    class="flex items-center pr-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                        viewBox="0 0 48 48">
                        <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path>
                        <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z">
                        </path>
                        <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path>
                        <path fill="#17472a" d="M14 24.005H29V33.055H14z"></path>
                        <g>
                            <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"></path>
                            <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z">
                            </path>
                            <path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"></path>
                            <path fill="#129652" d="M29 24.005H44V33.055H29z"></path>
                        </g>
                        <path fill="#0c7238"
                            d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                        </path>
                        <path fill="#fff"
                            d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                        </path>
                    </svg>
                    Export
                </button>
                <livewire:admin.krs.mahasiswa.create :nim="$NIM" :semester="$semester" />
            </div>
        </div>
        <form wire:submit.prevent="save">
            <table class="min-w-full table-auto border-collapse md:text-[15px] text-[10px]">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-[15px] text-left border">Matkul</th>
                        <th class="px-4 py-2 text-[15px] text-left border">Kelas</th>
                        <th class="px-4 py-2 text-[15px] text-left border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($krsRecords as $index => $item)
                        <tr wire:key="krs-{{ $item['id_krs'] }}">
                            <td class="px-4 py-2 border">
                                <select wire:model="selectedMatkul.{{ $index }}" class="w-full px-2 py-1 border">
                                    <option disabled value="">Pilih Mata Kuliah</option>
                                    @foreach ($matkul as $x)
                                        <option value="{{ $x['id_mata_kuliah'] }}">
                                            {{ $x['nama_mata_kuliah'] . ' (' . $x['dosen']['nama_dosen'] . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-2 border">
                                <select wire:model="selectedKelas.{{ $index }}" class="w-full px-2 py-1 border">
                                    <option disabled value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k['id_kelas'] }}">
                                            {{ $k['nama_kelas'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-2 border">
                                <button type="button"
                                    class="inline-block md:px-4 px-1 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $item['id_krs'] }}', '{{ $item['matkul']['nama_mata_kuliah'] }}')"><svg
                                        class="md:w-6 md:h-6 w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Simpan
                    Edit</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('livewire:navigated', function() {
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
    document.addEventListener('livewire:navigated', function() {
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
    document.addEventListener('livewire:navigated', function() {
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

    function confirmDelete(id, nama_matkul) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus KRS matkul ${nama_matkul}?`,
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
