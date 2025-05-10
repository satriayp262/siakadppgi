<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
        Bayar Sebagian
    </button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Update Pembayaran Cicilan</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4 text-left">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <form wire:submit="update">
                        <input type="text" hidden wire:model="id_tagihan">

                        <div class="mb-4">
                            <label for="NIM" class="block text-sm font-medium text-gray-700">Pembayaran
                                Tagihan</label>
                            <input type="text" disabled id="jenis_tagihan" wire:model="jenis_tagihan"
                                name="jenis_tagihan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                            @error('jenis_tagihan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

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
                            <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                            <select id="bulan" wire:model="bulan" name="bulan"
                                class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                <option disabled value="">Pilih Bulan</option>
                                @foreach ($listbulan as $b)
                                    <option value="{{ $b }}">{{ $b }}</option>
                                @endforeach
                            </select>
                            @error('bulan')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="total_bayar" class="block text-sm font-medium text-gray-700">Nominal
                                yang harus dibayarkan</label>
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
