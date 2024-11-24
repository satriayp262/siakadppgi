<div class="mx-5">
    <div class="flex flex-col justify-between mt-2">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            {{-- <livewire:staff.tagihan.group-create /> --}}
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
                {{-- @foreach ($mahasiswas as $mahasiswa)
                <tr class="border-t" wire:key="mahasiswa-{{ $mahasiswa->id_mahasiswa }}">
                    <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->semester->nama_semester }}</td>
                    <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center justify-items-center">
                        <livewire:staff.tagihan.create :nim="$mahasiswa->NIM" :nama="$mahasiswa->nama"
                            wire:key="edit-{{ $mahasiswa->NIM }}" />
                    </td>
                </tr>
            @endforeach --}}
            </tbody>
        </table>
    </div>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{-- {{ $mahasiswas->links('') }} --}}
    </div>
</div>
