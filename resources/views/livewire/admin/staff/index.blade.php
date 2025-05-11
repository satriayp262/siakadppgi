<div class="mx-5">
    <div class="flex flex-col justify-between mt-2">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:admin.staff.create />
            {{-- <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg"> --}}
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
        <div class="justify-between flex items-center mr-2">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold text-customPurple">Daftar Staff Bagian Keuangan</h1>
                <p class="text-sm text-gray-500">Halaman ini ditunjukan untuk melihat daftar staff bagian
                    keuangan
                    PPGI</p>
                </p>
            </div>
        </div>
        @livewire('table.daftar-staf-table')
        {{-- <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Nama Staff</th>
                    <th class="px-4 py-2 text-center">Email</th>
                    <th class="px-4 py-2 text-center">NIP</th>
                    <th class="px-4 py-2 text-center">Tanda Tangan</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staff as $staff1)
                    <tr class="border-t" wire:key="staff-{{ $staff1->id_staff }}">
                        <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-center">{{ $staff1->nama_staff }}</td>
                        <td class="px-4 py-2 text-center">{{ $staff1->email }}</td>
                        <td class="px-4 py-2 text-center">{{ $staff1->nip }}</td>
                        <td class="px-4 py-2 text-center">
                            <img src="{{ asset('storage/image/ttd/' . $staff1->ttd) }}" alt="Tanda Tangan"
                                class="h-12 mx-auto">
                        </td>
                        <td class=" mt-2 flex justify-center space-x-2"> --}}
        {{-- <livewire:staff.profil.edit :id_staff="$staff1->id_staff" wire:key="edit-{{ $staff1->id_staff }}" /> --}}
        {{-- <button class="inline-block px-4 py-2 text-white bg-red-500 rounded hover:bg-red-700"
                                onclick="confirmDelete('{{ $staff1->id_staff }}', '{{ $staff1->nama_staff }}')"><svg
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
        </table> --}}
    </div>
</div>
<script>
    function confirmDelete(id, nama_staff) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus Staff ${nama_staff}?`,
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
