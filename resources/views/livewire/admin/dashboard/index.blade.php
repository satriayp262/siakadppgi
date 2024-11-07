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

    <div class="flex items-center justify-between mb-4">
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
    </div>

    <div class="overflow-hidden bg-yellow-400 shadow-lg rounded-lg p-2">
        <p class="inline-block whitespace-nowrap text-lg font-semibold text-white" style="animation: marquee 10s linear infinite;">
            Selamat Datang di halaman admin <span class="text-red-500">SISTEM INFORMASI AKADEMIK POLITEKNIK PIKSI
            GANESHA INDONESIA.</span>
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-2 lg:grid-cols-4 bg-white shadow-lg rounded-lg p-4">
        <div class="border-l-4 border-blue-600 relative p-4 bg-blue-400 rounded-lg shadow-md">
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
    </div>

    <div class="flex space-x-4 mt-5">
        <div class="bg-white shadow-lg rounded-lg p-4 w-1/2">
            <livewire:component.chart-component />
        </div>

        <div class="bg-white shadow-lg rounded-lg p-4 w-1/2">
            <p class="text-3xl font-semibold text-center">COOMING SOON!</p>
        </div>
    </div>

</div>
