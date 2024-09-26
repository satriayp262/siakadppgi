{{-- <div class="w-full"> --}}
<nav class="sticky relative top-0 w-full bg-gray-900 border-gray-200 z-30">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center space-x-2">
            <button id="sidebarToggle" aria-controls="default-sidebar" type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-transparent focus:outline-none">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                    </path>
                </svg>
            </button>

            <img src="{{ asset('img/piksi.png') }}" class="w-auto h-8 max-w-full" alt="logopiksi" />

            <span
                class="self-center hidden text-sm font-semibold text-white sm:block md:text-lg lg:text-xl whitespace-nowrap">
                POLITEKNIK PIKSI GANESHA INDONESIA
            </span>
        </div>

        <div class="relative">
            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                id="user-menu-button" aria-expanded="false">
                <span class="sr-only">Open user menu</span>
                <svg class="w-8 h-8 text-gray-400 rounded-full" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <div class="absolute right-0 z-50 hidden mt-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow top-full"
                id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block font-bold text-sm text-gray-600">{{ Auth::user()->name }}</span>
                        <span class="block text-sm text-gray-500 truncate">{{ Auth::user()->email }}</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    </li>
                    <li>
                        {{-- <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign
                                out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form> --}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('default-sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function(event) {
                    sidebar.classList.toggle('-translate-x-full');
                    event.stopPropagation();
                });

                document.addEventListener('click', function(event) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            }

            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');

            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function() {
                    userDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</nav>

{{-- </div> --}}
