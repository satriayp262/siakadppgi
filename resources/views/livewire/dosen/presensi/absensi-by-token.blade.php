<div class="mx-5">
    <div class="flex flex-row justify-between mx-4 mt-4 items-center">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li>
                    <a href="{{ route('dosen.presensi') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                        E-Presensi
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('dosen.presensiByKelas', ['id_mata_kuliah' => $matkul->id_mata_kuliah]) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                {{ $matkul->nama_mata_kuliah }}
                            </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span
                            class="text-sm font-medium text-gray-500 ms-1 md:ms-2">{{ $kelas->nama_kelas }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex justify-between items-center space-x-2 mt-2">
            <livewire:dosen.presensi.create-token :id_mata_kuliah="$id_mata_kuliah" :id_kelas="$id_kelas" />
            <input type="text" wire:model.live="search" placeholder="   Search"
                class="px-2 py-2 ml-4 border border-gray-300 rounded-lg">
        </div>
    </div>

    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <table class="min-w-full mt-2 bg-white text-sm">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-4 py-2 text-center">No</th>
                    <th class="px-4 py-2 text-center">Mata Kuliah</th>
                    <th class="px-4 py-2 text-center">Token</th>
                    <th class="px-4 py-2 text-center">Tanggal</th>
                    <th class="px-4 py-2 text-center">Valid Sampai</th>
                    <th class="px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tokens as $tokenItem)
                    <tr wire:key="token-{{ $tokenItem->id_token }}">
                        <td class="px-4 py-2 text-center">
                            {{ ($tokens->currentPage() - 1) * $tokens->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2 text-center">{{ $tokenItem->matkul->nama_mata_kuliah }}</td>
                        <td class="px-4 py-2 text-center">{{ $tokenItem->token }}</td>
                        <td class="px-4 py-2 text-center">
                            {{ \Carbon\Carbon::parse($tokenItem->created_at)->setTimezone('Asia/Jakarta')->format('d F Y / H:i:s') }}
                        </td>
                        <td class="px-4 py-2 text-center">
                            {{ \Carbon\Carbon::parse($tokenItem->valid_until)->format('d F Y / H:i:s') }}</td>
                        <td class="px-4 py-2 text-center flex-col space-x-1 items-center">
                            <button
                                onclick="{{ $tokenItem->valid_until < now() ? '' : 'copyToken(\'' . $tokenItem->token . '\')' }}"
                                class="px-2 py-1 text-white bg-blue-500 hover:bg-blue-600 rounded text-center
                                {{ $tokenItem->valid_until < now() ? 'bg-gray-500 hover:bg-gray-600 cursor-not-allowed' : '' }}"
                                {{ $tokenItem->valid_until < now() ? 'disabled' : '' }}>
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <button onclick="window.location='{{ route('dosen.detail_presensi', $tokenItem->token) }}'"
                                class="px-2 py-1 text-white bg-yellow-500 hover:bg-yellow-600 rounded"><svg
                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="py-4 mt-4 text-center">
            {{ $tokens->links() }}
        </div>
    </div>

    <script>
        function copyToken(token) {
            navigator.clipboard.writeText(token).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Token berhasil disalin!',
                    text: 'Token: ' + token,
                    showConfirmButton: false,
                    timer: 2000
                });
            }, function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyalin token',
                    text: 'Terjadi kesalahan saat menyalin token.',
                    showConfirmButton: true
                });
                console.error('Error copying text: ', err);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('created', event => {
                Swal.fire({
                    title: 'Success!',
                    text: event.detail.params.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Dispatch the modal-closed event to close the modal
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });
    </script>

</div>
