<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 ">
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
                    class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white {{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    {{-- <button id="copyToken" class="ml-4 bg-white text-black px-2 rounded" onclick="copyToken()">Salin</button> --}}
                    <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'">
                        &times;
                    </button>
                </div>
            @endif
            {{-- <script>
                function copyToken() {
                    // Ambil teks token dari elemen dengan ID 'tokenMessage'
                    const tokenText = document.getElementById('tokenMessage').innerText.replace('Token berhasil dibuat: ', '');
                    navigator.clipboard.writeText(tokenText).then(() => {
                        alert('Token berhasil disalin ke clipboard!');
                    }).catch(err => {
                        console.error('Gagal menyalin: ', err);
                    });
                }
            </script> --}}
        </div>
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:dosen.presensi.create-token />
            <div class="flex space-x-4">
                <input type="date" wire:model="date" class="border p-2 rounded" />
                <select wire:model="matkulId" class="border p-2 rounded">
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach ($matkul as $matkul)
                        <option value="{{ $matkul->kode_mata_kuliah }}">{{ $matkul->nama_mata_kuliah }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>

        <div class="flex justify-between mt-2">
            <div class="flex space-x-2 items-center">
                <h1 class="text-md font-bold text-gray-900">
                    Token:
                </h1>
                <span class="text-md font-bold text-purple-500">
                    {{ $tokenTerbaru->token ?? 'Belum ada token' }}
                </span>
                <button
                    class="ml-4 px-3 py-1 border border-gray-300 bg-gray-100 text-black rounded hover:bg-gray-200"
                    onclick="copyToClipboard('{{ $tokenTerbaru->token ?? '' }}')"
                    {{ $tokenTerbaru ? '' : 'disabled' }}>
                    Salin Token
                </button>
            </div>
        </div>

        <script>
            function copyToClipboard(token) {
                if (token) {
                    const el = document.createElement('textarea');
                    el.value = token;
                    document.body.appendChild(el);
                    el.select();
                    document.execCommand('copy');
                    document.body.removeChild(el);

                    alert('Token telah disalin: ' + token);
                } else {
                    alert('Tidak ada token untuk disalin');
                }
            }
        </script>
    </div>

    <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
        <thead>
            <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                <th class="px-4 py-2 text-center">No</th>
                <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                <th class="px-4 py-2 text-center">NIM</th>
                <th class="px-4 py-2 text-center">Mata Kuliah</th>
                <th class="px-4 py-2 text-center">Waktu</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($presensis as $presensi) --}}
            <tr>
                {{-- <td class="border px-2 py-1">{{ $presensi->users->name}}</td>
                    <td class="border px-2 py-1">{{ $presensi->mahasiswa->nim }}</td>
                    <td class="border px-2 py-1">{{ $presensi->matkul->name }}</td>
                    <td class="border px-2 py-1">{{ $presensi->submitted_at }}</td> --}}
            </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>
</div>
