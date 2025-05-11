<?php

namespace App\Livewire\Admin\Staff;

use App\Models\Staff;
use Livewire\Component;
use Livewire\WithFileUploads;




class Edit extends Component
{
    use WithFileUploads;
    public $nama_staff;
    public $id_staff;
    public $nip;
    public $email;
    public $ttd;
    public $ttd_baru;

    public function mount($id_staff)
    {
        $staff = Staff::find($id_staff);

        if ($staff) {
            $this->id_staff = $staff->id_staff;
            $this->nama_staff = $staff->nama_staff;
            $this->nip = $staff->nip;
            $this->email = $staff->email;
            $this->ttd = $staff->ttd;
        } else {

            return dd('Staff not found');
        }
    }

    public function rules()
    {
        return [
            'nama_staff' => 'required|string',
            'nip' => 'required|string|unique:staff,nip,' . $this->id_staff . ',id_staff',
            'email' => 'required|email|unique:staff,email,' . $this->id_staff . ',id_staff',
            'ttd_baru' => 'nullable|image|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'nama_staff.required' => 'Nama staff tidak boleh kosong',
            'nip.required' => 'Nip tidak boleh kosong',
            'nip.unique' => 'Nip sudah dipakai',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah dipakai',
            'ttd_baru.image' => 'File harus berupa gambar',
            'ttd_baru.max' => 'Ukuran gambar terlalu besar, maksimal 2MB',

        ];
    }

    public function update()
    {
        $validatedData = $this->validate();

        $staff = Staff::find($this->id_staff);

        if ($staff) {
            if ($this->ttd_baru) {
                $imageName = $this->nama_staff . '_' . time() . '.' . $this->ttd_baru->extension();
                $this->ttd->storeAs('public/image/ttd', $imageName);
            }
            $staff->update($validatedData);
        }

        $this->reset();
        // Modal hanya ditutup jika update berhasil
        $this->dispatch('pg:eventRefresh-daftar-staf-table-cmdve0-table');
        $this->dispatch('created', [
            'message' => 'Data staff berhasil diperbarui',
        ]);
    }


    public function render()
    {

        return view('livewire.admin.staff.edit', [
        ]);
    }
}
