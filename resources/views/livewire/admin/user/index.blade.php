<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="flex justify-between space-x-2">
                <livewire:admin.user.create />
                @if ($showDeleteButton)
                    <button id="deleteButton" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                        onclick="confirmDeleteSelected()">
                        Hapus Data Terpilih
                    </button>
                @endif
            </div>
            <div class="justify-around space-x-2 flex">
                <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500"
                    data-dropdown-trigger="hover"
                    class="text-white bg-purple2 hover:bg-customPurple font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                    type="button"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M5.05 3C3.291 3 2.352 5.024 3.51 6.317l5.422 6.059v4.874c0 .472.227.917.613 1.2l3.069 2.25c1.01.742 2.454.036 2.454-1.2v-7.124l5.422-6.059C21.647 5.024 20.708 3 18.95 3H5.05Z" />
                    </svg>

                </button>

                <!-- Dropdown menu -->
                <div id="dropdownDelay" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                    <ul class="py-2 text-sm text-gray-500" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="#" wire:click.prevent="$set('selectedRole', '')"
                                class="block px-4 py-2 hover:bg-gray-100 ">
                                All
                            </a>
                        </li>
                        <li>
                            <a href="#" wire:click.prevent="$set('selectedRole', 'admin')"
                                class="block px-4 py-2 hover:bg-gray-100 ">
                                Admin
                            </a>
                        </li>
                        <li>
                            <a href="#" wire:click.prevent="$set('selectedRole', 'dosen')"
                                class="block px-4 py-2 hover:bg-gray-100 ">
                                Dosen
                            </a>
                        </li>
                        <li>
                            <a href="#" wire:click.prevent="$set('selectedRole', 'mahasiswa')"
                                class="block px-4 py-2 hover:bg-gray-100 ">
                                Mahasiswa
                            </a>
                        </li>
                        <li>
                            <a href="#" wire:click.prevent="$set('selectedRole', 'staff')"
                                class="block px-4 py-2 hover:bg-gray-100 ">
                                Staff
                            </a>
                        </li>
                    </ul>
                </div>
                <input type="text" wire:model.live="search" placeholder="   Search"
                    class="px-2 ml-4 border border-gray-300 rounded-lg">
            </div>
        </div>
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success'); // Default to success
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : (($messageType === 'warning'
                                    ? 'bg-yellow-500'
                                    : $messageType === 'update')
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-2 mx-2 mt-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
                @push('scripts')
                    <script>
                        setTimeout(() => {
                            const flashMessage = document.getElementById('flash-message');
                            if (flashMessage) {
                                flashMessage.remove();
                            }
                        }, 1000); // Adjust the time (in milliseconds) as needed
                    </script>
                @endpush
            @endif
        </div>
    </div>

    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="py-2 px-4"><input type="checkbox" id="selectAll" wire:model="selectAll"></th>
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Nama</th>
                    <th class="px-4 py-2 text-center">Email</th>
                    <th class="px-4 py-2 text-center">Role</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t" wire:key="user-{{ $user->id }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" class="selectRow" wire:model.live="selectedUser"
                                value="{{ $user->id }}">
                        </td>
                        <td class="px-4 py-2 text-center">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td class="w-1/4 px-4 py-2 text-center">{{ $user->name }}</td>
                        <td class="w-1/4 px-4 py-2 text-center">{{ $user->email }}</td>
                        <td class="w-1/4 px-4 py-2 text-center">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-blue-500 ',
                                    'dosen' => 'bg-indigo-400',
                                    'mahasiswa' => 'bg-pink-400',
                                    'staff' => 'bg-purple3',
                                ];
                                $roleColor = $roleColors[$user->role] ?? 'bg-gray-500';
                            @endphp
                            <span class="px-2 py-1 text-xs text-white rounded {{ $roleColor }}" style="width: 80px;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="w-1/2 px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <livewire:admin.user.edit :id="$user->id" wire:key="edit-{{ $user->id }}" />
                                <button class="inline-block px-4 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 mb-4 text-center">
            {{ $users->links('') }}
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus User ${name}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#28a745',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id);
                }
            });
        }

        // Ambil elemen checkbox di header
        const selectAllCheckbox = document.getElementById('selectAll');

        // Ambil semua checkbox di baris
        const rowCheckboxes = document.querySelectorAll('.selectRow');

        // Event listener untuk checkbox di header
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;

            // Iterasi semua checkbox di row dan ubah status checked sesuai header
            rowCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked; // Update status checkbox di baris
            });

            // Jika Anda menggunakan Livewire, Anda bisa memanggil update pada model
            @this.set('selectedUser', isChecked ? [...rowCheckboxes].map(cb => cb.value) : []);
        });

        function confirmDeleteSelected() {
            const selectedUser = @this.selectedUser; // Dapatkan data dari Livewire

            console.log(selectedUser); // Tambahkan log untuk memeriksa nilai

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${selectedUser.length} data User?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil method Livewire untuk menghapus data terpilih
                    @this.call('destroySelected');
                }
            });
        }
    </script>
</div>
