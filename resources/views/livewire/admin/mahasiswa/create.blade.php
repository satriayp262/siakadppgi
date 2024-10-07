<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white font-black" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M5 12h14m-7 7V5" />
        </svg>
        Tambah
    </button>

    <!-- Modal Background -->
    <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Tambah Mahasiswa</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="save">

                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" id="nama" wire:model="nama" name="nama"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('nama')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="NIM" class="block text-sm font-medium text-gray-700">NIM</label>
                            <input type="number" id="NIM" wire:model="NIM" name="NIM"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('NIM')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis
                                Kelamin</label>
                            <select id="jenis_kelamin" wire:model="jenis_kelamin" name="jenis_kelamin"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Prodi</label>
                            <select id="kode_prodi" wire:model="kode_prodi" name="kode_prodi"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Select</option>
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                            @error('kode_prodi')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                            <input type="text" id="agama" wire:model="agama" name="agama"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('agama')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <input type="text" id="alamat" wire:model="alamat" name="alamat"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('alamat')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jalur_pendaftaran" class="block text-sm font-medium text-gray-700">Jalur
                                Pendaftaran</label>
                            <input type="text" id="jalur_pendaftaran" wire:model="jalur_pendaftaran"
                                name="jalur_pendaftaran"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jalur_pendaftaran')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kewarganegaraan"
                                class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                            <input type="text" id="kewarganegaraan" wire:model="kewarganegaraan"
                                name="kewarganegaraan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('kewarganegaraan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jenis_pendaftaran" class="block text-sm font-medium text-gray-700">Jenis
                                Pendaftaran</label>
                            <input type="text" id="jenis_pendaftaran" wire:model="jenis_pendaftaran"
                                name="jenis_pendaftaran"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jenis_pendaftaran')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_masuk_kuliah" class="block text-sm font-medium text-gray-700">Tanggal
                                Masuk Kuliah</label>
                            <input type="date" id="tanggal_masuk_kuliah" wire:model="tanggal_masuk_kuliah"
                                name="tanggal_masuk_kuliah"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('tanggal_masuk_kuliah')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="NIK" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" id="NIK" wire:model="NIK" name="NIK"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('NIK')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tempat_lahir"
                                class="block text-sm font-medium text-gray-700">tempat_lahir</label>
                            <input type="text" id="tempat_lahir" wire:model="tempat_lahir" name="tempat_lahir"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('tempat_lahir')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal
                                Lahir</label>
                            <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir" name="tanggal_lahir"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('tanggal_lahir')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jenis_tempat_tinggal" class="block text-sm font-medium text-gray-700">Jenis
                                Tempat Tinggal</label>
                            <input type="text" id="jenis_tempat_tinggal" wire:model="jenis_tempat_tinggal"
                                name="jenis_tempat_tinggal"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jenis_tempat_tinggal')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="telp_rumah" class="block text-sm font-medium text-gray-700">Telp
                                Rumah</label>
                            <input type="text" id="telp_rumah" wire:model="telp_rumah" name="telp_rumah"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('telp_rumah')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">No
                                HP</label>
                            <input type="text" id="no_hp" wire:model="no_hp" name="no_hp"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('no_hp')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" wire:model="email" name="email"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('email')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="terima_kps" class="block text-sm font-medium text-gray-700">Terima
                                KPS</label>
                            <input type="text" id="terima_kps" wire:model="terima_kps" name="terima_kps"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('terima_kps')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="no_kps" class="block text-sm font-medium text-gray-700">No
                                KPS</label>
                            <input type="text" id="no_kps" wire:model="no_kps" name="no_kps"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('no_kps')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jenis_transportasi" class="block text-sm font-medium text-gray-700">Jenis
                                Transportasi</label>
                            <input type="text" id="jenis_transportasi" wire:model="jenis_transportasi"
                                name="jenis_transportasi"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jenis_transportasi')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kode_pt_asal" class="block text-sm font-medium text-gray-700">Kode Perguruan
                                Tinggi
                                Asal</label>
                            <input type="text" id="kode_pt_asal"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('kode_pt_asal')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_pt_asal" class="block text-sm font-medium text-gray-700">Nama Perguruan
                                Tinggi Asal</label>
                            <input type="text" id="nama_pt_asal"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('nama_pt_asal')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        


                        <!-- Submit Button inside the form -->
                        <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                            <button type="button" @click="isOpen = false"
                                class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Close</button>
                            <button type="submit"
                                class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
