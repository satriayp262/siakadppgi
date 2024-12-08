<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="fixed w-full">
        <nav class="bg-customPurple py-2.5 shadow-md ">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                <a href="#" class="flex items-center">
                    <img src="{{ asset('img/piksi.png') }}" class="h-6 mr-3 sm:h-9" alt="Landwind Logo" />
                    <span class="dark:text-white tracking-widest text-xl font-bold"
                        style="font-family: 'Nunito', sans-serif;">SIAKAD
                        PPGI</span>
                </a>
                <div class="flex space-x-2 items-center lg:order-2">
                    <a href="#pengumuman"
                        class="text-purple3 hover:text-gray-200 font-medium rounded-lg text-l px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0 ">Pengumuman</a>
                    <a href="/login"
                        class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-l px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0 ">Login</a>
                    {{-- <button data-collapse-toggle="mobile-menu-2" type="button"
                        class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button> --}}
                </div>
                <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        {{-- <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white bg-purple-700 rounded lg:bg-transparent lg:text-purple-700 lg:p-0 dark:text-white"
                                aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white bg-purple-700 rounded lg:bg-transparent lg:text-purple-700 lg:p-0 dark:text-white"
                                aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white bg-purple-700 rounded lg:bg-transparent lg:text-purple-700 lg:p-0 dark:text-white"
                                aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white bg-purple-700 rounded lg:bg-transparent lg:text-purple-700 lg:p-0 dark:text-white"
                                aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white bg-purple-700 rounded lg:bg-transparent lg:text-purple-700 lg:p-0 dark:text-white"
                                aria-current="page">Home</a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="bg-cover min-h-screen" style="background-image: url('{{ asset('img/rb.png') }}');">
        <div class="inset-0 bg-white bg-opacity-70"></div>
        <div
            class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28 text-white">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="max-w-2xl mb-6 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl">
                    Sistem Informasi Akademik<br>Politeknik Piksi Ganesha Kebumen
                </h1>
                <a href="/login"
                    class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-xl px-6 py-3 items-center">
                    Login
                </a>
            </div>
            <div class="mt-16 lg:mt-0 lg:col-span-5 lg:flex lg:justify-end">
                <img src="{{ asset('img/Untitled design.png') }}" alt="hero image" class="rounded-lg ">
            </div>
        </div>
    </section>


    <!-- Announcements Section -->
    <section id="pengumuman" class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h3 class="text-2xl font-bold text-center mb-8">Pengumuman</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($pengumuman->sortByDesc('created_at')->take(6) as $announcement)
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <img src="{{ asset('storage/image/pengumuman/' . $announcement->image) }}"
                            alt="{{ $announcement->title }}" class="w-full h-48 object-cover mb-4 rounded">
                        <h4 class="text-xl font-semibold mb-2">{{ $announcement->title }}</h4>
                        <p>{{ \Illuminate\Support\Str::limit($announcement->desc, 124) }}</p>
                        <livewire:admin.pengumuman.detail :id_pengumuman="$announcement->id_pengumuman"
                            wire:key="edit-{{ $announcement->id_pengumuman }}" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <footer class="bg-customPurple text-white py-8 ">
        <div class="container mx-auto px-6 md:flex md:justify-between">
            <!-- Logo dan Informasi Utama -->
            <div class="mb-6 md:mb-0">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('img/piksi.png') }}" class="h-20" alt="Logo Politeknik Piksi Ganesha" />
                    <div>
                        <h2 class="text-xl font-bold">Politeknik Piksi Ganesha Indonesia</h2>
                        <p class="text-sm mt-2">Jl. Letjend Suprapto No. 73, Kebumen, Jawa Tengah.</p>
                        <ul class="mt-2 text-sm">
                            <li>Email: <a href="mailto:info@politeknik-kebumen.ac.id"
                                    class="hover:underline">info@politeknik-kebumen.ac.id</a></li>
                            <li>WhatsApp: <a href="tel:081572255000" class="hover:underline">0815-7225-5000</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tiga Kolom Informasi -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Kerja Sama -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kerja Sama</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:underline">Kerja Sama Dalam Negeri</a></li>
                        <li><a href="#" class="hover:underline">Kerja Sama Luar Negeri</a></li>
                        <li><a href="#" class="hover:underline">Kerja Sama Alumni</a></li>
                        <li><a href="#" class="hover:underline">Career Development Center (CDC)</a></li>
                    </ul>
                </div>

                <!-- Tentang PPGI Kebumen -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tentang PPGI Kebumen</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:underline">Sambutan Direktur</a></li>
                        <li><a href="#" class="hover:underline">Sejarah</a></li>
                        <li><a href="#" class="hover:underline">Visi dan Misi</a></li>
                        <li><a href="#" class="hover:underline">Struktur Organisasi</a></li>
                        <li><a href="#" class="hover:underline">Manajemen</a></li>
                    </ul>
                </div>

                <!-- Pendaftaran -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Pendaftaran</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:underline">Diploma III</a></li>
                        <li><a href="#" class="hover:underline">Diploma IV / Sarjana</a></li>
                        <li><a href="#" class="hover:underline">Program VIP</a></li>
                        <li><a href="#" class="hover:underline">KIP Kuliah</a></li>
                        <li><a href="#" class="hover:underline">Jalur Mandiri</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </footer>
    <!-- Modal for Latest Announcement -->
    @if ($latestAnnouncement = $pengumuman->sortByDesc('created_at')->first())
        <div x-data="{ open: true }" x-show="open" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-transparant p-6 rounded-lg max-w-lg w-full">
                <div class="relative">
                    <div class="absolute top-0 right-0 mt-4 mr-4">
                        <button @click="open = false"
                            class="text-gray-500 hover:text-red-300 bg-gray-800 rounded-full px-1 py-1 opacity-50 hover:bg-red-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <img src="{{ asset('storage/image/pengumuman/' . $latestAnnouncement->image) }}"
                        alt="{{ $latestAnnouncement->title }}" class="w-full h-full object-cover mb-4 rounded">
                </div>
            </div>
        </div>
    @endif
</div>
