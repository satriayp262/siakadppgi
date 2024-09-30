<div class="h-screen sticky top-16 left-0 -z-5 relative">
    <div id="default-sidebar " class="h-full w-64 transition-transform -translate-x-full bg-gray-800 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 ">
            <ul class="space-y-2 font-medium relative sticky top-20">
                <li>
                    <a href="{{ route('staff.tagihan') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('staff.tagihan') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('staff.tagihan') ? 'text-white' : 'text-gray-500' }}"
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

                        <span class="flex-1 ms-3 whitespace-nowrap">Input Pembayaran</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white' : 'text-gray-500 hover:bg-gray-500 hover:text-gray-100' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                clip-rule="evenodd" />
                        </svg>


                        <span class="flex-1 ms-3 whitespace-nowrap">Bukti Pembayaran</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    {{-- Add Flowbite Script --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</div>
