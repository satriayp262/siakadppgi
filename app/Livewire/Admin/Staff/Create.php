<?php

namespace App\Livewire\Admin\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public $nama_staff;
    public $ttd;
    public $nip;
    public $email;

    use WithFileUploads;

    public function rules()
    {
        return [
            'nama_staff' => 'required|string',
            'ttd' => 'required|file|mimes:jpg,png|max:1024',
            'nip' => 'required|string',
            'email' => 'required|email|unique:staff,email',
        ];
    }

    public function messages()
    {
        return [
            'nama_staff.required' => 'Nama staff tidak boleh kosong',
            'ttd.required' => 'Tanda tangan tidak boleh kosong',
            'ttd.mimes' => 'Tanda tangan harus berupa file gambar (jpg, png)',
            'nip.required' => 'NIP tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
        ];
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();

        $imageName = $this->nama_staff . '_' . time() . '.' . $this->ttd->extension();

        $this->ttd->storeAs('public/image/ttd', $imageName);

        $staff = Staff::create([
            'nama_staff' => $validatedData['nama_staff'],
            'ttd' => $imageName,
            'nip' => $validatedData['nip'],
            'email' => $validatedData['email'],
        ]);

        $staff = User::create([
            'name' => $validatedData['nama_staff'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['email']),
            'role' => 'staff',
            'nim_nidn' => $validatedData['nip'],
        ]);

        $this->reset();

        $this->dispatch('StaffCreated');

        return $staff;
    }
    public function render()
    {
        return view('livewire.admin.staff.create');
    }
}
