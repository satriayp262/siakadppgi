    <div class="p-4">
        <div class="flex items-center justify-between">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Dashboard</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="text-right">
                <ol class="breadcrumb">
                    <li class="text-sm font-medium text-gray-700 breadcrumb-item">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </li>
                </ol>
            </div>
        </div>

        {{-- @if (Auth::user()->role === 'admin') --}}
            <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Dosen</h2>
                    <p class="mt-1 text-xl font-bold">{{ $dosen }}</p>
                    <a href="{{ route('admin.dosen') }}" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Mahasiswa</h2>
                    <p class="mt-1 text-xl font-bold">{{ $mahasiswa }}</p>
                    <a href="#" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Program Studi</h2>
                    <p class="mt-1 text-xl font-bold">{{ $prodi }}</p>
                    <a href="{{ route('admin.prodi') }}" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Mata Kuliah</h2>
                    <p class="mt-1 text-xl font-bold">{{ $matakuliah }}</p>
                    <a href="{{ route('admin.mata_kuliah') }}" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
            </div>
        {{-- @elseif(Auth::user()->role === 'dosen')
            <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Jadwal Kuliah</h2>
                    <p class="mt-1 text-xl font-bold">5</p>
                    <a href="#" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Jumlah Mahasiswa</h2>
                    <p class="mt-1 text-xl font-bold">1200</p>
                    <a href="#" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
            </div>
        @elseif(Auth::user()->role === 'mahasiswa')
            <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-1 lg:grid-cols-2">
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Jadwal Kuliah</h2>
                    <p class="mt-1 text-xl font-bold">5</p>
                    <a href="#" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Nilai</h2>
                    <p class="mt-1 text-xl font-bold">A</p>
                    <a href="#" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
            </div>
        @elseif(Auth::user()->role === 'staff')
            <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-1 lg:grid-cols-2">
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Jumlah Dosen</h2>
                    <p class="mt-1 text-xl font-bold">150</p>
                    <a href="#" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Jumlah Mahasiswa</h2>
                    <p class="mt-1 text-xl font-bold">1200</p>
                    <a href="#" class="absolute text-sm text-blue-500 bottom-4 right-4">Klik disini >></a>
                </div>
            </div> --}}
        {{-- @endif --}}

    </div>
