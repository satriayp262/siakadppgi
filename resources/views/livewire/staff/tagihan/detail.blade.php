<div>
    <div class="mx-5">
        <div class="flex flex-col justify-between mx-4 mt-4">
            <div class="flex justify-between items-center">
                <nav aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li>
                            <a href="{{ route('staff.pembayaran') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                Pembayaran
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span
                                    class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $tagihan->mahasiswa->nama }}
                                    ({{ $tagihan->mahasiswa->NIM }})</span>
                            </div>
                        </li>
                    </ol>
                </nav>
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
                        class="flex items-center justify-between p-4 mx-12 mt-8 mb-4 text-white {{ $bgColor }} rounded">
                        <span>{{ session('message') }}</span>
                        <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                            class="font-bold text-white">
                            &times;
                        </button>
                    </div>
                @endif
            </div>
            <!-- Modal Form -->
        </div>
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                        <th class="px-4 py-2 text-center">No.</th>
                        <th class="px-4 py-2 text-center">Semester</th>
                        <th class="px-4 py-2 text-center">Bulan</th>
                        <th class="px-4 py-2 text-center">Tahun</th>
                        <th class="px-4 py-2 text-center">Tagihan</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Jumlah Pembayaran</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tagihans as $tagihan)
                        <tr class="border-t" wire:key="tagihan-{{ $tagihan->id_tagihan }}">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-center">{{ $tagihan->semester->nama_semester }}</td>
                            <td class="px-4 py-2 text-center">
                                @php
                                    $bulan = substr($tagihan->Bulan, 5, 2);
                                    $namaBulan = [
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
                                    ][$bulan];
                                @endphp
                                {{ $namaBulan }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ substr($tagihan->Bulan, 0, 4) }}
                            </td>
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
                                        'Belum Lunas' => 'bg-red-100 text-red-800',
                                        'Lunas' => 'bg-blue-400 text-white px-2 py-0.5 rounded-full',
                                    ];
                                    $status = $status[$tagihan->status_tagihan] ?? 'bg-gray-500';
                                @endphp
                                <span class="me-2 px-2.5 py-0.5 text-xs rounded-full {{ $status }}"
                                    style="width: 80px;">
                                    {{ ucfirst($tagihan->status_tagihan) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center italic font-semibold">
                                @php
                                    $formattedTotalBayar = 'Rp. ' . number_format($tagihan->total_bayar, 0, ',', '.');
                                @endphp
                                {{ $formattedTotalBayar }}
                            </td>
                            <td class="px-4 py-2 text-center justify-items-center">
                                @if ($tagihan->status_tagihan === 'Belum Lunas')
                                    <livewire:staff.tagihan.update :id_tagihan="$tagihan->id_tagihan"
                                        wire:key="edit-{{ $tagihan->id_tagihan }}" />
                                @elseif ($tagihan->status_tagihan === 'Lunas')
                                    <livewire:staff.tagihan.transaksi :id_tagihan="$tagihan->id_tagihan"
                                        wire:key="edit-{{ $tagihan->id_tagihan }}" />
                                @endif
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Controls -->
        <div class="py-8 mt-4 text-center">
            {{-- {{ $mahasiswas->links() }} --}}
        </div>
    </div>
</div>
