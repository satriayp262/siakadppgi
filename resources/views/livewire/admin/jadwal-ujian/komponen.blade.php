<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        {{-- <h1 class="text-2xl font-bold ">Prodi Table</h1> --}}
        <!-- Modal Form -->
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
            @endif
        </div>
    </div>

    <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">Nama</th>
                    <th class="px-4 py-2 text-center">Jabatan</th>
                    <th class="px-4 py-2 text-center">TTD</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($komponen as $f)
                    <tr class="border-t">
                        <td class="px-3 py-1 text-center">{{ $f->nama }}</td>
                        <td class="px-3 py-1 text-center">{{ $f->jabatan }}</td>
                        @if ($f->ttd == null)
                            <td class="px-3 py-1 text-center">Kosong</td>
                        @else
                            <td class="px-3 py-1 text-center">
                                <img src="{{ asset('storage/' . $f->ttd) }}" alt="Tanda Tangan"
                                    class="h-12 mx-auto">
                            </td>
                        @endif
                        <td class="px-3 py-1 text-center">
                            <livewire:admin.jadwal-ujian.komponen-edit :id_komponen="$f->id_komponen"
                                           wire:key="update-{{ $f->id_komponen }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>

    </script>
</div>
