<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between mt-2 space-x-4">
            <div class="flex justify-left items-center">
                <nav aria-label="Breadcrumb">
                    <button onclick="window.history.back()"
                        class="text-sm font-medium text-white hover:text-gray-300 flex items-center bg-blue-500 py-1 px-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m14 8-4 4 4 4" />
                        </svg>
                        Kembali
                    </button>
                </nav>
            </div>
            <div class="flex justify-between items-center space-x-6">
                <h1>Dosen: <span class="font-bold text-customPurple">{{ $matkul->dosen->nama_dosen }}</span></h1>
                <h1>Kelas: <span class="font-bold text-customPurple">INI KELAS</span></h1>
            </div>
        </div>

        <!-- FORM START -->
        <form wire:submit.prevent="save">
            <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
                <table class="min-w-full mt-4 bg-white border border-gray-200">
                    <thead>
                        <tr class="text-sm text-white bg-customPurple">
                            <th class="px-4 py-2 text-center">No.</th>
                            <th class="px-4 py-2 text-center">Nama Pertanyaan</th>
                            <th class="px-4 py-2 text-center">Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pertanyaans as $index => $pertanyaan)
                            <tr class="border-t" wire:key="pertanyaan-{{ $pertanyaan->id }}">
                                <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $pertanyaan->nama_pertanyaan }}</td>
                                <td class="px-4 py-2 text-center">
                                    <div class="flex justify-center space-x-4">
                                        @for ($i = 6; $i <= 10; $i++)
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="jawaban_{{ $pertanyaan->id_pertanyaan }}"
                                                    value="{{ $i }}"
                                                    class="form-radio text-purple-600 focus:ring-purple-500 score-input"
                                                    data-pertanyaan-id="{{ $pertanyaan->id_pertanyaan }}">
                                                <span class="ml-1">{{ $i }}</span>
                                            </label>
                                        @endfor
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Submit Button -->
                <div class="flex justify-between mt-6">
                    <div class="">
                        <span>Skor yang didapat adalah : </span>
                        <span class="font-bold text-customPurple" id="skor">0</span>
                    </div>

                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-lg justify-end">
                        Submit Jawaban
                    </button>
                </div>
            </div>
        </form>
        <!-- FORM END -->

        @if (session()->has('success'))
            <div class="mt-4 text-green-600 text-center">
                {{ session('success') }}
            </div>
        @endif
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scoreInputs = document.querySelectorAll('.score-input');
        const skorElement = document.getElementById('skor');

        function calculateSkor() {
            let totalSkor = 0;
            const selectedRadios = document.querySelectorAll('.score-input:checked');

            selectedRadios.forEach(radio => {
                totalSkor += parseInt(radio.value);
            });

            skorElement.textContent = totalSkor;
        }

        scoreInputs.forEach(input => {
            input.addEventListener('change', calculateSkor);
        });
    });
</script>
