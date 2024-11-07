<div>
    <div class="mx-5">
        <div class="flex flex-col justify-between mt-2">
            <!-- Modal Form -->
            <div class="flex justify-between mt-2 bg-purple-200 shadow-lg rounded-lg p-2">
                <div class="flex items-center px-4 py-2">
                    <h1><b>Semester Saat ini :</b></h1>
                    <p class="text-md text-gray-900 ml-1">
                        {{ $semesters->firstWhere('is_active', true)->nama_semester ?? 'Tidak ada semester aktif' }}</p>
                </div>
                <input type="text" wire:model.live="search" placeholder="   Search"
                    class="px-2 ml-4 border border-gray-300 rounded-lg">
            </div>
        </div>
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">No.</th>
                    <th class="px-4 py-2 text-center">Nama Mahasiswa</th>
                    <th class="px-4 py-2 text-center">NIM</th>
                    <th class="px-4 py-2 text-center">Semester</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswas as $mahasiswa)
                    <tr class="border-t" wire:key="mahasiswa-{{ $mahasiswa->NIM }}">
                        <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->nama }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->NIM }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->semesterDifference }}</td>
                        <td class="px-4 py-2 text-center">{{ $mahasiswa->prodi->nama_prodi }}</td>
                        <!-- Button that opens the detail component -->
                        <td class="px-4 py-2 text-center">
                            <button onclick="window.location='{{ route('staff.detail', $mahasiswa->NIM) }}'"
                                class="px-2 py-1 text-white bg-yellow-500 hover:bg-yellow-600 rounded">Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">
            {{ $mahasiswas->links() }}
        </div>
    </div>
