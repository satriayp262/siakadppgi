<div x-data="{ isOpen: true }"@modal-closed.window="isOpen = false">
    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Buat Tagihan Group</h3>
                <div @click="isOpen=false; window.location.reload();" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="save">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Daftar Mahasiswa</label>
                            <div class="bg-gray-100 p-2 rounded-md">
                                @foreach ($mahasiswas as $mhs)
                                    {{ $mhs->nama . ' (' . $mhs->NIM . ')' }} <br>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="jenis_tagihan" class="block text-sm font-medium text-gray-700">Jenis
                                Tagihan</label>
                            <input type="text" id="jenis_tagihan" wire:model="jenis_tagihan" name="jenis_tagihan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm"></input>
                            @error('Keterangan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="total_tagihan" class="block text-sm font-medium text-gray-700">Total
                                Tagihan</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-2 py-1 mt-1 text-sm text-gray-900 bg-gray-200 border-gray-700 rounded-l-md">Rp.</span>
                                <input type="text" id="total_tagihan" wire:model="total_tagihan" name="total_tagihan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-r-md shadow-2xl focus:border-indigo-500 sm:text-sm"
                                    oninput="formatCurrency(this)">
                            </div>
                            @error('total_tagihan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="Bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                            <input type="month" id="Bulan" wire:model="Bulan" name="Bulan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('Bulan')
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
        @this.set('total_tagihan', value.replace(/\./g, ''));
    }
</script>
