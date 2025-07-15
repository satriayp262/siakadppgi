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
        <a wire:navigate.hover href="{{ route('admin.semester') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-yellow-500 hover:bg-yellow-600">
            <h2 class="text-lg font-semibold text-white">Semester</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $semester }}</p>
        </a>

        <a wire:navigate.hover href="{{ route('admin.mahasiswa') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-lime-500 hover:bg-lime-600">
            <h2 class="text-lg font-semibold text-white">Mahasiswa</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $mahasiswa }}</p>
        </a>

        <a wire:navigate.hover href="{{ route('admin.prodi') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-blue-500 hover:bg-blue-600">
            <h2 class="text-lg font-semibold text-white">Program Studi</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $prodi }}</p>
        </a>

        <a wire:navigate.hover href="{{ route('admin.mata_kuliah') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-pink-500 hover:bg-pink-600">
            <h2 class="text-lg font-semibold text-white">Mata Kuliah</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $matakuliah }}</p>
        </a>

        <a wire:navigate.hover href="{{ route('admin.user') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-orange-500 hover:bg-orange-600">
            <h2 class="text-lg font-semibold text-white">User</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $user }}</p>
        </a>

        <a wire:navigate.hover href="{{ route('admin.dosen') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-purple-400 hover:bg-purple-500">
            <h2 class="text-lg font-semibold text-white">Dosen</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $dosen }}</p>
        </a>

        <a wire:navigate.hover href="{{ route('admin.kelas') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-green-500 hover:bg-green-600">
            <h2 class="text-lg font-semibold text-white">Kelas</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $kelas }}</p>
        </a>

        <a wire:navigate.hover href="{{ route('admin.kurikulum') }}"
            class="relative block p-4 rounded-lg shadow-lg bg-red-500 hover:bg-red-600">
            <h2 class="text-lg font-semibold text-white">Kurikulum</h2>
            <p class="mt-1 text-xl font-bold text-white">{{ $kurikulum }}</p>
        </a>
    </div>

    <div class="flex mt-5 space-x-4">
        <div class="w-full max-w-2xl mx-4 p-4 bg-white rounded-lg shadow-lg">
            <livewire:component.chart-component />
        </div>

        <div class="w-full max-w-2xl mx-4 p-4 bg-white rounded-lg shadow-lg">
            {{-- @livewire('component.chart-emonev', ['x' => $nama_periode], key($selectedSemester)) --}}
        </div>
    </div>

</div>
