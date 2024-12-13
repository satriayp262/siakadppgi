<div class="mx-5">
    <div class="flex flex-col justify-between mt-2">
        <!-- Modal Form -->
        <div class="justify-end space-x-2 flex mt-2">
            <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500"
                data-dropdown-trigger="hover"
                class="text-white bg-purple2 hover:bg-customPurple font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                type="button"><svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M5.05 3C3.291 3 2.352 5.024 3.51 6.317l5.422 6.059v4.874c0 .472.227.917.613 1.2l3.069 2.25c1.01.742 2.454.036 2.454-1.2v-7.124l5.422-6.059C21.647 5.024 20.708 3 18.95 3H5.05Z" />
                </svg>

            </button>

            <!-- Dropdown menu -->
            <div id="dropdownDelay" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                <ul class="py-2 text-sm text-gray-500" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown"
                            data-dropdown-delay="500" data-dropdown-trigger="hover"
                            data-dropdown-placement="right-start" type="button"
                            class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                            @if ($selectedSemester)
                                {{ $selectedSemester }}
                            @else
                                Semester
                            @endif
                            <svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </button>
                        <div id="doubleDropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton">
                                <li>
                                    <a href="#" wire:click.prevent="$set('selectedSemester', '')"
                                        class="block px-4 py-2 hover:bg-gray-100">All</a>
                                </li>
                                @foreach ($semesters as $semester)
                                    <li>
                                        <a href="#"
                                            wire:click.prevent="$set('selectedSemester', '{{ $semester->nama_semester }}')"
                                            class="block px-4 py-2 hover:bg-gray-100 ">{{ $semester->nama_semester }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>

                </ul>
                <ul class="py-2 text-sm text-gray-500" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <button id="doubleDropdownButton2" data-dropdown-toggle="doubleDropdown2"
                            data-dropdown-delay="500" data-dropdown-trigger="hover"
                            data-dropdown-placement="right-start" type="button"
                            class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                            @if ($selectedprodi)
                                {{ $selectedprodi }}
                            @else
                                Prodi
                            @endif
                            <svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </button>
                        <div id="doubleDropdown2"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton2">
                                <li>
                                    <a href="#" wire:click.prevent="$set('selectedprodi', '')"
                                        class="block px-4 py-2 hover:bg-gray-100">All</a>
                                </li>
                                @foreach ($Prodis as $prodi)
                                    <li>
                                        <a href="#"
                                            wire:click.prevent="$set('selectedprodi', '{{ $prodi->nama_prodi }}')"
                                            class="block px-4 py-2 hover:bg-gray-100 ">{{ $prodi->nama_prodi }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                        <th class="px-4 py-2 text-center">No.</th>
                        <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                        <th class="px-4 py-2 text-center">NIM</th>
                        <th class="px-4 py-2 text-center">Angkatan</th>
                        <th class="px-4 py-2 text-center">Prodi</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswas as $mahasiswa)
                        <tr class="border-t" wire:key="mahasiswa-{{ $mahasiswa->NIM }}">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                            <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                            <td class="px-4 py-2 text-center">{{ $mahasiswa->semester->nama_semester }}</td>
                            <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                            <!-- Button that opens the detail component -->
                            <td class="px-4 py-2 text-center">
                                <button onclick="window.location='{{ route('staff.detail', $mahasiswa->NIM) }}'"
                                    class="px-3 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-600"><svg
                                        class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">
            {{ $mahasiswas->links() }}
        </div>
        <script>
            function isMovingToDropdown(event) {
                const target = event.relatedTarget; // Elemen tujuan kursor
                return target && (target.closest('.relative') !== null);
            }
        </script>
