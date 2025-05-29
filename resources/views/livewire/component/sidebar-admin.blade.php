<div class="fixed left-0 z-10 h-full min-h-screen md:relative md:sticky md:top-16">
    <div :class="showSidebar ? 'translate-x-0' : '-translate-x-full'"
        class="w-64 h-full transition-transform bg-customPurple sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <a wire:navigate.hover href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-2 rounded-lg transition duration-75 group
                        {{ request()->routeIs('admin.dashboard') ? ' text-white bg-purple2' : 'hover:bg-purple2 text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'hover:bg-purple2 text-purple3 hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Dashboard</span>
                    </a>
                </li>
                <li x-data="{ open: {{ request()->routeIs('admin.user', 'admin.mahasiswa', 'admin.dosen', 'admin.staff', 'admin.kelas', 'admin.mata_kuliah', 'admin.semester', 'admin.prodi', 'admin.ruangan', 'admin.kurikulum') ? 'true' : 'false' }} }">
                    <button type="button" @click="open = !open"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group
                            hover:bg-purple2 hover:text-white
                            {{ request()->routeIs('admin.user', 'admin.pengumuman', 'admin.staff') ? 'bg-purple2 text-white' : 'text-purple3' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white
                            {{ request()->routeIs('admin.user', 'admin.pengumuman', 'admin.staff') ? 'text-white' : '' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" />
                        </svg>
                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Data Master</span>
                        <svg class="w-3 h-3 mr-2 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <ul x-show="open" x-collapse class="py-2 space-y-2">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.user') }}"
                                class="flex items-center mx-4 p-2 rounded-lg group
                                    {{ request()->routeIs('admin.user') ? 'text-white bg-purple2' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">User</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.mahasiswa') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.mahasiswa') ? 'text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Mahasiswa</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.dosen') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.dosen') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Dosen</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.staff') }}"
                                class="flex items-center mx-4 p-2 rounded-lg group
                                    {{ request()->routeIs('admin.staff') ? 'text-white bg-purple2' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Staff</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.kelas') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.kelas') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Kelas</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.mata_kuliah') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.mata_kuliah') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Mata Kuliah</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.semester') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.semester') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Semester</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.prodi') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.prodi') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Prodi</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.ruangan') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.ruangan') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Ruangan</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.kurikulum') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.kurikulum') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Kurikulum</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.ttd') }}"
                                class="flex items-center mx-4 p-2 rounded-lg group
                                    {{ request()->routeIs('admin.ttd') ? 'text-white bg-purple2' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">TTD</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="{ open: {{ request()->routeIs('admin.anggota', 'admin.krs', 'admin.paket', 'admin.presensiMahasiswa', 'admin.presensiDosen') ? 'true' : 'false' }} }">
                    <button type="button" @click="open = !open"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 text-purple3 hover:text-white {{ request()->routeIs('admin.kurikulum', 'admin.semester', 'admin.mata_kuliah', 'admin.prodi', 'admin.kelas', 'admin.ruangan') ? 'text-white bg-purple2' : 'text-purple3' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.kurikulum', 'admin.semester', 'admin.mata_kuliah', 'admin.prodi', 'admin.kelas', 'admin.ruangan') ? 'text-white' : '' }}"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Akademik</span>
                        <svg class="w-3 h-3 mr-2 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <ul x-show="open" x-collapse class="py-2 space-y-2">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.anggota') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.anggota') || request()->routeIs('admin.anggota.edit') || request()->routeIs('admin.anggota.show') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Anggota Kelas</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.krs') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.krs') ? 'text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">KRS</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.paketkrs') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.paketkrs') || request()->routeIs('admin.paketkrs.create') ? 'text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Paket KRS</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.presensiMahasiswa') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.presensiMahasiswa') ? 'text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Presensi</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.presensiDosen') }}"
                                class="flex items-center mx-4 p-2 rounded-lg transition duration-75 group {{ request()->routeIs('admin.presensiDosen') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Presensi Mengajar</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li x-data="{
                    open: {{ request()->routeIs('admin.jadwal', 'admin.ujian', 'admin.komponen_ujian') ? 'true' : 'false' }}
                }">
                    <button type="button" @click="open = !open"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 {{ request()->routeIs('admin.jadwal', 'admin.ujian', 'admin.komponen_ujian') ? 'text-white bg-purple2' : 'text-purple3 hover:text-white' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.jadwal', 'admin.ujian', 'admin.komponen_ujian') ? 'text-white' : '' }}"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 text-left ms-3 whitespace-nowrap">Jadwal</span>
                        <svg class="w-3 h-3 mr-2 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul x-show="open" x-collapse class="py-2 space-y-2">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.jadwal') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.jadwal') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Jadwal Perkuliahan</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.ujian') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.ujian') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Jadwal Ujian</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a wire:navigate.hover href="{{ route('admin.komponen_ujian') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.komponen_ujian') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">komponen Kartu Ujian</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li x-data="{ open: {{ request()->routeIs('admin.pengumuman', 'dosen.khs', 'admin.emonev','admin.pertanyaan','admin.emonev.periode', 'admin.emonev.list-mahasiswa') ? 'true' : 'false' }} }">
                    <button type="button" @click="open = !open"
                        class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-purple2 hover:text-white {{ request()->routeIs('admin.mahasiswa', 'admin.krs', 'admin.paketkrs', 'admin.presensiMahasiswa') ? 'bg-purple2 text-white' : 'text-purple3' }}">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.mahasiswa') ? 'text-white' : '' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Informasi & Evaluasi
                        </span>
                        <svg class="w-3 h-3 mr-2 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul x-show="open" x-collapse class="py-2 space-y-2">
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.emonev') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.emonev') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Emonev</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.emonev.periode') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.emonev.periode') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Set Periode</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.pertanyaan') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.pertanyaan') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Pertanyaan</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.emonev.list-mahasiswa') }}"
                                class="flex items-center mx-4 p-2 text-gray-100 rounded-lg group {{ request()->routeIs('admin.emonev.list-mahasiswa') ? ' text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Log Pengisian</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('admin.pengumuman') }}"
                                class="flex items-center mx-4 p-2 rounded-lg group
                                    {{ request()->routeIs('admin.pengumuman') ? 'text-white bg-purple2' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">Pengumuman</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate.hover href="{{ route('dosen.khs') }}"
                                class="flex items-center mx-4 p-2 text-gray-500 rounded-lg group {{ request()->routeIs('admin.presensiMahasiswa') ? 'text-white' : 'text-purple3 hover:bg-purple2 hover:text-white' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap">KHS</span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>
    {{-- Add Flowbite Script --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script> --}}
</div>
