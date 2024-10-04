<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Tagihan;
use Livewire\Component;
use App\Models\Mahasiswa;

class Create extends Component
{
    public $nim;
    public $nama;
    public $total_tagihan;
    public $id_semester;
    public $status = '';

    public function rules()
    {
        return [
            'nim' => 'required|exists:mahasiswa,nim',
            'nama' => 'required',
            'total_tagihan' => 'required|numeric',
            'status' => 'required|in:Belum Lunas,Lunas',
        ];
    }

    public function messages()
    {
        return [
            'nim.exists' => 'NIM tidak ditemukan',
            'nim.required' => 'NIM tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'status.required' => 'Status harus dipilih',
        ];
    }

    public function save()
    {
       
        $validatedData = $this->validate();

        $tagihan = Tagihan::create([
            'nim' => $validatedData['nim'],
            'total_tagihan' => $validatedData['total_tagihan'],
            'status' => $validatedData['status'],
        ]);

        $this->reset();

        $this->dispatch('TagihanCreated');

        return $tagihan ;


    }

    public function render()
    {
        return view('livewire.staff.tagihan.create');
    }
}
