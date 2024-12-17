<?php

namespace App\Livewire\Dosen\Bobot\Kelas;

use App\Models\Kelas;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $id_kelas;
    public $tugas, $uts, $uas, $lainnya;

    public function mount()
    {
        $kelas = null;
        $kelas = Kelas::where('id_kelas', $this->id_kelas)->first();
        $this->tugas = $kelas->tugas;
        $this->uts = $kelas->uts;
        $this->uas = $kelas->uas;
        $this->lainnya = $kelas->lainnya;
    }

    public function rules()
    {
        return [
            'tugas' => ['required', 'numeric', 'min:1'],
            'uts' => ['required', 'numeric', 'min:1'],
            'uas' => ['required', 'numeric', 'min:1'],
            'lainnya' => ['nullable', 'numeric'],
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

            'lainnya.numeric' => 'Nilai lainnya harus berupa angka.',

            'error' => 'Jumlah total tugas, UTS, UAS, dan lainnya harus tepat 100.',
        ];
    }

    protected function customValidation()
    {
        $total = $this->tugas + $this->uts + $this->uas + $this->lainnya;
        if ($total !== 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => $this->customMessages()['error'],
            ]);
        }
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules(), $this->customMessages());

        // Custom validation for the sum
        $this->customValidation();

        $kelas = Kelas::find($this->id_kelas);

        if ($validatedData['lainnya'] == ' ' || $validatedData['lainnya'] == 0) {
            $validatedData['lainnya'] = null;
        }
        if ($kelas) {
            $kelas->update([
                'tugas' => $validatedData['tugas'],
                'uts' => $validatedData['uts'],
                'uas' => $validatedData['uas'],
                'lainnya' => $validatedData['lainnya'],
            ]);
            $this->dispatch('kelasUpdated');
        }
    }


    public function render()
    {

        return view('livewire.dosen.bobot.kelas.edit');
    }
}
