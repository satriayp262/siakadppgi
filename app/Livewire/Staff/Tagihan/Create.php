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
    public $status_tagihan = '';
    public $Bulan = '';
    public $id_semester;

    public function rules()
    {
        return [
            'nim' => 'required',
            'total_tagihan' => 'required',
            'Bulan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nim.required' => 'nim tidak boleh kosong',
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'Bulan.required' => 'Bulan harus dipilih',
        ];
    }

    public function mount($nim, $nama)
    {
        $this->nim = $nim;
        $this->nama = $nama;
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $this->id_semester = $mahasiswa ? $mahasiswa->mulai_semester : null;
    }



    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

        $tagihan = Tagihan::create([
            'NIM' => $validatedData['nim'],
            'total_tagihan' => $validatedData['total_tagihan'],
            'status_tagihan' => 'Belum Lunas',
            'Bulan' => $validatedData['Bulan'],
            'id_semester' => $this->id_semester,
        ]);
        $this->dispatch('TagihanCreated');
        $this->reset();
        return $tagihan;
    }

    public function render()
    {
        $mahasiswas = Mahasiswa::all();
        return view('livewire.staff.tagihan.create', [
            'mahasiswas' => $mahasiswas
        ]);
    }
}
