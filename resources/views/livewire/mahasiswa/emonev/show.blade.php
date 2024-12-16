<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        {{-- <h1 class="text-2xl font-bold ">Prodi Table</h1> --}}
        <!-- Modal Form -->
        <div class="flex justify-between mt-2 space-x-4">
            <div class="flex justify-left items-center">
                <nav aria-label="Breadcrumb">
                    <button onclick="window.history.back()"
                        class="text-sm font-medium text-white hover:text-gray-300 flex items-center bg-blue-500 py-1 px-2 rounded-lg justify-around">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m14 8-4 4 4 4" />
                        </svg>
                        Kembali
                    </button>
                </nav>
            </div>
            <div class="flex justify-between items-center space-x-6">
                <h1>Dosen : <span class=" font-bold text-customPurple">{{ $kelas->matkul->dosen->nama_dosen }}</span>
                </h1>
                <h1>Kelas : <span class=" font-bold text-customPurple">{{ $kelas->nama_kelas }}</span></h1>
            </div>
        </div>
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <table class="min-w-full mt-4 bg-white border border-gray-200">
                <thead>
                    <tr class="items-center w-full text-sm text-white align-middle bg-customPurple">
                        <th class="px-4 py-2 text-center">No.</th>
                        <th class="px-4 py-2 text-center">Nama Pertanyaan</th>
                        <th class="px-4 py-2 text-center">Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pertanyaans as $index => $pertanyaan)
                        <tr class="border-t" wire:key="pertanyaan-{{ $pertanyaan->id }}">
                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-left">{{ $pertanyaan->nama_pertanyaan }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center space-x-10">
                                    @for ($i = 6; $i <= 10; $i++)
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model.defer="Jawaban.{{ $index }}"
                                                value="{{ $i }}" class="form-radio"
                                                onclick="handleRadioClick(this, {{ $index }})">
                                            <span class="ml-2">{{ $i }}</span>
                                        </label>
                                    @endfor

                                </div>
                                @error('Jawaban.' . $index)
                                    <small class="text-red-500">{{ $message }}</small>
                                @enderror
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <!-- Pagination Controls -->
            <div class="py-8 mt-4 mb-4 text-center">
                {{-- {{ $prodis->links('') }} --}}
            </div>
        </div>
        <script>
            let clickCount = 0;

            function handleRadioClick(radio, index) {
                clickCount++;
                const radios = document.querySelectorAll(`[wire\\:model\\.defer="Jawaban.${index}"]`);
                if (clickCount === 2) {
                    radios.forEach(r => {
                        r.disabled = false;
                        r.checked = false;
                    });
                    clickCount = 0;
                } else {
                    radios.forEach(r => {
                        if (r !== radio) {
                            r.disabled = true;
                        } else {
                            r.disabled = false;
                        }
                    });
                }
                setTimeout(() => {
                    clickCount = 0;
                }, 300); // Reset click count after 300ms
            }
        </script>
    </div>
