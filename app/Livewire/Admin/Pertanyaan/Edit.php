<?php

namespace App\Livewire\Admin\Pertanyaan;

use App\Models\Pertanyaan;
use Livewire\Component;

class Edit extends Component
{

    public $nama_pertanyaan;
    public $id_pertanyaan;

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

    public function mount($id_pertanyaan)
    {
        $pertanyaan = Pertanyaan::find($id_pertanyaan);
        if ($pertanyaan) {
            $this->id_pertanyaan = $pertanyaan->id_pertanyaan;
            $this->nama_pertanyaan = $pertanyaan->nama_pertanyaan;

        }
        return $pertanyaan;
    }

    public function update()
    {
        $validatedData = $this->validate();
        $pertanyaan = Pertanyaan::find($this->id_pertanyaan);
        $pertanyaan->update([
            'nama_pertanyaan' => $validatedData['nama_pertanyaan'],
        ]);
        $this->reset();
        $this->dispatch('PertanyaanUpdated');
        return $pertanyaan;
    }

    public function render()
    {
        return view('livewire.admin.pertanyaan.edit');
    }
}
