    <div class="p-4">
        <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Dashboard</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="text-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-sm font-medium text-gray-700">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </li>
                </ol>
            </div>
        </div>

        {{-- @if (Auth::user()->role === 'admin') --}}
            <div class="grid grid-cols-1 mt-5 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Dosen</h2>
                    <p class="text-xl font-bold mt-1">150</p>
                    <a href="{{ route('admin.dosen') }}" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Mahasiswa</h2>
                    <p class="text-xl font-bold mt-1">1200</p>
                    <a href="#" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Program Studi</h2>
                    <p class="text-xl font-bold mt-1">10</p>
                    <a href="{{ route('admin.prodi') }}" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Mata Kuliah</h2>
                    <p class="text-xl font-bold mt-1">45</p>
                    <a href="{{ route('admin.mata_kuliah') }}" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
            </div>
        {{-- @elseif(Auth::user()->role === 'dosen')
            <div class="grid grid-cols-1 mt-5 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Jadwal Kuliah</h2>
                    <p class="text-xl font-bold mt-1">5</p>
                    <a href="#" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Jumlah Mahasiswa</h2>
                    <p class="text-xl font-bold mt-1">1200</p>
                    <a href="#" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
            </div>
        @elseif(Auth::user()->role === 'mahasiswa')
            <div class="grid grid-cols-1 mt-5 sm:grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Jadwal Kuliah</h2>
                    <p class="text-xl font-bold mt-1">5</p>
                    <a href="#" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Nilai</h2>
                    <p class="text-xl font-bold mt-1">A</p>
                    <a href="#" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
            </div>
        @elseif(Auth::user()->role === 'staff')
            <div class="grid grid-cols-1 mt-5 sm:grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Jumlah Dosen</h2>
                    <p class="text-xl font-bold mt-1">150</p>
                    <a href="#" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 relative">
                    <h2 class="text-lg font-semibold">Jumlah Mahasiswa</h2>
                    <p class="text-xl font-bold mt-1">1200</p>
                    <a href="#" class="text-blue-500 text-sm absolute bottom-4 right-4">Klik disini >></a>
                </div>
            </div> --}}
        {{-- @endif --}}

    </div>
