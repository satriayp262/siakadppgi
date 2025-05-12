<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg">
            <div class="justify-between flex items-center mr-2">
                <div class="flex flex-col">
                    <h1 class="text-2xl font-bold">Konfirmasi Pembayaran</h1>
                    <p class="text-sm text-gray-500">Halaman ini ditunjukan untuk konfirmasi pembayaran bila membayar
                        melalui rekening
                        PPGI
                    </p>
                </div>
                <a wire:navigate.hover href="{{ route('mahasiswa.transaksi.histori') }}" class=" text-blue-500">Histori
                    Pembayaran</a>
            </div>

            <div class="flex flex-col mt-4">
                <form wire:submit="save">
                    <div class="mb-4">
                        <label for="id_tagihan" class="block text-sm font-medium text-gray-700">Guna Pembayaran</label>
                        <select id="id_tagihan" wire:model.live="id_tagihan" name="id_tagihan"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                            <option value="" disabled selected>Pilih Tagihan</option>
                            @if ($tagihan->isEmpty())
                                <option value="" disabled selected>Tidak ada tagihan</option>
                            @else
                                @foreach ($tagihan as $x)
                                    <option value="{{ $x->id_tagihan }}">
                                        {{ $x->jenis_tagihan }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('id_tagihan')
                            <span class="mt-1 text-sm text-red-500">
                                @error('metode_pembayaran')
                                    {{ $message }}
                                @enderror
                            </span>
                        @enderror
                    </div>

                    @php
                        $tagihanDipilih = $tagihan->firstWhere('id_tagihan', $id_tagihan);
                    @endphp

                    @if ($tagihanDipilih)
                        <div class="mb-4">
                            <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode
                                Pembayaran</label>
                            <select id="metode_pembayaran" wire:model.live="metode_pembayaran" name="metode_pembayaran"
                                class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                @if ($tagihanDipilih && $tagihanDipilih->metode_pembayaran == 'Cicilan')
                                    <option value="sebagian">Bayar Sebagian</option>
                                @else
                                    <option value="penuh">Bayar Penuh</option>
                                    <option value="sebagian">Bayar Sebagian</option>
                                @endif
                            </select>
                        </div>
                    @endif
                    @error('metode_pembayaran')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror

                    @if ($tagihanDipilih && $tagihanDipilih->bisa_dicicil && $metode_pembayaran == 'sebagian')
                        @if (!empty($bulan_tersedia))
                            <div class="mb-4">
                                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                                <select id="bulan" wire:model="bulan" name="bulan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                    <option disabled value="">Pilih Bulan</option>
                                    @foreach ($bulan_tersedia as $b)
                                        <option value="{{ $b }}">{{ $b }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endif
                    @error('bulan')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror

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
                        <input type="datetime-local" id="tanggal_pembayaran" wire:model.live="tanggal_pembayaran"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm" />
                        @error('tanggal_pembayaran')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="jumlah_pembayaran" class="block text-sm font-medium text-gray-700">Jumlah
                            Pembayaran</label>
                        <input type="text" id="jumlah_pembayaran" wire:model.live="jumlah_pembayaran"
                            name="jumlah_pembayaran"
                            class="block w-full px-2 py-2 mt-1 bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm"
                            oninput="formatCurrency(this)">
                        @if ($tagihanDipilih)
                            @if ($metode_pembayaran == 'sebagian')
                                <span class="text-sm text-gray-500">Pembayaran Disarankan:
                                    Rp. {{ number_format($tagihanDipilih->total_tagihan / 6, 0, ',', '.') }}</span>
                            @elseif ($metode_pembayaran == 'penuh')
                                <span class="text-sm text-gray-500">Pembayaran Disarankan:
                                    Rp. {{ number_format($tagihanDipilih->total_tagihan, 0, ',', '.') }}</span>
                            @else
                            @endif
                        @endif
                        @error('jumlah_pembayaran')
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
                                <img src="{{ $bukti->temporaryUrl() }}" class="max-h-64 rounded-md shadow border"
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
<script>
    function formatCurrency(input) {
        // Get the value of the input and remove non-numeric characters (except for periods or commas)
        let value = input.value.replace(/[^,\d]/g, '');

        // Format the value into Indonesian Rupiah currency
        let numberString = value.replace(/[^,\d]/g, '').toString(),
            split = numberString.split(','),
            remainder = split[0].length % 3,
            rupiah = split[0].substr(0, remainder),
            thousand = split[0].substr(remainder).match(/\d{3}/gi);

        if (thousand) {
            let separator = remainder ? '.' : '';
            rupiah += separator + thousand.join('.');
        }

        // Combine with decimal if present
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        // Update the displayed value
        input.value = rupiah;

        // Set nilai asli ke Livewire (jumlah_pembayaran)
        if (window.livewire) {
            let component = Livewire.find(input.closest('[wire\\:id]').getAttribute('wire:id'));
            if (component) {
                component.set('jumlah_pembayaran', raw);
            }
        }
    }
</script>
