<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold">Histori Pembayaran</h1>
                <p class="text-sm text-gray-500">Halaman ini ditunjukan untuk melihat histori pembayaran yang telah
                    dilakukan melalui rekening PPGI
                </p>
            </div>
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                        <th class="px-4 py-2 text-center">No.</th>
                        <th class="px-4 py-2 text-center">Tagihan</th>
                        <th class="px-4 py-2 text-center">Tanggal Pembayaran</th>
                        <th class="px-4 py-2 text-center">Bukti Pembayaran</th>
                        <th class="px-4 py-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($konfirmasi as $tagihan)
                        <tr class="border-t odd:bg-white  even:bg-gray-100" wire:key="tagihan-{{ $tagihan->nim }}">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ $tagihan->tagihan->jenis_tagihan . ' (' . $tagihan->tagihan->semester->nama_semester . ')' }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($tagihan->tanggal_pembayaran)->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                @if ($tagihan->bukti_pembayaran)
                                    <a href="{{ asset('storage/image/bukti_pembayaran/' . $tagihan->bukti_pembayaran) }}"
                                        target="_blank" class="text-blue-500 hover:underline">Lihat Bukti</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $tagihan->status }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
