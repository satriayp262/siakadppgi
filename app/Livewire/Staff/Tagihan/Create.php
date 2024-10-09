<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\Component;
use App\Models\Mahasiswa;

class Create extends Component
{
    public $nim;
    public $nama;
    public $total_tagihan;
    public $id_semester = '';
    public $status_tagihan = '';

    public function rules()
    {
        return [
            'nim' => 'required',
            'total_tagihan' => 'required|numeric',
            'status_tagihan' => 'required|in:Belum Lunas,Lunas',
            'id_semester' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nim.required' => 'nim tidak boleh kosong',
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'status_tagihan.required' => 'Status harus dipilih',
            'semester.required' => 'Semester harus dipilih',
        ];
    }

    public function mount($nim, $nama)
    {
        $this->nim = $nim;
        $this->nama = $nama;
    }

    public function save()
    {
        $validatedData = $this->validate();

        $tagihan = Tagihan::create([
            'NIM' => $validatedData['nim'],
            'total_tagihan' => $validatedData['total_tagihan'],
            'status_tagihan' => $validatedData['status_tagihan'],
            'id_semester' => $validatedData['id_semester'],
        ]);

        $this->reset();

        $this->dispatch('TagihanCreated');

        return $tagihan;
    }

    public function render()
    {
        $mahasiswas = Mahasiswa::all();
        $semesters = Semester::all();
        return view('livewire.staff.tagihan.create', [
            'semesters' => $semesters,
            'mahasiswas' => $mahasiswas
        ]);
    }
}
