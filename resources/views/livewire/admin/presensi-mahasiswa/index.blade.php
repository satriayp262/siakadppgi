<div class="mx-5">
    <div class="flex justify-between mb-4 mt-4 items-center mx-4">
        <button wire:click="exportExcel"
            class="flex items-center py-2 pr-4 font-bold text-white bg-green-500 rounded hover:bg-green-700">
            <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 48 48">
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

        <div class="flex justify-between items-center space-x-4">
            <div class="flex justify-end">
                <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500"
                    data-dropdown-trigger="hover"
                    class="text-white bg-purple2 hover:bg-customPurple font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                    type="button">
                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M5.05 3C3.291 3 2.352 5.024 3.51 6.317l5.422 6.059v4.874c0 .472.227.917.613 1.2l3.069 2.25c1.01.742 2.454.036 2.454-1.2v-7.124l5.422-6.059C21.647 5.024 20.708 3 18.95 3H5.05Z" />
                    </svg>
                </button>

                <div id="dropdownDelay" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                    <!-- Dropdown untuk Bulan -->
                    <ul class="py-2 text-sm text-gray-500" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <button id="semesterDropdownButton" data-dropdown-toggle="semesterDropdown"
                                data-dropdown-delay="500" data-dropdown-trigger="hover"
                                data-dropdown-placement="right-start" type="button"
                                class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                                @if ($semester)
                                    Semester {{ $semester }}
                                @else
                                    Pilih Semester
                                @endif
                                <svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </button>
                            <div id="semesterDropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="semesterDropdownButton">
                                    <li>
                                        <a href="#" wire:click.prevent="$set('semester', '')"
                                            class="block px-4 py-2 hover:bg-gray-100">Semua Semester</a>
                                    </li>
                                    @foreach ($semesters as $s)
                                        <li>
                                            <a href="#"
                                                wire:click.prevent="$set('semester', {{ $s->id_semester }})"
                                                class="block px-4 py-2 hover:bg-gray-100">
                                                Semester {{ $s->nama_semester }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>

                    <!-- Dropdown untuk Program Studi -->
                    <ul class="py-2 text-sm text-gray-500" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <button id="prodiDropdownButton" data-dropdown-toggle="prodiDropdown"
                                data-dropdown-delay="500" data-dropdown-trigger="hover"
                                data-dropdown-placement="right-start" type="button"
                                class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                                @if ($selectedProdi)
                                    {{ $prodi->firstWhere('kode_prodi', $selectedProdi)->nama_prodi }}
                                @else
                                    Program Studi
                                @endif
                                <svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </button>
                            <div id="prodiDropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="prodiDropdownButton">
                                    <li>
                                        <a href="#" wire:click.prevent="$set('selectedProdi', '')"
                                            class="block px-4 py-2 hover:bg-gray-100">All</a>
                                    </li>
                                    @foreach ($prodi as $item)
                                        <li>
                                            <a href="#"
                                                wire:click.prevent="$set('selectedProdi', '{{ $item->kode_prodi }}')"
                                                class="block px-4 py-2 hover:bg-gray-100">
                                                {{ $item->nama_prodi }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Search Input -->
            <div class="ml-4 flex items-center">
                <input type="text" wire:model.debounce.500ms="search" placeholder="Search"
                    class="px-2 py-2 border border-gray-300 rounded-lg shadow-md">
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                    <th class="px-4 py-2 text-center">NIM</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Keterangan</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($dataMahasiswa->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                            Data mahasiswa tidak tersedia.
                        </td>
                    </tr>
                @else
                    @foreach ($dataMahasiswa as $index => $mahasiswa)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-center">
                                {{ ($dataMahasiswa->currentPage() - 1) * $dataMahasiswa->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                            <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                            <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                            <td class="px-4 py-2 text-center">
                                Alpha: {{ $mahasiswa->alpha_count }},
                                Ijin: {{ $mahasiswa->ijin_count }},
                                Sakit: {{ $mahasiswa->sakit_count }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                @php
                                    $sudahKirim = \App\Models\RiwayatSP::where('nim', $mahasiswa->NIM)->exists();
                                @endphp
                                @if (!$sudahKirim)
                                    <button class="py-2 px-4 bg-blue-500 text-white hover:bg-blue-700 rounded"
                                        wire:click="kirimEmail({{ $mahasiswa->NIM }})">
                                        Kirim SP
                                    </button>
                                @else
                                    <button class="py-2 px-4 bg-gray-400 text-white rounded" disabled>
                                        Kirim SP
                                    </button>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4 mb-4 text-center">
            {{ $dataMahasiswa->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah tombol sudah dikirim berdasarkan localStorage
        document.querySelectorAll('button[id^="sp-btn-"]').forEach(function(button) {
            const nim = button.id.replace('sp-btn-', '');
            if (localStorage.getItem('sp_sent_' + nim)) {
                button.disabled = true;
                button.classList.remove('bg-blue-500', 'hover:bg-blue-700');
                button.classList.add('bg-gray-400');
            }
        });
    });

    function disableButton(nim) {
        // Simpan status di localStorage
        localStorage.setItem('sp_sent_' + nim, true);

        // Disable tombol langsung
        const button = document.getElementById('sp-btn-' + nim);
        button.disabled = true;
        button.classList.remove('bg-blue-500', 'hover:bg-blue-700');
        button.classList.add('bg-gray-400');
    }
</script>
