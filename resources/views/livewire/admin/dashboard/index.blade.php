<div class="p-4">
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>

    {{-- <div class="flex items-center justify-between mb-4">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Dashboard</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="text-right">
            <ol class="breadcrumb">
                <li class="text-md font-medium text-gray-500 breadcrumb-item">
                    <h1>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</h1>
                </li>
            </ol>
        </div>
    </div> --}}

    <div class="overflow-hidden bg-purple-700 shadow-lg rounded-lg p-2">
        <p class="inline-block whitespace-nowrap text-lg font-semibold text-white"
            style="animation: marquee 15s linear infinite;">
            Selamat Datang di halaman admin <span class="text-yellow-400">SISTEM INFORMASI AKADEMIK POLITEKNIK PIKSI
                GANESHA INDONESIA</span>.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-2 lg:grid-cols-4 bg-white shadow-lg rounded-lg p-4">
        <div class="border-l-4 border-lime-600 relative p-4 bg-lime-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Dosen</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $dosen }}</p>
            <a href="{{ route('admin.dosen') }}"
                class="hover:text-gray-500 absolute text-sm text-white bottom-4 right-4">Detail >></a>
        </div>
        <div class="border-l-4 border-yellow-600 relative p-4 bg-yellow-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Mahasiswa</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $mahasiswa }}</p>
            <a href="{{ route('admin.mahasiswa') }}"
                class="hover:text-gray-500 absolute text-sm text-white bottom-4 right-4">Detail
                >></a>
        </div>
        <div class="border-l-4 border-red-600 relative p-4 bg-red-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Program Studi</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $prodi }}</p>
            <a href="{{ route('admin.prodi') }}"
                class=" hover:text-gray-500 absolute text-sm text-white bottom-4 right-4">Detail >></a>
        </div>
        <div class="border-l-4 border-pink-600 relative p-4 bg-pink-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Mata Kuliah</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $matakuliah }}</p>
            <a href="{{ route('admin.mata_kuliah') }}"
                class="absolute hover:text-gray-500 text-sm text-white bottom-4 right-4">Detail
                >></a>
        </div>
        <div class="border-l-4 border-purple-600 relative p-4 bg-purple-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">User</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $user }}</p>
            <a href="{{ route('admin.user') }}"
                class="absolute hover:text-gray-500 text-sm text-white bottom-4 right-4">Detail >></a>
        </div>
        <div class="border-l-4 border-sky-600 relative p-4 bg-sky-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Kelas</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $kelas }}</p>
            <a href="{{ route('admin.kelas') }}"
                class="absolute hover:text-gray-500 text-sm text-white bottom-4 right-4">Detail >></a>
        </div>
        <div class="border-l-4 border-green-600 relative p-4 bg-green-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Semester</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $semester }}</p>
            <a href="{{ route('admin.semester') }}"
                class="absolute hover:text-gray-500 text-sm text-white bottom-4 right-4">Detail
                >></a>
        </div>
        <div class="border-l-4 border-neutral-600 relative p-4 bg-neutral-400 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Kurikulum</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $kurikulum }}</p>
            <a href="{{ route('admin.kurikulum') }}"
                class="absolute hover:text-gray-500 text-sm text-white bottom-4 right-4">Detail
                >></a>
        </div>
    </div>

    <div class="flex space-x-4 mt-5">
        <div class="bg-white shadow-lg rounded-lg p-4 w-1/2">
            <livewire:component.chart-component />
        </div>

        <div class="bg-white shadow-lg rounded-lg p-4 w-1/2">
            <p class="text-3xl font-semibold text-center">COMING SOON!</p>
            <div class="flex items-center justify-center mt-4 mb-4 rounded-lg p-4 border-4 bg-neutral-400 border-gray-600">
                <svg width="200px" height="200px" viewBox="0 0 120.00 120.00" id="Layer_1" version="1.1"
                    xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    fill="#000000" stroke="#000000" stroke-width="0.0012000000000000001">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <style type="text/css">
                            .st0 {
                                fill: #ffdd00;
                            }

                            .st1 {
                                fill: #E8E9EA;
                            }

                            .st2 {
                                fill: #4D96FF;
                            }
                        </style>
                        <g>
                            <path class="st0"
                                d="M66.7,31.5c-0.2-0.8,0-1.7,0.6-2.3l11.6-11.6c0.6-0.6,1.5-0.8,2.3-0.6l8.2,2.2l-9.3,9.3 c-0.6,0.6-0.8,1.5-0.6,2.3l1.7,6.4c0.2,0.8,0.9,1.5,1.7,1.7l6.4,1.7c0.8,0.2,1.7,0,2.3-0.6l9.3-9.3l2.2,8.2c0.2,0.8,0,1.7-0.6,2.3 L90.8,52.7c-0.6,0.6-1.5,0.8-2.3,0.6l-9.6-2.6L50.8,78.9l2.6,9.6c0.2,0.8,0,1.7-0.6,2.3l-11.6,11.6c-0.6,0.6-1.5,0.8-2.3,0.6 l-8.2-2.2l9.3-9.3c0.6-0.6,0.8-1.5,0.6-2.3l-1.7-6.4c-0.2-0.8-0.9-1.5-1.7-1.7l-6.4-1.7c-0.8-0.2-1.7,0-2.3,0.6l-9.3,9.3L17,81.2 c-0.2-0.8,0-1.7,0.6-2.3l11.6-11.6c0.6-0.6,1.5-0.8,2.3-0.6l9.6,2.6l28.1-28.1L66.7,31.5z">
                            </path>
                            <g>
                                <polygon class="st1"
                                    points="102.4,98.1 98.1,102.4 92.5,99.3 91,95.4 56.2,60.6 60.6,56.2 95.3,90.9 99.2,92.4 ">
                                </polygon>
                                <path class="st2"
                                    d="M55.9,42.4L31.5,18c-0.6-0.6-1.6-0.5-2.3,0.1L18.1,29.2c-0.7,0.7-0.7,1.7-0.1,2.3l24.4,24.4 c0.6,0.6,1.6,0.5,2.3-0.1h0c0.7-0.7,1.7-0.7,2.3-0.1l0.6,0.6c0.6,0.6,0.5,1.6-0.1,2.3l0,0c-0.7,0.7-0.7,1.7-0.1,2.3l5.9,5.9 c0.6,0.6,1.6,0.5,2.3-0.1l11.1-11.1c0.7-0.7,0.7-1.7,0.1-2.3l-5.9-5.9c-0.6-0.6-1.6-0.5-2.3,0.1l0,0c-0.7,0.7-1.7,0.7-2.3,0.1 L55.6,47c-0.6-0.6-0.5-1.6,0.1-2.3l0,0C56.4,44,56.5,43,55.9,42.4z">
                                </path>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
    </div>

</div>
