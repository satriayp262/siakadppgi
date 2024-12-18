<div class="sticky left-0 h-full top-16 -z-5">
    <div id="default-sidebar " class="w-64 h-full transition-transform -translate-x-full bg-customPurple sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 ">
            <ul class="sticky space-y-2 font-medium top-20">
                <li>
                    <a wire:navigate.hover href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Dashboard</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 text-purple3 hover:text-white {{ request()->routeIs('admin.user', 'admin.pengumuman', 'admin.staff', 'admin.pertanyaan') ? 'text-white bg-purple2' : 'text-purple3' }}"
                        aria-controls="dropdown-sistem" data-collapse-toggle="dropdown-sistem">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.user', 'admin.pengumuman', 'admin.pertanyaan', 'admin.staff') ? 'text-white' : '' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Sistem</span>
                        <svg class="w-3 h-3 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-sistem"
                        class="{{ request()->routeIs(['admin.user', 'admin.pengumuman', 'admin.staff', 'admin.pertanyaan']) ? '' : 'hidden' }} py-2 space-y-2">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.user') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.user') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">User</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.pengumuman') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.pengumuman') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Pengumuman</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.staff') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.staff') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Staff</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.pertanyaan') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.pertanyaan') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Pertanyaan</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 text-purple3 hover:text-white {{ request()->routeIs('admin.kurikulum', 'admin.semester', 'admin.mata_kuliah', 'admin.prodi', 'admin.kelas', 'admin.ruangan') ? 'text-white bg-purple2' : 'text-purple3' }}"
                        aria-controls="dropdown-akademik" data-collapse-toggle="dropdown-akademik">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.kurikulum', 'admin.semester', 'admin.mata_kuliah', 'admin.prodi', 'admin.kelas', 'admin.ruangan') ? 'text-white' : '' }}"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Akademik</span>
                        <svg class="w-3 h-3 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-akademik"
                        class="py-2 space-y-2 {{ request()->routeIs(['admin.kurikulum', 'admin.semester', 'admin.mata_kuliah', 'admin.prodi', 'admin.kelas', 'admin.ruangan']) ? '' : 'hidden' }}">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.kurikulum') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.kurikulum') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.kurikulum') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 5v14m-8-7h2m0 0h2m-2 0v2m0-2v-2m12 1h-6m6 4h-6M4 19h16c.5523 0 1-.4477 1-1V6c0-.55228-.4477-1-1-1H4c-.55228 0-1 .44772-1 1v12c0 .5523.44772 1 1 1Z" />
                                </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">Kurikulum</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.semester') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.semester') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.semester') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4h2a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h2V4Zm2 6v10h12V10H6Zm4 2h2v2H9V12Zm4 0h2v2h-2V12Zm-4 4h2v2H9v-2Zm4 0h2v2h-2v-2Z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">Semester</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.mata_kuliah') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.mata_kuliah') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.mata_kuliah') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">Mata Kuliah</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.prodi') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.prodi') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.prodi') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">Prodi</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.kelas') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.kelas') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.kelas') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Z"
                                        clip-rule="evenodd" />
                                </svg> --}}

                                <span class="flex-1 ms-3 whitespace-nowrap">Kelas</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.ruangan') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.ruangan') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.ruangan') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Z"
                                        clip-rule="evenodd" />
                                </svg> --}}

                                <span class="flex-1 ms-3 whitespace-nowrap">Ruangan</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 text-purple3 hover:text-white {{ request()->routeIs('admin.jadwal', 'admin.jadwalUjian') ? 'text-white bg-purple2' : 'text-purple3' }}"
                        aria-controls="dropdown-jadwal" data-collapse-toggle="dropdown-jadwal">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.jadwal') ? 'text-white' : '' }}" 
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" 
                            viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" 
                                d="M6 2a1 1 0 1 0-2 0v1H3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-1V2a1 1 0 1 0-2 0v1H6V2ZM3 8h14v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8Zm3 2a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0v-1a1 1 0 0 1 1-1Zm4 0a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0v-1a1 1 0 0 1 1-1Zm4 0a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0v-1a1 1 0 0 1 1-1Z" 
                                clip-rule="evenodd" />
                        </svg>

                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">jadwal</span>
                        <svg class="w-3 h-3 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-jadwal"
                        class="py-2 space-y-2 {{ request()->routeIs('admin.jadwal') || request()->routeIs('admin.jadwalUjian') ? 'block' : 'hidden' }}">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.jadwal') }}"
                                class="flex items-center mx-4 p-2 rounded-lg transition duration-75 group
                                {{ request()->routeIs('admin.jadwal') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.jadwal') ? 'text-white' : 'text-white hover:bg-purple2' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                        clip-rule="evenodd" />
                                </svg> --}}

                                <span class="flex-1 ms-3 whitespace-nowrap">Jadwal Mengajar</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.jadwalUjian') }}"
                                class="flex items-center mx-4 p-2 rounded-lg transition duration-75 group
                                {{ request()->routeIs('admin.jadwalUjian') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.jadwal') ? 'text-white' : 'text-white hover:bg-purple2' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                        clip-rule="evenodd" />
                                </svg> --}}

                                <span class="flex-1 ms-3 whitespace-nowrap">Jadwal Ujian</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 text-purple3 hover:text-white {{ request()->routeIs('admin.mahasiswa', 'admin.krs') ? 'text-white bg-purple2' : 'text-purple3' }}"
                        aria-controls="dropdown-mahasiswa" data-collapse-toggle="dropdown-mahasiswa">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.mahasiswa') ? 'text-white ' : '' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Mahasiswa</span>
                        <svg class="w-3 h-3 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-mahasiswa"
                        class="py-2 space-y-2 {{ request()->routeIs(['admin.mahasiswa', 'admin.krs', 'admin.presensiMahasiswa']) ? '' : 'hidden' }}">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.mahasiswa') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.mahasiswa') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.mahasiswa') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">Mahasiswa</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.krs') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.krs') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.krs') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4h2a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h2V4Zm2 6v10h12V10H6Zm4 2h2v2H9V12Zm4 0h2v2h-2V12Zm-4 4h2v2H9v-2Zm4 0h2v2h-2v-2Z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">KRS</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.presensiMahasiswa') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.presensiMahasiswa') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.krs') ? 'text-white' : 'text-gray-500' }}"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4h2a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h2V4Zm2 6v10h12V10H6Zm4 2h2v2H9V12Zm4 0h2v2h-2V12Zm-4 4h2v2H9v-2Zm4 0h2v2h-2v-2Z"
                                    clip-rule="evenodd" />
                            </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">Presensi</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 text-purple3 hover:text-white {{ request()->routeIs('admin.dosen', 'admin.presensiDosen') ? 'text-white bg-purple2' : 'text-purple3' }}"
                        aria-controls="dropdown-dosen" data-collapse-toggle="dropdown-dosen">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dosen') ? 'text-white' : '' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Dosen</span>
                        <svg class="w-3 h-3 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-dosen"
                        class="py-2 space-y-2 {{ request()->routeIs('admin.dosen') || request()->routeIs('admin.presensiDosen') ? 'block' : 'hidden' }}">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.dosen') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.dosen') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dosen') ? 'text-white' : 'text-gray-500' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                <span class="flex-1 ms-3 whitespace-nowrap">Dosen</span>
                            </a>
                        </li>
                       
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.presensiDosen') }}"
                                class="flex items-center mx-4 p-2 rounded-lg transition duration-75 group
                                {{ request()->routeIs('admin.presensiDosen') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                {{-- <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.jadwal') ? 'text-white' : 'text-white hover:bg-purple2' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                        clip-rule="evenodd" />
                                </svg> --}}

                                <span class="flex-1 ms-3 whitespace-nowrap">Presensi Mengajar</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    {{-- Add Flowbite Script --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</div>
