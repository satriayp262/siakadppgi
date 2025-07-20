<?php

namespace App\Livewire\Dosen\Bobot\Kelas;

use App\Models\Bobot;
use App\Models\Kelas;
use App\Models\KHS;
use App\Models\KonversiNilai;
use App\Models\KRS;
use App\Models\Matakuliah;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $id_kelas, $kode_mata_kuliah, $id_mata_kuliah;
    public $tugas, $uts, $uas, $partisipasi, $nidn;

    public function mount()
    {
        $matkul = Matakuliah::where('kode_mata_kuliah', $this->kode_mata_kuliah)
            ->where('NIDN', $this->nidn)->first();
        $this->id_mata_kuliah = $matkul->id_mata_kuliah;

        $bobot = null;
        $bobot = Bobot::firstOrCreate([
            'id_kelas' => $this->id_kelas,
            'id_mata_kuliah' => $this->id_mata_kuliah
        ]);


        $this->tugas = $bobot->tugas;
        $this->uts = $bobot->uts;
        $this->uas = $bobot->uas;
        $this->partisipasi = $bobot->partisipasi;
    }

    public function rules()
    {
        return [
            'tugas' => ['required', 'numeric', 'min:1'],
            'uts' => ['required', 'numeric', 'min:1'],
            'uas' => ['required', 'numeric', 'min:1'],
            'partisipasi' => ['required', 'numeric', 'min:1'],
        ];
    }

    protected function customMessages()
    {
        return [
            'tugas.required' => 'Nilai tugas wajib diisi.',
            'tugas.numeric' => 'Nilai tugas harus berupa angka.',
            'tugas.min' => 'Nilai tugas minimal adalah 1.',

            'uts.required' => 'Nilai UTS wajib diisi.',
            'uts.numeric' => 'Nilai UTS harus berupa angka.',
            'uts.min' => 'Nilai UTS minimal adalah 1.',

            'uas.required' => 'Nilai UAS wajib diisi.',
            'uas.numeric' => 'Nilai UAS harus berupa angka.',
            'uas.min' => 'Nilai UAS minimal adalah 1.',

            'partisipasi.required' => 'Nilai partisipasi wajib diisi.',
            'partisipasi.numeric' => 'Nilai partisipasi harus berupa angka.',
            'partisipasi.min' => 'Nilai partisipasi minimal adalah 1.',

            'error' => 'Jumlah total tugas, UTS, UAS, dan partisipasi harus tepat 100.',
        ];
    }

    protected function customValidation()
    {
        $total = $this->tugas + $this->uts + $this->uas + $this->partisipasi;
        if ($total !== 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => $this->customMessages()['error'],
            ]);
        }
    }

    public function update()
    {
        // dd('wut');
        $validatedData = $this->validate($this->rules(), $this->customMessages());

        // Custom validation for the sum
        $this->customValidation();

        $kelas = Bobot::where('id_kelas', $this->id_kelas)->where('id_mata_kuliah', $this->id_mata_kuliah)->first();

        if ($validatedData['partisipasi'] == ' ' || $validatedData['partisipasi'] == 0) {
            $validatedData['partisipasi'] = null;
        }
        if ($kelas) {
            $kelas->update([
                'tugas' => $validatedData['tugas'],
                'uts' => $validatedData['uts'],
                'uas' => $validatedData['uas'],
                'partisipasi' => $validatedData['partisipasi'],
            ]);

            $this->calculate();
            $this->dispatch('kelasUpdated');
        }
    }

    public function calculate()
    {

        // Retrieve the KRS data for the given NIM and semester
        $krsData = KRS::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->get();

        // Loop through each KRS record
        $cek = 1;

        foreach ($krsData as $krs) {

           if (KonversiNilai::where('id_krs', $krs->id_krs)->exists()) {
                $bobot = KonversiNilai::where('id_krs', $krs->id_krs)->first()->nilai;
            } else {
                $bobot = KHS::calculateBobot($krs->id_semester, $krs->NIM, $krs->id_mata_kuliah, $krs->id_kelas);
            }
            // Create a new KHS entry for this specific class and bobot
            KHS::updateOrCreate([
                'id_krs' => $krs->id_krs
            ], [
                'bobot' => $bobot
            ]);
        }

    }


    public function render()
    {

        return view('livewire.dosen.bobot.kelas.edit');
    }
}
