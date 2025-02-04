<div class="mx-5">
    <div class="flex flex-col justify-between mt-2">
        <!-- Modal Form -->
        <div class="flex justify-end space-x-2 mt-2">
            <div class="flex items-start mr-auto">
                @if ($showUpdateButton)
                    <button id="deleteButton"
                        class="flex items-center px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                        onclick="createTagihan()">
                        <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white font-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                        Tambah
                    </button>
                @else
                    <livewire:staff.tagihan.group-create />
                @endif
            </div>
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
                            data-dropdown-delay="500" data-dropdown-placement="right-start" type="button"
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
                            data-dropdown-delay="500" data-dropdown-placement="right-start" type="button"
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
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success'); // Default to success
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-2 mx-2 mt-2 text-white{{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-4 bg-white border border-gray-200 ">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
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
                    <tr class="odd:bg-white  even:bg-gray-100 border-t"
                        wire:key="mahasiswa-{{ $mahasiswa->id_mahasiswa }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" class="selectRow" wire:model.live="selectedMahasiswa"
                                value="{{ $mahasiswa->id_mahasiswa }}">
                        </td>
                        <td class="px-4 py-2 text-center ">
                            {{ ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->semester->nama_semester }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                        <td class="px-4 py-2 text-center justify-items-center">
                            <livewire:staff.tagihan.create :nim="$mahasiswa->NIM" :nama="$mahasiswa->nama"
                                wire:key="edit-{{ $mahasiswa->NIM }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">

            {{ $mahasiswas->links('') }}
        </div>
    </div>

</div>
<script>
    // Ambil elemen checkbox di header
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.selectRow');

    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;

        rowCheckboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });

        @this.set('selectedMahasiswa', isChecked ? [...rowCheckboxes].map(cb => cb.value) : []);
    });

    rowCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            @this.set('selectedMahasiswa', [...rowCheckboxes].filter(cb => cb.checked).map(cb => cb
                .value));
        });
    });


    function createTagihan() {
        const selectedMahasiswa = @this.get('selectedMahasiswa');

        if (selectedMahasiswa.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada data yang dipilih!',
                text: 'Silakan pilih data yang ingin dihapus terlebih dahulu.',
            });
            return;
        }
        @this.call('createTagihan', selectedMahasiswa);
    }
</script>
