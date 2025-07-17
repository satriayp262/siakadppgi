<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen = true" x-bind:disabled="!@entangle('isWaktuAktif')"
        x-bind:title="!@entangle('isWaktuAktif') ? 'Tidak ada jadwal aktif saat ini' : ''"
        class="flex items-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
        Buat Token
    </button>

    <div x-data="{ load: false }" x-show="isOpen && load" x-init="load = true" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Buat Token</h3>
                <button @click="isOpen=false"
                    class="text-gray-900 px-3 rounded-sm shadow hover:bg-red-500 hover:text-white">&times;</button>
            </div>

            <div class="p-4">
                <form wire:submit.prevent="save" class="space-y-4">
                    {{-- Mata Kuliah --}}
                    <div>
                        <label for="id_mata_kuliah" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                        <input type="text" id="id_mata_kuliah" value="{{ $nama_mata_kuliah }}" disabled
                            class="w-full px-3 py-2 mt-1 bg-gray-200 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="id_kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <input type="text" id="id_kelas" value="{{ $nama_kelas }}" disabled
                            class="w-full px-3 py-2 mt-1 bg-gray-200 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                    </div>

                    {{-- Valid Until (readonly berdasarkan jadwal aktif) --}}
                    <div>
                        <label for="valid_until" class="block text-sm font-medium text-gray-700">Berlaku
                            Hingga</label>
                        <input type="text" id="valid_until" readonly value="{{ $valid_until }}"
                            class="w-full px-3 py-2 mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                    </div>

                    {{-- Pertemuan --}}
                    <div>
                        <label for="pertemuan" class="block text-sm font-medium text-gray-700">Pertemuan Ke</label>
                        <select id="pertemuan" wire:model.defer="pertemuan"
                            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                            <option value="">-- Pilih Pertemuan --</option>
                            @for ($i = 1; $i <= 16; $i++)
                                @php
                                    $sudahAda = \App\Models\Token::where('id_jadwal', $id_jadwal)
                                        ->where('pertemuan', $i)
                                        ->exists();
                                @endphp
                                <option value="{{ $i }}" @if ($sudahAda) disabled @endif>
                                    Pertemuan {{ $i }} {{ $sudahAda ? '(sudah dibuat)' : '' }}
                                </option>
                            @endfor
                        </select>
                        @error('pertemuan')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end pt-4 border-t">
                        <button type="button" @click="isOpen = false"
                            class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                            Close
                        </button>
                        <button type="submit"
                            class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
