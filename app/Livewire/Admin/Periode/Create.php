<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Semester;
use Livewire\Component;
use App\Models\PeriodeEMonev;

class Create extends Component
{

    public $id_semester;
    public $tanggal_mulai_1;
    public $tanggal_selesai_1;
    public $tanggal_mulai_2;
    public $tanggal_selesai_2;


    public function rules()
    {
        return [
            'id_semester' => 'required',
            'tanggal_mulai_1' => 'required|date',
            'tanggal_selesai_1' => 'required|date|after:tanggal_mulai_1',
            'tanggal_mulai_2' => 'required|date',
            'tanggal_selesai_2' => 'required|date|after:tanggal_mulai_2',
        ];
    }

    public function messages()
    {
        return [
            'id_semester.required' => 'Semester tidak boleh kosong',
            'tanggal_mulai_1.required' => 'Tanggal mulai tidak boleh kosong',
            'tanggal_selesai_1.required' => 'Tanggal selesai tidak boleh kosong',
            'tanggal_selesai_1.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'tanggal_mulai_2.required' => 'Tanggal mulai tidak boleh kosong',
            'tanggal_selesai_2.required' => 'Tanggal selesai tidak boleh kosong',
            'tanggal_selesai_2.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'tanggal_mulai_1.date' => 'Tanggal mulai harus berupa tanggal yang valid',
            'tanggal_selesai_1.date' => 'Tanggal selesai harus berupa tanggal yang valid',
            'tanggal_mulai_2.date' => 'Tanggal mulai harus berupa tanggal yang valid',
            'tanggal_selesai_2.date' => 'Tanggal selesai harus berupa tanggal yang valid',
        ];
    }

    public function save()
    {

        $validatedData = $this->validate();
        $namaSemester = Semester::find($validatedData['id_semester'])->nama_semester;
        $existingPeriode = PeriodeEMonev::where('id_semester', $validatedData['id_semester'])
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('tanggal_mulai', [$validatedData['tanggal_mulai_1'], $validatedData['tanggal_selesai_2']])
                    ->orWhereBetween('tanggal_selesai', [$validatedData['tanggal_mulai_1'], $validatedData['tanggal_selesai_2']]);
            })
            ->exists();
        if ($existingPeriode) {
            $this->dispatch('PeriodeExists');
            return;
        }
        $periode1 = PeriodeEMonev::create([
            'id_semester' => $validatedData['id_semester'],
            'nama_periode' => $namaSemester . '/1',
            'sesi' => 1,
            'tanggal_mulai' => $validatedData['tanggal_mulai_1'],
            'tanggal_selesai' => $validatedData['tanggal_selesai_1'],
        ]);

        $periode2 = PeriodeEMonev::create([
            'id_semester' => $validatedData['id_semester'],
            'nama_periode' => $namaSemester . '/2',
            'sesi' => 2,
            'tanggal_mulai' => $validatedData['tanggal_mulai_2'],
            'tanggal_selesai' => $validatedData['tanggal_selesai_2'],
        ]);

        $this->reset([
            'id_semester',
            'tanggal_mulai_1',
            'tanggal_selesai_1',
            'tanggal_mulai_2',
            'tanggal_selesai_2'
        ]);

        $this->dispatch('PeriodeCreated');
        return $periode1 && $periode2;
    }


    public function render()
    {
        $semesters = Semester::all();
        return view('livewire.admin.periode.create', [
            'semesters' => $semesters
        ]);
    }
}
