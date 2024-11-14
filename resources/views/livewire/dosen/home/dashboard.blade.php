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

    <div class="overflow-hidden bg-purple-700 shadow-lg rounded-lg p-2 mb-6">
        <p class="inline-block whitespace-nowrap text-md font-semibold text-white"
            style="animation: marquee 15s linear infinite;">
            Selamat Datang di halaman Dosen <span class="text-yellow-400">SISTEM INFORMASI AKADEMIK POLITEKNIK PIKSI
                GANESHA INDONESIA</span>.
        </p>
    </div>

    <div class="w-full bg-white shadow-lg p-4 rounded-lg">
        <h4 class="text-xl font-semibold mb-4 text-gray-800">Data Dosen</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Nama Dosen -->
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 w-1/3 sm:w-1/4">Nama Dosen</span>
                <span class="font-semibold text-gray-700">:</span>
                <span class="text-gray-900 w-2/3 sm:w-2/4 ml-2">{{ $dosen->nama_dosen }}</span>
            </div>
            <!-- NIDN -->
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 w-1/3 sm:w-1/4">NIDN</span>
                <span class="font-semibold text-gray-700">:</span>
                <span class="text-gray-900 w-2/3 sm:w-2/4 ml-2">{{ $dosen->nidn }}</span>
            </div>
            <!-- Jenis Kelamin -->
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 w-1/3 sm:w-1/4">Jenis Kelamin</span>
                <span class="font-semibold text-gray-700">:</span>
                <span class="text-gray-900 w-2/3 sm:w-2/4 ml-2">{{ $dosen->jenis_kelamin }}</span>
            </div>
            <!-- Jabatan Fungsional -->
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 w-1/3 sm:w-1/4">Jabatan Fungsional</span>
                <span class="font-semibold text-gray-700">:</span>
                <span class="text-gray-900 w-2/3 sm:w-2/4 ml-2">{{ $dosen->jabatan_fungsional }}</span>
            </div>
            <!-- Kepangkatan -->
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 w-1/3 sm:w-1/4">Kepangkatan</span>
                <span class="font-semibold text-gray-700">:</span>
                <span class="text-gray-900 w-2/3 sm:w-2/4 ml-2">{{ $dosen->kepangkatan }}</span>
            </div>
            <!-- Prodi -->
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 w-1/3 sm:w-1/4">Prodi</span>
                <span class="font-semibold text-gray-700">:</span>
                <span class="text-gray-900 w-2/3 sm:w-2/4 ml-2">{{ $dosen->prodi->nama_prodi }}</span>
            </div>
            <!-- Email -->
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 w-1/3 sm:w-1/4">Email</span>
                <span class="font-semibold text-gray-700">:</span>
                <span class="text-gray-900 w-2/3 sm:w-2/4 ml-2">{{ $user->email }}</span>
            </div>
        </div>
    </div>
</div>
