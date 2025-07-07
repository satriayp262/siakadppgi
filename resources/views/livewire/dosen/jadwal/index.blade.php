<div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">
    <div class="flex items-center justify-between w-full mb-2">
        <P class="px-4 py-2 text-lg font-bold text-customPurple">Jadwal Mengajar {{ $dosen->nama_dosen }}</P>

        <div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
            <!-- Container untuk meratakan tombol ke kanan -->
            <div class="flex justify-end">
                <!-- Button to open the modal -->
                <button @click="isOpen=true"
                    class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    Preferensi Jadwal
                </button>
            </div>

            <!-- Modal Background -->
                <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
                    <!-- Modal Content -->
                    <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-4 bg-blue-600 rounded-t-lg">
                            <h3 class="text-xl font-semibold text-white">Preferensi Jadwal</h3>
                            <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                                <button class="text-lg text-white">&times;</button>
                            </div>
                        </div>
                        <div class="p-4 overflow-x-auto">
                            <h3 class="mb-4 text-lg font-semibold">Preferensi Jadwal yang sudah dibuat</h3>
                            <table class="w-full text-left text-black border border-collapse border-gray-300 table-auto">
                                <thead class="bg-customPurple">
                                    <tr>
                                        <th class="px-4 py-2 text-white border border-gray-300">Hari</th>
                                        <th class="px-4 py-2 text-white border border-gray-300">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($preferensi)
                                        <tr>
                                            <td class="px-4 py-2 border border-gray-300">{{ $preferensi->hari }}</td>
                                            @if ($preferensi->waktu == 1)
                                                <td class="px-4 py-2 border border-gray-300">08.00 sampai 14.00</td>
                                            @elseif ($preferensi->waktu == 2)
                                                <td class="px-4 py-2 border border-gray-300">11.00 sampai 17.00</td>
                                            @elseif ($preferensi->waktu == 3)
                                                <td class="px-4 py-2 border border-gray-300">14.00 sampai 20.00</td>
                                            @endif
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="2" class="px-4 py-2 text-center text-gray-500 border border-gray-300">
                                                Belum ada preferensi jadwal
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4">
                            <h3 class="mb-2 text-lg font-semibold">Preferensi Jadwal Baru</h3>
                            <form wire:submit.prevent="preferensi" class="space-y-4">
                                <!-- Input Preferensi Jadwal -->
                                <div>
                                    <label for="hari" class="block mb-2 font-semibold text-gray-700">
                                        Hari
                                    </label>
                                    <select name="hari" id="batas" wire:model="hari"
                                        class="block w-full px-2 py-1 mt-1 border border-gray-700 rounded shadow focus:border-indigo-500 sm:text-sm">
                                        <option value="">-- Pilih Hari --</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                    </select>
                                    @error('hari')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="waktu" class="block mb-2 font-semibold text-gray-700">
                                        Waktu
                                    </label>
                                    <select name="waktu" id="batas" wire:model="waktu"
                                        class="block w-full px-2 py-1 mt-1 border border-gray-700 rounded shadow focus:border-indigo-500 sm:text-sm">
                                        <option value="">-- Pilih Waktu --</option>
                                        <option value="1">08.00 sampai 14.00</option>
                                        <option value="2">11.00 sampai 17.00</option>
                                        <option value="3">14.00 sampai 20.00</option>
                                    </select>
                                    @error('waktu')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tombol Generate dengan Loading -->
                                <div class="flex items-center justify-end space-x-4">
                                    <button type="submit"
                                            wire:loading.attr="disabled"
                                            wire:target="pilihSemester"
                                            class="relative flex items-center justify-center px-6 py-2 font-semibold text-white bg-green-600 rounded hover:bg-green-700 disabled:opacity-50">
                                        <!-- Teks tombol -->
                                        <span wire:loading.remove wire:target="pilihSemester">
                                            Submit Preferensi Baru
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <span class="px-4 py-2 font-bold text-black">
        Periode {{ $bulanMulai }} sampai {{ $bulanSelesai }}
    </span>
    <livewire:table.dosen.jadwal.jadwal-table />
    <button type="button" class="flex items-center px-4 py-2 mt-2 ml-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click='generatePdf()'>Download Jadwal Mengajar</button>
        {{-- <table class="w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                    <th class="px-3 py-2 text-center">Hari</th>
                    <th class="px-3 py-2 text-center">Sesi</th>
                    <th class="px-3 py-2 text-center">Mata Kuliah</th>
                    <th class="px-3 py-2 text-center">Prodi</th>
                    <th class="px-3 py-2 text-center">Kelas</th>
                    <th class="px-3 py-2 text-center">Ruangan</th>
                    <th class="px-3 py-2 text-center">Ganti/Validasi</th>
                </tr>
            </thead>
                <tbody>
                    @php
                        $previousDay = null;
                    @endphp

                    @foreach ($jadwals as $jadwal)
                        <tr class="border-t" wire:key="jadwal-{{ $jadwal->id_jadwal }}">
                            <!-- Tampilkan Hari hanya jika berbeda dari hari sebelumnya -->
                            <td class="px-3 py-1 text-center">
                                @if ($jadwal->hari != $previousDay)
                                    {{ $jadwal->hari }}
                                    @php
                                        $previousDay = $jadwal->hari;
                                    @endphp
                                @endif
                            </td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->sesi }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->matakuliah->nama_mata_kuliah }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->prodi->nama_prodi }}</td>
                            <td class="px-3 py-1 text-center">{{ $jadwal->kelas->nama_kelas }}</td>
                            @if ($jadwal->id_ruangan == 'Online')
                                <td class="px-3 py-1 text-center">Online</td>
                            @else
                                <td class="px-3 py-1 text-center">{{ $jadwal->ruangan->kode_ruangan }}</td>
                            @endif
                            <td class="px-3 py-1 text-center">
                                <div class="flex flex-row justify-center">
                                    <livewire:dosen.jadwal.request :id_jadwal="$jadwal->id_jadwal"
                                        wire:key="edit-{{ $jadwal->id_jadwal }}" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table> --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Livewire.on('show-message', event => {
                    Swal.fire({
                        icon: event.type,
                        title: event.message,
                        showConfirmButton: true,
                    });
                });
            });
        </script>
</div>
