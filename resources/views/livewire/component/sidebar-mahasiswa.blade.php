<div class="fixed left-0 z-10 h-screen md:relative md:sticky top-16">
    <div id="default-sidebar"
        class="w-64 h-full transition-transform -translate-x-full bg-customPurple sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4">
            <ul class="space-y-2 font-medium">
                {{-- <li>
                    <a href="{{ route('mahasiswa.profile') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.profile') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mahasiswa.profile') ? ' text-white' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Profil</span>
                    </a>
                </li> --}}

                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 text-purple3 hover:text-white {{ request()->routeIs('mahasiswa.keuangan', 'mahasiswa.transaksi', 'mahasiswa.transaksi.konfirmasi') ? 'text-white bg-purple2' : 'text-purple3' }}"
                        aria-controls="dropdown-sistem" data-collapse-toggle="dropdown-sistem">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mahasiswa.keuangan', 'mahasiswa.transaksi', 'mahasiswa.transaksi.konfirmasi') ? ' text-white' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z"
                                clip-rule="evenodd" />
                            <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                        </svg>
                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Keuangan</span>
                        <svg class="w-3 h-3 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-sistem"
                        class="{{ request()->routeIs(['mahasiswa.keuangan', 'mahasiswa.transaksi', 'mahasiswa.transaksi.konfirmasi']) ? '' : 'hidden' }} py-2 space-y-2">
                        <li>
                            <a href="{{ route('mahasiswa.keuangan', 'mahasiswa.transaksi') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('mahasiswa.keuangan', 'mahasiswa.transaksi') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Pembayaran</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('mahasiswa.transaksi.konfirmasi') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('mahasiswa.transaksi.konfirmasi') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">konfirmasi Pembayaran</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.krs') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.krs') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mahasiswa.krs') ? ' text-white ' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">KRS</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.paketkrs') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.paketkrs') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mahasiswa.krs') ? ' text-white ' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pengajuan KRS</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.jadwal') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.jadwal') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('dosen.jadwal') ? 'text-white' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Jadwal Perkuliahan</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate.hover href="{{ route('mahasiswa.ujian') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.ujian') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white {{ request()->routeIs('dosen.kartu-ujian') ? 'text-white' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H4Zm0 2h16v14H4V5Zm3 3a1 1 0 1 1 0 2h10a1 1 0 1 1 0-2H7Zm0 4a1 1 0 1 1 0 2h6a1 1 0 1 1 0-2H7Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Kartu Ujian</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? ' text-white ' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">DHS</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.khs.detail', ['NIM' => auth()->user()->nim_nidn]) }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? ' text-white ' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">KHS</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.presensi') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.presensi') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mahasiswa.presensi') ? ' text-white ' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.133 12.632v-1.8a5.407 5.407 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.933.933 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175Zm-13.267-.8a1 1 0 0 1-1-1 9.424 9.424 0 0 1 2.517-6.391A1.001 1.001 0 1 1 6.854 5.8a7.43 7.43 0 0 0-1.988 5.037 1 1 0 0 1-1 .995Zm16.268 0a1 1 0 0 1-1-1A7.431 7.431 0 0 0 17.146 5.8a1 1 0 0 1 1.471-1.354 9.424 9.424 0 0 1 2.517 6.391 1 1 0 0 1-1 .995ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z" />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">E-Presensi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.emonev') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.emonev.semester', 'emonev.detail', 'mahasiswa.emonev') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mahasiswa.emonev.semester', 'emonev.detail', 'mahasiswa.emonev') ? ' text-white ' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 15v3c0 .5523.44772 1 1 1h10M3 15v-4m0 4h9m-9-4V6c0-.55228.44772-1 1-1h16c.5523 0 1 .44772 1 1v3M3 11h11m-2-.2079V19m3-4h1.9909M21 15c0 1.1046-.8954 2-2 2s-2-.8954-2-2 .8954-2 2-2 2 .8954 2 2Z" />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">E-Monev</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    {{-- Add Flowbite Script --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</div>
