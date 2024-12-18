<div class="mx-5">
    <div class="flex justify-between mx-4 mt-4 ">
        <!-- Modal Form -->
        <div class="flex justify-between space-x-2 mt-2">
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 ml-4 border border-gray-300 rounded-lg">

            <select wire:model.live="prodi"
                class="block w-full px-2 py-2 bg-purple-500 text-white border-purple-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                <option value="" disabled selected>Select</option>
                @foreach ($prodiList as $item)
                    <option value="{{ $item->id_prodi }}">{{ $item->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex space-x-2">

        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <div class="flex w-full justify-between">
            <div class="flex space-x-2 items-center">
                <p class="text-xl font-bold">KHS Mahasiswa</p>
            </div>
            <div class="flex space-x-2">
                <select wire:model="semester"
                    class="block w-full px-2 py-2 bg-amber-500 text-white border-amber-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                    <option value="" disabled selected>Select</option>
                    @foreach ($semesterList as $item)
                        <option value="{{ $item->id_semester }}">{{ $item->nama_semester }}</option>
                    @endforeach
                </select>
                <a wire:click="calculate()"
                    class="px-3 py-3 font-bold text-white bg-amber-500 rounded hover:bg-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M13.5 2c-5.621 0-10.211 4.443-10.475 10h-3.025l5 6.625 5-6.625h-2.975c.257-3.351 3.06-6 6.475-6 3.584 0 6.5 2.916 6.5 6.5s-2.916 6.5-6.5 6.5c-1.863 0-3.542-.793-4.728-2.053l-2.427 3.216c1.877 1.754 4.389 2.837 7.155 2.837 5.79 0 10.5-4.71 10.5-10.5s-4.71-10.5-10.5-10.5z"
                            fill="white" />
                    </svg>
                </a>
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
                            <div class="flex flex-row">
                                <div class="flex justify-center space-x-2">
                                    @if (auth()->user()->role == 'dosen')
                                        <a href="{{ route('dosen.khs.show', ['NIM' => $item->NIM]) }}"
                                            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                                            <p>▶</p>
                                        </a>
                                    @elseif(auth()->user()->role == 'admin')
                                        <a href="{{ route('dosen.khs.show', ['NIM' => $item->NIM]) }}"
                                            class="py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded">
                                            <p>▶</p>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">
            {{ $mahasiswa->links('') }}
        </div>
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
