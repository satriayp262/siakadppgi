<?php

namespace App\Livewire\Admin\Prodi;

use App\Models\Prodi;
use Livewire\Component;

class Create extends Component
{
    public $kode_prodi;
    public $nama_prodi;

    public function rules()
    {
        return [
            'kode_prodi' => 'required|string|unique:prodi,kode_prodi',
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

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();

        $prodi = Prodi::create([
            'kode_prodi' => $validatedData['kode_prodi'],
            'nama_prodi' => $validatedData['nama_prodi'],
        ]);

        $this->reset();

        $this->dispatch('ProdiCreated');

        return $prodi;
    }

    public function render()
    {
        return view('livewire.admin.prodi.create');
    }
}
