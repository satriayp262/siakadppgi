<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true" class="inline-block px-3 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-800">
        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
        </svg>
    </button>

    <!-- Modal Background -->
    <div x-show="isOpen" x-transition.opacity x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-blue-600 rounded-t-lg">
                <h3 class="text-xl font-semibold text-white">Ganti/Validasi Jadwal</h3>
                <button @click="isOpen=false" wire:click="clear({{ $id_jadwal }})" class="text-lg text-white">&times;</button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-6">
                <div class="overflow-x-auto">
                    <div class="flex items-start mb-2">
                        <span>Batas Pengajuan Request Edit Jadwal Pada Tanggal {{ \Carbon\Carbon::parse($batas->batas_pengajuan)->format('d-m-Y') }}</span>
                    </div>
                    <table class="w-full text-left text-black border border-collapse border-gray-300 table-auto">
                        <thead class="bg-customPurple">
                            <tr>
                                <th class="px-4 py-2 text-white border border-gray-300">Hari</th>
                                <th class="px-4 py-2 text-white border border-gray-300">Sesi</th>
                                <th class="px-4 py-2 text-white border border-gray-300">Mata Kuliah</th>
                                <th class="px-4 py-2 text-white border border-gray-300">Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 border border-gray-300">{{ $ammo->hari }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $ammo->sesi }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $ammo->matakuliah->nama_mata_kuliah }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $ammo->dosen->nama_dosen }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Form Handling -->
                    <form wire:submit='update' class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <select wire:model.live="z" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" selected>Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                </select>
                                @error('z') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <select wire:model.live="x" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" selected>Pilih Sesi</option>
                                    <option value="1">sesi 1, jam 08.00-09.30</option>
                                    <option value="2">sesi 2, jam 09.30-11.00</option>
                                    <option value="3">sesi 3, jam 11.00-12.30</option>
                                    <option value="4">sesi 4, jam 12.30-14.00</option>
                                    <option value="5">sesi 5, jam 14.00-15.30</option>
                                    <option value="6">sesi 6, jam 15.30-17.00</option>
                                    <option value="7">sesi 7, jam 17.00-18.30</option>
                                    <option value="8">sesi 8, jam 18.30-20.00</option>
                                </select>
                                @error('x') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="submit" @click="isOpen=false" class="px-4 py-2 font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-800">Submit</button>
                        </div>
                    </form>
                    <div class="flex justify-center space-x-2">
                        <button type="button" @click="isOpen=false" wire:click="clear({{ $id_jadwal }})" class="px-4 py-2 font-bold text-white transition bg-red-600 rounded-lg hover:bg-red-800">Close</button>
                        <button wire:click="update2" @click="isOpen=false" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800">Validasi</button>
                    </div>
            </div>
        </div>
    </div>
</div>
