<?php

namespace App\Livewire\Admin\Pertanyaan;

use App\Models\Pertanyaan;
use Livewire\Component;

class Create extends Component
{

    public $nama_pertanyaan;

    public function rules()
    {
        return [
            'nama_pertanyaan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_pertanyaan.required' => 'Nama pertanyaan wajib diisi.',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        $pertanyaan = Pertanyaan::create([
            'nama_pertanyaan' => $validatedData['nama_pertanyaan'],
        ]);

        $this->reset();
        $this->dispatch('PertanyaanCreated');
        return $pertanyaan;
    }

    public function render()
    {
        return view('livewire.admin.pertanyaan.create');
    }
}
