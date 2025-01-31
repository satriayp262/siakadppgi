<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">E-Presensi</span>
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </div>
                    </li>
                </ol>
            </nav>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 py-2 border border-gray-300 rounded-lg">
        </div>
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success');
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-2 mx-2 mt-2 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1"
                        onclick="document.getElementById('flash-message').style.display='none'">&times;</button>
                </div>
            @endif
        </div>
    </div>
    <div class="mt-4 text-center">
        {{ $presensiByMatkul->links() }}
        @forelse ($presensiByMatkul as $index => $presensi)
            <div class="bg-white shadow-lg p-4 mb-4 rounded-lg max-w-full">
                <div class="flex flex-row justify-between">
                    <div class="flex flex-col items-start">
                        <span class="text-2xl font-bold text-purple2">{{ $presensi->nama_mata_kuliah }}</span>
                        <span class="text-sm font-bold text-gray-400">Kode Mata Kuliah :
                            {{ $presensi->kode_mata_kuliah }}</span>
                    </div>
                    <div class="flex justify-center space-x-2 py-2">
                        <a href=" {{ route('dosen.presensiByKelas', ['id_mata_kuliah' => $presensi->id_mata_kuliah]) }}"
                            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                            <p class="text-white">▶</p>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-2 text-center">Tidak ada data mata kuliah.</td>
            </tr>
        @endforelse
    </div>

</div>
