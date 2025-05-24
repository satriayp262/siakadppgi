<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center px-3 py-1 font-sm text-white bg-blue-500 rounded hover:bg-blue-700">
        {{-- <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white font-black" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M5 12h14m-7 7V5" />
        </svg> --}}

        Buat Tagihan
    </button>

    <!-- Modal Background -->
    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" wire:init="" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Buat Tagihan</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <div class="p-4 text-left"> <!-- Added text-left here -->
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <input type="text" hidden wire:model="nim">
                        <form wire:submit="save">
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama
                                    Mahasiswa</label>
                                <input type="text" disabled id="nama" wire:model="nama" name="nama"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nama')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                                <input type="text" disabled id="nim" wire:model="nim" name="nim"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                @error('nim')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                                <select id="semester" wire:model.live="semester" name="semester"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                    <option disabled value="">Pilih Semester</option>
                                    @foreach ($semesters as $x)
                                        <option value="{{ $x->id_semester }}">{{ $x->nama_semester }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('semester')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="mb-4">
                                <label for="jenis_tagihan" class="block text-sm font-medium text-gray-700">Jenis
                                    Tagihan</label>
                                <select id="jenis_tagihan" wire:model.live="jenis_tagihan" name="jenis_tagihan"
                                    class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm"@if (empty($semester)) disabled @endif>

                                    <option disabled value="">Pilih Jenis Tagihan</option>
                                    <option value="BPP">BPP Semester
                                        {{ $semesters->firstWhere('id_semester', $semester)->nama_semester ?? 'Tidak ditemukan' }}
                                    </option>
                                    <option value="Lainnya">Lainnya</option>

                                </select>
                                @error('jenis_tagihan')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                            @if ($jenis_tagihan == 'Lainnya')
                                <div class="mb-4">
                                    <label for="tagihan_lain" class="block text-sm font-medium text-gray-700">Jenis
                                        Tagihan
                                        Lainnya</label>
                                    <input type="text" id="tagihan_lain" wire:model="tagihan_lain"
                                        name="tagihan_lain"
                                        class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-md shadow-2xl focus:border-indigo-500 sm:text-sm">
                                </div>
                            @endif
                            @error('tagihan_lain')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror

                            <div class="mb-4">
                                <label for="total_tagihan" class="block text-sm font-medium text-gray-700">Total
                                    Tagihan</label>
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center px-2 py-1 mt-1 text-sm text-gray-900 bg-gray-200 border-gray-700 rounded-l-md">Rp.</span>
                                    <input type="text" id="total_tagihan" wire:model.live="total_tagihan"
                                        name="total_tagihan"
                                        class="block w-full px-2 py-1 mt-1 bg-gray-200 border-gray-700 rounded-r-md shadow-2xl focus:border-indigo-500 sm:text-sm"
                                        oninput="formatCurrency(this)">
                                </div>
                                @error('total_tagihan')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">

                                <div class="flex justify-between items-center mt-2">
                                    <label for="bisa_dicicil" class="block text-sm font-medium text-gray-700">Bisa
                                        Dicicil ?</label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="cicil" value="true" class="sr-only peer">
                                        <div
                                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 ">
                                        </div>
                                    </label>

                                </div>
                                @error('bisa_dicicil')
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
