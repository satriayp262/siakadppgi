<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Semester;
use Livewire\Component;
use App\Models\PeriodeEMonev;

class Create extends Component
{

    public $id_semester;
    public $sesi;
    public $tanggal_mulai;
    public $tanggal_selesai;


    public function rules()
    {
        return [
            'id_semester' => 'required',
            'sesi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ];
    }

    public function messages()
    {
        return [
            'id_semester.required' => 'Semester tidak boleh kosong',
            'tanggal_mulai.required' => 'Tanggal Mulai tidak boleh kosong',
            'sesi.required' => 'Sesi tidak boleh kosong',
            'tanggal_mulai.date' => 'Tanggal Mulai harus berupa tanggal',
            'tanggal_selesai.date' => 'Tanggal Selesai harus berupa tanggal',
            'tanggal_selesai.after' => 'Tanggal Selesai harus setelah Tanggal Mulai',
            'tanggal_selesai.required' => 'Tanggal Selesai tidak boleh kosong',
        ];
    }

    public function save()
    {

        $validatedData = $this->validate();

        $periode = PeriodeEMonev::create([
            'id_semester' => $validatedData['id_semester'],
            'sesi' => $validatedData['sesi'],
            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],

        ]);

        $this->reset('sesi', 'id_semester', 'tanggal_mulai', 'tanggal_selesai');
        $this->dispatch('PeriodeCreated');

        return $periode;
    }


    public function render()
    {
        $semesters = Semester::all();
        return view('livewire.admin.periode.create', [
            'semesters' => $semesters
        ]);
    }
}
