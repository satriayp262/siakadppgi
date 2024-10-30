<div>
    <div class="mx-5">
        <div class="flex flex-col justify-between mx-4 mt-4">
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

        <div class="bg-purple-200 shadow-lg p-2 px-4 mt-2 rounded-lg max-w-full">
            <div class="flex justify-between">
                <h1><b>Semester Saat ini : </b>
                    {{ $semesters->firstWhere('is_active', true)->nama_semester ?? 'Tidak ada semester aktif' }}
                </h1>
                <div class="text-right">
                    <ol class="breadcrumb">
                        <li class="text-md font-medium text-gray-900 breadcrumb-item">
                            <h1>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</h1>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="items-center w-full text-sm text-white align-middle bg-gray-800">
                        <th class="px-4 py-2 text-center">No.</th>
                        <th class="px-4 py-2 text-center">Semester</th>
                        <th class="px-4 py-2 text-center">Bulan</th>
                        <th class="px-4 py-2 text-center">Tagihan</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Bukti Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tagihans as $tagihan)
                        <tr class="border-t" wire:key="tagihan-{{ $tagihan->nim }}">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center">{{ $tagihan->semester->nama_semester }}</td>
                            @php
                                $months = [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember',
                                ];
                                $bulan = $months[$tagihan->created_at->format('m')];
                                $tahun = $tagihan->created_at->format('Y');
                            @endphp
                            <td class="px-4 py-2 text-center">{{ $bulan }}, {{ $tahun }}</td>
                            <td class="px-4 py-2 text-center italic font-semibold">
                                @php
                                    $formattedTotalTagihan =
                                        'Rp. ' . number_format($tagihan->total_tagihan, 0, ',', '.');
                                @endphp
                                {{ $formattedTotalTagihan }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                @php
                                    $status = [
                                        'Belum Lunas' =>
                                            'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded',
                                        'Lunas' =>
                                            'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded',
                                    ];
                                    $status = $status[$tagihan->status_tagihan] ?? 'bg-gray-500';
                                @endphp
                                <span class="me-2 px-2.5 py-0.5 text-xs rounded-full {{ $status }}"
                                    style="width: 80px;">
                                    {{ ucfirst($tagihan->status_tagihan) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">

                                <a href="{{ route('mahasiswa.download', $tagihan->id_tagihan) }}" target="_blank"
                                    class="inline-block px-4 py-1 text-white bg-purple-500 hover:bg-purple-600 rounded">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                    </svg>

                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Controls -->
            <div class="py-8 mt-4 text-center">
                {{-- {{ $mahasiswas->links() }} --}}
            </div>
        </div>
    </div>
</div>
