<?php

namespace App\Livewire\Admin\Prodi;

use Livewire\Component;
use App\Models\Prodi;

class Edit extends Component
{
    public $id_prodi;
    public $kode_prodi;
    public $nama_prodi;


    public function rules()
    {
        return [
            'kode_prodi' => 'required|string|unique:prodi,kode_prodi,' . $this->id_prodi . ',id_prodi',
            'nama_prodi' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'kode_prodi.unique' => 'Kode prodi sudah dipakai',
            'kode_prodi.required' => 'Kode prodi tidak boleh kosong',
            'nama_prodi.required' => 'Nama prodi tidak boleh kosong',
        ];
    }

    public function clear($id_prodi)
    {
        $this->dispatch('refreshComponent');
        $prodi = Prodi::find($id_prodi);
        if ($prodi) {
            $this->id_prodi = $prodi->id_prodi;
            $this->kode_prodi = $prodi->kode_prodi;
            $this->nama_prodi = $prodi->nama_prodi;
        }
    }

    public function mount($id_prodi)
    {
        $prodi = Prodi::find($id_prodi);
        if ($prodi) {
            $this->id_prodi = $prodi->id_prodi;
            $this->kode_prodi = $prodi->kode_prodi;
            $this->nama_prodi = $prodi->nama_prodi;
        }
        return $prodi;
    }

    public function update()
    {
        $validatedData = $this->validate();

        $prodi = Prodi::find($this->id_prodi);
        if ($prodi) {
            // Update data matkul dengan data yang sudah divalidasi
            $prodi->update($validatedData);

            // Reset form dan dispatch event
            $this->clear($this->id_prodi);
            $this->dispatch('ProdiUpdated');
        }
    }

    public function render()
    {
        return view('livewire.admin.prodi.edit');
    }
}
