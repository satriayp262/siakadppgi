<?php

namespace App\Livewire\Staff\Profil;

use Livewire\Component;
use App\Models\Staff;
use Livewire\WithFileUploads;

class Create extends Component
{
    public $nama_staff;
    public $ttd;
    public $nip;

    use WithFileUploads;

    public function rules()
    {
        return [
            'nama_staff' => 'required|string',
            'ttd' => 'required|file|mimes:jpg,png|max:1024',
            'nip' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'nama_staff.required' => 'Nama staff tidak boleh kosong',
            'ttd.required' => 'Tanda tangan tidak boleh kosong',
            'ttd.mimes' => 'Tanda tangan harus berupa file gambar (jpg, png)',
            'nip.required' => 'NIP tidak boleh kosong',
        ];
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();

        $filePath = $this->ttd->store('ttd', 'public');

        $staff = Staff::create([
            'nama_staff' => $validatedData['nama_staff'],
            'ttd' => $filePath,
            'nip' => $validatedData['nip'],
        ]);

        $this->reset();

        $this->dispatch('StaffCreated');

        return $staff;
    }


    public function render()
    {
        return view('livewire.staff.profil.create');
    }
}
