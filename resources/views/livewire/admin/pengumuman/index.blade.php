<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-2">

        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.pengumuman.create />
            </div>
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
                <button class="p-1 font-bold text-white"
                    onclick="document.getElementById('flash-message').style.display='none'">
                    &times;
                </button>
            </div>
        @endif
    </div>
    <div>
        @if (session()->has('message2'))
            @php
                $messageType = session('message_type2', 'warning');
                $bgColor =
                    $messageType === 'error'
                        ? 'bg-red-500'
                        : ($messageType === 'warning'
                            ? 'bg-yellow-500'
                            : 'bg-green-500');
            @endphp
            <div id="flash-message"
                class="flex items-center justify-between p-2 mx-2 mt-4 text-white {{ $bgColor }} rounded">
                <span>{!! session('message2') !!}</span>
                <button class="p-1 font-bold text-white" onclick="document.getElementById('flash-message').remove();">
                    &times;
                </button>
            </div>
        @endif
    </div>

    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <livewire:table.pengumuman-table />
        {{-- <table class="w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">No</th>
                    <th class="px-3 py-2 text-center">Judul Pengumuman</th>
                    <th class="px-3 py-2 text-center">Deskripsi</th>
                    <th class="px-3 py-2 text-center">Image</th>
                    <th class="px-3 py-2 text-center">File</th>
                    <th class="px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengumuman as $item)
                    <tr class="border-t" wire:key="item-{{ $item->id_pengumuman }}">
                        <td class="px-3 py-1 text-center">{{ $loop->iteration }}</td>
                        <td class="px-3 py-1 text-center">{{ $item->title }}</td>
                        <td class="px-3 py-1 text-center">{{ \Illuminate\Support\Str::words($item->desc, 5) }}</td>
                        <td class="px-3 py-1 text-center items-center justify-around flex"><img class="h-18 w-36"
                                src="{{ asset('storage/image/pengumuman/' . $item->image) }}" alt=""></td>
                        <td class="px-3 py-1 text-center">
                            @if ($item->file)
                                <a wire:navigate.hover  href="{{ asset('storage/file/pengumuman/' . $item->file) }}" target="_blank"
                                    class="text-purple2 hover:underline">
                                    {{ $item->title }}.pdf
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-3 py-1 text-center items-center">
                            <div class="flex flex-row">
                                <div class="flex justify-around space-x-2">
                                    <livewire:admin.pengumuman.detail :id_pengumuman="$item->id_pengumuman"
                                        wire:key="selengkapnya-{{ rand() . $item->id_pengumuman }}" />
                                    <livewire:admin.pengumuman.edit :id_pengumuman="$item->id_pengumuman"
                                        wire:key="edit-{{ $item->id_pengumuman }}" />
                                    <button
                                        class="inline-block px-3 py-2 ml-2 text-white bg-red-500 rounded hover:bg-red-700"
                                        onclick="confirmDelete({{ $item->id_pengumuman }}, '{{ $item->title }}')">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
        <!-- Pagination Controls -->
        {{-- <div class="mt-4 mb-4 text-center">
            {{ $pengumuman->links('') }}
        </div> --}}
    </div>
    <script>
        function confirmDelete(id, title) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Pengumuman  "${title}" ?`,
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
        window.addEventListener('bulkDelete.alert.pengumuman-table-evxe2o-table', (event) => {
            const ids = event.detail[0].ids;

            if (!ids || ids.length === 0) return;

            Swal.fire({
                title: `Apakah anda yakin ingin menghapus ${ids.length} data pengumuman?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroySelected', ids);
                }
            });
        });
    </script>
</div>
