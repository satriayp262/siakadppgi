<?php

namespace App\Livewire\Admin\Pertanyaan;

use App\Models\Pertanyaan;
use Livewire\Component;

class Create extends Component
{

    public $nama_pertanyaan = [];

    public $total_pertanyaan = 1;

    public function rules()
    {
        return [
            'nama_pertanyaan' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nama_pertanyaan.required' => 'Nama pertanyaan wajib diisi.',
            'nama_pertanyaan.string' => 'Nama pertanyaan harus berupa string.',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate([
            'nama_pertanyaan.*' => 'required|string|max:255',
        ]);

        foreach ($validatedData['nama_pertanyaan'] as $pertanyaan) {
            Pertanyaan::create([
                'nama_pertanyaan' => $pertanyaan,
            ]);
        }

        $this->reset();
        $this->dispatch('PertanyaanCreated');
        session()->flash('message', 'Pertanyaan berhasil disimpan.');
    }

    public function render()
    {

        return view('livewire.admin.pertanyaan.create', [

        ]);
    }
}
