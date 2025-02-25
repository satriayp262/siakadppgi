<!-- Wrapper -->
<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4 mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li>
                        <div class="flex items-center">
                            <a href="{{ route('mahasiswa.emonev', ['nama_semester' => $semester]) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center ms-1 md:ms-2">
                                {{ $semester }}
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">
                                {{ $matkul->nama_mata_kuliah }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Dosen dan Kelas sejajar -->
            <div class="flex flex-col md:flex-row items-center gap-x-6">
                <h1 class="text-lg font-semibold">
                    Dosen: <span class="text-customPurple">{{ $matkul->dosen->nama_dosen }}</span>
                </h1>
                <h1 class="text-lg font-semibold">
                    Kelas: <span class="text-customPurple">{{ $kelas->nama_kelas }}</span>
                </h1>
            </div>
        </div>
        <!-- FORM START -->
        @if ($mahasiswaemonev == 2)
            <div class="bg-white shadow-lg p-6 mt-6 rounded-lg">
                <div class="overflow-x-auto">
                    <h3>Emonev sudah diisi</h3>
                </div>
            </div>
        @else
            <form wire:submit.prevent="save">
                <div class="bg-white shadow-lg p-6 mt-6 rounded-lg">
                    <div class="overflow-x-auto">
                        <div class="p-4 bg-white shadow-md rounded-lg border border-gray-200">
                            <h2 class="text-purple2 text-2xl font-extrabold mb-2">Evaluasi Dosen dan Perkuliahan</h2>
                            <p class="text-gray-700 text-md font-medium">1. Anda tidak perlu memasukkan nama, dan
                                jawaban Anda akan dijamin kerahasiaannya.</p>
                            <p class="text-gray-700 text-md font-medium">2. Silakan isi dengan seobjektif mungkin
                                sesuai pendapat Anda dengan memilih nilai yang
                                paling sesuai..</p>
                            <p class="text-gray-700 text-md font-semibold">3. Keterangan nilai: </p>
                            <div class="flex flex-wrap items-center gap-4 ml-5 mt-3">
                                @foreach ([6 => 'red', 7 => 'purple', 8 => 'yellow', 9 => 'green', 10 => 'blue'] as $value => $color)
                                    <div class="flex items-center">
                                        <span
                                            class="w-8 h-8 flex items-center justify-center bg-{{ $color }}-500 text-white font-semibold rounded-full mr-2">{{ $value }}</span>
                                        <span class="text-gray-700">
                                            {{ ['Kurang', 'Cukup', 'Baik', 'Sangat Baik', 'Istimewa'][$value - 6] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <table class="w-full border border-gray-300">
                            <thead>
                                <tr class="bg-customPurple text-white text-center">
                                    <th class="px-4 py-3">No.</th>
                                    <th class="px-4 py-3">Pertanyaan</th>
                                    <th class="px-4 py-3">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pertanyaans as $pertanyaan)
                                    <tr class="border-t" wire:key="pertanyaan-{{ $pertanyaan->id_pertanyaan }}">
                                        <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $pertanyaan->nama_pertanyaan }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <div class="flex justify-center space-x-4">
                                                @for ($i = 6; $i <= 10; $i++)
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="radio"
                                                            wire:model.defer="jawaban.{{ $pertanyaan->id_pertanyaan }}"
                                                            name="jawaban_{{ $pertanyaan->id_pertanyaan }}"
                                                            value="{{ $i }}" class="form-radio score-input">
                                                        <span
                                                            class="ml-1 text-sm font-medium">{{ $i }}</span>
                                                    </label>
                                                @endfor
                                            </div>
                                            @error('jawaban')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Input Saran -->
                    <div class="mt-4">
                        <label class="block font-semibold text-gray-700">Saran untuk Bapak / Ibu Dosen :</label>
                        <textarea wire:model="saran" class="w-full border border-gray-300 rounded-lg p-3 mt-2" rows="3"
                            placeholder="Masukkan saran..."></textarea>
                        @error('saran')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit & Score -->
                    <div class="flex flex-col md:flex-row justify-between items-center mt-6">
                        <div class="text-lg font-semibold">
                            Skor: <span class="text-customPurple" id="skor">0</span>
                        </div>
                        <button type="submit"
                            class="bg-purple2 hover:bg-customPurple text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-transform hover:scale-105">
                            Submit Jawaban
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('change', function() {
            let totalSkor = [...document.querySelectorAll('.score-input:checked')]
                .reduce((sum, radio) => sum + parseInt(radio.value), 0);

            document.getElementById('skor').textContent = totalSkor;
        });
    });
</script>
