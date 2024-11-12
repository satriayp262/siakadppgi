<?php

namespace App\Livewire\Admin\Ruangan;

use Livewire\Component;
use App\Models\Ruangan;

class Edit extends Component
{
    public $kode_ruangan, $nama_ruangan, $kapasitas, $id_ruangan;

    public function rules(){
        return [
            'kode_ruangan' => 'required|string|unique:ruangan,kode_ruangan,' . $this->id_ruangan . ',id_ruangan',
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
    public function mount(){
        $ruangan = Ruangan::find($this->id_ruangan);
        $this->kode_ruangan = $ruangan->kode_ruangan;
        $this->nama_ruangan = $ruangan->nama_ruangan;
        $this->kapasitas = $ruangan->kapasitas;
    }
    public function clear($id_ruangan){
        $ruangan = Ruangan::find($id_ruangan);
        $this->kode_ruangan = $ruangan->kode_ruangan;
        $this->nama_ruangan = $ruangan->nama_ruangan;
        $this->kapasitas = $ruangan->kapasitas;
        }
    public function update(){
        $this->validate();
        $ruangan = Ruangan::find($this->id_ruangan);
        $ruangan->update([
            'kode_ruangan' => $this->kode_ruangan,
            'nama_ruangan' => $this->nama_ruangan,
            'kapasitas' => $this->kapasitas 
        ]);
        $this->reset();
        $this->dispatch('ruanganUpdated');
    }
    public function render()
    {
        return view('livewire.admin.ruangan.edit');
    }
}
