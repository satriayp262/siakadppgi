<div class="mx-5">
    <div class="flex justify-between mx-4 mt-4 ">
        <!-- Modal Form -->
        <div class="flex justify-between space-x-2 mt-2">
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">
        </div>
        <div class="flex space-x-2">

        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <div class="flex w-full justify-between">
            <div class="flex space-x-2 items-center">
                <p class="text-xl font-bold">KHS Mahasiswa</p>
            </div>

        </div>
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">Nama</th>
                    <th class="px-4 py-2 text-center">NIM</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Semester</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $item)
                    <tr wire:key="mahasiswa-{{ $item->id_mahasiswa }}">
                        <td class="px-4 py-2 text-center">{{ $item->nama }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->NIM }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->prodi->nama_prodi }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->getSemesterDifferenceAttribute() }}</td>
                        <td class="px-4 py-2 text-center">
                                <div class="flex justify-center">
                                    @if (auth()->user()->role == 'dosen')
                                        <a href="{{ route('dosen.khs.detail', ['NIM' => $item->NIM]) }}"
                                            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                                            <p>▶</p>
                                        </a>
                                    @elseif(auth()->user()->role == 'admin')
                                        <a href="{{ route('dosen.khs.detail', ['NIM' => $item->NIM]) }}"
                                            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                                            <p>▶</p>
                                        </a>
                                    @endif
                                </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('updatedKHS', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail[0],
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
