<div x-data="{ isOpen: true }" @modal-closed.window="isOpen = false">
    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Update Pembayaran Cicilan</h3>
                <div @click="isOpen=false; window.location.reload();" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4 text-left">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit.prevent="save">
                        <input type="text" hidden wire:model="id_tagihan">
                        <div class="mb-4">
                            <label for="total_tagihan" class="block text-sm font-medium text-gray-700">Total
                                Tagihan</label>
                            <input type="text" disabled id="total_tagihan_display"
                                value="Rp {{ number_format($total_tagihan, 0, ',', '.') }}"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('total_tagihan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="id_semester" class="block text-sm font-medium text-gray-700">Semester</label>
                            <input type="text" disabled id="id_semester" wire:model="id_semester" name="id_semester"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('id_semester')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_pembayaran" class="block text-sm font-medium text-gray-700">Tanggal
                                Pembayaran</label>
                            <input type="date" id="tanggal_pembayaran" wire:model="tanggal_pembayaran"
                                name="tanggal_pembayaran"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('tanggal_pembayaran')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                            <select id="bulan" wire:model="bulan" name="bulan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                <option value="">Pilih Bulan</option>
                                @foreach ($bulan as $b)
                                    <option value="{{ $b }}">{{ $b }}</option>
                                @endforeach
                            </select>
                            @error('bulan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="total_bayar" class="block text-sm font-medium text-gray-700">Jumlah
                                Pembayaran</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-2 py-1 mt-1 text-sm text-gray-900 bg-gray-200 border-gray-700 rounded-l-md">Rp.</span>
                                <input type="text" id="total_bayar" wire:model="total_bayar" name="total_bayar"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-r-md shadow-2xl sm:text-sm"
                                    oninput="formatCurrency(this)">
                            </div>
                            @error('total_bayar')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>




                        <!-- Submit Button inside the form -->
                        <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                            <button type="button" @click="isOpen = false; window.location.reload();"
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

        // Set the actual model value as the unformatted integer value (without dots or commas)
        @this.set('total_bayar', value.replace(/[^0-9]/g, ''));
    }
</script>
