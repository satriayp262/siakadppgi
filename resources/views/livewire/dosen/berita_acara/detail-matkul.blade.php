<div class="mx-5">
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <h1 class="text-xl font-bold mb-4">Detail Kelas</h1>
        <table class="min-w-full mt-4 bg-white text-sm border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Nama Kelas</th>
                    <th class="px-4 py-2 text-center">Lingkup Kelas</th>
                    <th class="px-4 py-2 text-center">Mode Kuliah</th>
                    <th class="px-4 py-2 text-center">Prodi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas as $index => $item)
                    <tr class="text-center border-b border-gray-200">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $item->nama_kelas }}</td>
                        <td class="px-4 py-2">{{ $item->lingkup_kelas }}</td>
                        <td class="px-4 py-2">{{ $item->mode_kuliah }}</td>
                        <td class="px-4 py-2">{{ $item->prodi->nama_prodi ?? '-' }}</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada kelas yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kelas->links() }}
        </div>
    </div>
</div>
