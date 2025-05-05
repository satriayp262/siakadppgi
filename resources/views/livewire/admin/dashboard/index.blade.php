<div class="p-4">
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(120%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>

    <div class="p-2 overflow-hidden bg-purple-300 rounded-lg shadow-lg">
        <p class="inline-block font-semibold text-purple-600 whitespace-nowrap text-md marquee-text"
            style="animation: marquee 15s linear infinite;">
            Selamat Datang di halaman admin <span class="text-purple-600">SISTEM INFORMASI AKADEMIK POLITEKNIK PIKSI
                GANESHA INDONESIA</span>.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 rounded-lg sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.semester') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-yellow-500 hover:bg-yellow-600">
            <h2 class="text-lg font-semibold text-white">Semester</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $semester }}</p>
        </a>

        <a href="{{ route('admin.mahasiswa') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-lime-500 hover:bg-lime-600">
            <h2 class="text-lg font-semibold text-white">Mahasiswa</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $mahasiswa }}</p>
        </a>

        <a href="{{ route('admin.prodi') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-blue-500 hover:bg-blue-600">
            <h2 class="text-lg font-semibold text-white">Program Studi</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $prodi }}</p>
        </a>

        <a href="{{ route('admin.mata_kuliah') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-pink-500 hover:bg-pink-600">
            <h2 class="text-lg font-semibold text-white">Mata Kuliah</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $matakuliah }}</p>
        </a>

        <a href="{{ route('admin.user') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-orange-500 hover:bg-orange-600">
            <h2 class="text-lg font-semibold text-white">User</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $user }}</p>
        </a>

        <a href="{{ route('admin.dosen') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-purple-400 hover:bg-purple-500">
            <h2 class="text-lg font-semibold text-white">Dosen</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $dosen }}</p>
        </a>

        <a href="{{ route('admin.kelas') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-green-500 hover:bg-green-600">
            <h2 class="text-lg font-semibold text-white">Kelas</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $kelas }}</p>
        </a>

        <a href="{{ route('admin.kurikulum') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-red-500 hover:bg-red-600">
            <h2 class="text-lg font-semibold text-white">Kurikulum</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $kurikulum }}</p>
        </a>
    </div>

    <div class="flex mt-5 space-x-4">
        {{-- <div class="w-1/2 p-4 bg-white rounded-lg shadow-lg">
            <livewire:component.chart-component />
        </div> --}}

        <div class="w-1/2 p-4 bg-white rounded-lg shadow-lg">
            <p class="text-3xl font-semibold text-center">COMING SOON!</p>
            <div
                class="flex items-center justify-center p-4 mt-4 mb-4 border-4 border-gray-600 rounded-lg bg-neutral-400">
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
