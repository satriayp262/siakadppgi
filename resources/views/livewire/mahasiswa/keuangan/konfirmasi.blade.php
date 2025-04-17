<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold">Konfirmasi Pembayaran</h1>
                <p class="text-sm text-gray-500">Halaman ini ditunjukan untuk konfirmasi pembayaran melalui rekening PPGI
                </p>
            </div>
            <div class="flex flex-col mt-4">
                <form wire:submit="save">

                    <div class="mb-4">
                        <label for="id_tagihan" class="block text-sm font-medium text-gray-700">Tagihan</label>
                        <select id="id_tagihan" wire:model.live="id_tagihan" name="id_tagihan"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                            @if ($tagihan->isEmpty())
                                <option value="" disabled selected>Tidak ada tagihan</option>
                            @else
                                <option value="" disabled selected>Pilih Tegihan</option>
                                @foreach ($tagihan as $x)
                                    <option value="{{ $x->id_tagihan }}">
                                        {{ $x->jenis_tagihan . ' (' . $x->semester->nama_semester . ')' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('id_tagihan')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <span
                            class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            {{ $mahasiswa->NIM }}
                        </span>
                        @error('nim')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_pembayaran" class="block text-sm font-medium text-gray-700">Tanggal
                            Pembayaran</label>
                        <input type="date" id="tanggal_pembayaran" wire:model.live="tanggal_pembayaran"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm" />
                        @error('tanggal_pembayaran')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                        <input type="text" id="jumlah" wire:model.live="jumlah"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm"
                            placeholder="Masukkan Jumlah Pembayaran" />
                        @error('jumlah')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bukti" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
                        <input type="file" id="bukti" wire:model.live="bukti"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm"
                            placeholder="Masukkan Bukti Pembayaran" />
                        @error('bukti')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror

                        @if ($bukti)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-1">Preview:</p>
                                <img src="{{ $bukti->temporaryUrl() }}" class="max-h-128 rounded-md shadow border"
                                    alt="Preview Bukti Pembayaran">
                            </div>
                        @endif
                    </div>



                    <!-- Submit Button inside the form -->
                    <div class="flex justify-left p-4 bg-gray-200 rounded-b-lg">

                        <button type="submit"
                            class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
