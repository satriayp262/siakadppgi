<?php

namespace App\Livewire\Admin\Ruangan;

use Livewire\Component;
use App\Models\Ruangan;

class Create extends Component
{
    public $kode_ruangan, $nama_ruangan, $kapasitas;

    public function rules(){
        return [
            'kode_ruangan' => 'required|string|unique:ruangan,kode_ruangan',
            'nama_ruangan' => 'required|string',
            'kapasitas' => 'required|numeric',
        ];
    }
    public function messages()  {
        return [
            'kode_ruangan.required' => 'Kode ruangan tidak boleh kosong',
            'kode_ruangan.string' => 'Kode ruangan harus berupa string',
            'kode_ruangan.unique' => 'Kode ruangan sudah dipakai',
            'nama_ruangan.required' => 'Nama ruangan tidak boleh kosong',
            'nama_ruangan.string' => 'Nama ruangan harus berupa string',
            'kapasitas.required' => 'Kapasitas tidak boleh kosong',
            'kapasitas.numeric' => 'Kapasitas harus berupa angka',            
        ];
    }
    public function save(){
        $this->validate();

        Ruangan::create([
            'kode_ruangan' => $this->kode_ruangan,
            'nama_ruangan' => $this->nama_ruangan,
            'kapasitas' => $this->kapasitas 
        ]);
        $this->reset();
        $this->dispatch('ruanganCreated');
        
    }
    public function render()
    {
        return view('livewire.admin.ruangan.create');
    }
}
