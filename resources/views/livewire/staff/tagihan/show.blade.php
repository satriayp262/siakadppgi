<div>
    <div class="mx-5">
        <div class="flex flex-col justify-between mt-2">
            <!-- Modal Form -->
            <div class="flex justify-between p-2 mt-2 bg-purple-200 rounded-lg shadow-lg">
                <div class="flex items-center px-4 py-2">
                    <h1><b>Semester Saat ini :</b></h1>
                    <p class="ml-1 text-gray-900 text-md">
                        {{ $semesters->firstWhere('is_active', true)->nama_semester ?? 'Tidak ada semester aktif' }}</p>
                </div>
                <div x-data="{ showFilter: false }" class="relative flex items-center">
                    <!-- Filter Icon with Hover Effect -->
                    <div x-data="{ showFilter: false }" @mouseenter="showFilter = true"
                        @mouseleave="if (!isMovingToDropdown($event)) showFilter = false" class="relative">
                        <div class="relative">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                @if ($filter_tahun || $filter_prodi)
                                    <!-- Icon in Green -->
                                    <path stroke="green" stroke-linecap="round" stroke-width="2"
                                        d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                                @else
                                    <!-- Icon in Black -->
                                    <path stroke="black" stroke-linecap="round" stroke-width="2"
                                        d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                                @endif

                                <!-- Number based on condition -->
                                @if ($filter_tahun && $filter_prodi)
                                    <text x="17" y="20" fill="green" font-size="12" font-weight="bold">
                                        2
                                    </text>
                                @elseif ($filter_tahun)
                                    <text x="17" y="20" fill="green" font-size="12" font-weight="bold">
                                        1
                                    </text>
                                @elseif ($filter_prodi)
                                    <text x="17" y="20" fill="green" font-size="12" font-weight="bold">
                                        1
                                    </text>
                                @endif
                            </svg>
                        </div>
                        <!-- Filter Dropdown -->
                        <div @mouseleave="showFilter = false" x-show="showFilter" x-cloak
                            class="absolute left-0 z-10 w-40 p-2 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="space-y-2">
                                <li>
                                    <label class="flex items-center">
                                        <select name="filter_tahun" id="filter_tahun" wire:model.live="filter_tahun"
                                            class="right-0 block w-full py-2 pl-3 mt-1 text-gray-900 bg-white border border-gray-300 rounded focus:border-indigo-500 focus:ring focus:ring-indigo-500 sm:text-sm">
                                            <option value="" selected>Tahun</option>
                                            @foreach ($semesters as $item)
                                                <option value="{{ $item->id_semester }}">{{ $item->nama_semester }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex items-center">
                                        <select id="filter_prodi" wire:model.live="filter_prodi" name="filter_prodi"
                                            class="right-0 block w-full py-2 pl-3 mt-1 text-gray-900 bg-white border border-gray-300 rounded focus:border-indigo-500 focus:ring focus:ring-indigo-500 sm:text-sm">
                                            <option value="" selected>Prodi</option>
                                            @foreach ($Prodis as $prodi)
                                                <option value="{{ $prodi->kode_prodi }}"> {{ $prodi->nama_prodi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="   Search"
                        class="px-2 ml-4 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                    <th class="px-4 py-2 text-center">NIM</th>
                    <th class="px-4 py-2 text-center">Semester</th>
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
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->semesterDifference }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                        <!-- Button that opens the detail component -->
                        <td class="px-4 py-2 text-center">
                            <button onclick="window.location='{{ route('staff.detail', $mahasiswa->NIM) }}'"
                                class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    </div>
