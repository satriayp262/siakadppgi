<div class="relative sticky left-0 h-screen top-16 -z-5">
    <div id="default-sidebar " class="w-64 h-full transition-transform -translate-x-full bg-gray-800 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 ">
            <ul class="relative sticky space-y-2 font-medium top-20">
                <li>
                    <a href="{{ route('mahasiswa.profile') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.profile') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mahasiswa.profile') ? 'text-white' : 'text-gray-500' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Profil</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('mahasiswa.keuangan') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('mahasiswa.keuangan') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Keuangan</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"
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
                    <a href="#"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"
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
                    <a href="#"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"
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
                    <a href="#"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Presensi</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
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
