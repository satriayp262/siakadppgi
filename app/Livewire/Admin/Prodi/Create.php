<?php

namespace App\Livewire\Admin\Prodi;

use App\Models\Prodi;
use Livewire\Component;

class Create extends Component
{
    public $kode_prodi;
    public $nama_prodi;
    public $jenjang = '';

    public function rules()
    {
        return [
            'kode_prodi' => 'required|string|unique:prodi,kode_prodi',
            'nama_prodi' => 'required|string',
            'jenjang' => 'required|in:D3,D4,S1',
        ];
    }

    public function messages()
    {
        return [
            'kode_prodi.unique' => 'Kode prodi sudah dipakai',
            'kode_prodi.required' => 'Kode prodi tidak boleh kosong',
            'nama_prodi.required' => 'Nama prodi tidak boleh kosong',
            'jenjang.required' => 'Jenjang harus dipilih',
        ];
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();

        $prodi = Prodi::create([
            'kode_prodi' => $validatedData['kode_prodi'],
            'nama_prodi' => $validatedData['nama_prodi'],
            'jenjang' => $validatedData['jenjang'],
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
