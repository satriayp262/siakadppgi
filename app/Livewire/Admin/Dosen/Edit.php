<?php

namespace App\Livewire\Admin\Dosen;

use App\Models\Dosen;
use App\Models\Prodi;
use Livewire\Component;

class Edit extends Component
{
    public $id_dosen, $nama_dosen, $nidn, $jenis_kelamin, $jabatan_fungsional, $kepangkatan, $kode_prodi, $prodi;

    public function rules()
    {
        return [
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|min:10|max:10|unique:dosen,nidn,' . $this->id_dosen,
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'jabatan_fungsional' => 'required|string|max:255',
            'kepangkatan' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:10',
        ];
    }

    public function clear($id_dosen)
    {
        $this->resetExcept('prodi');
        $dosen = Dosen::find($id_dosen);
        if ($dosen) {
            $this->id_dosen = $dosen->id_dosen;
            $this->nama_dosen = $dosen->nama_dosen;
            $this->nidn = $dosen->nidn;
            $this->jenis_kelamin = $dosen->jenis_kelamin;
            $this->jabatan_fungsional = $dosen->jabatan_fungsional;
            $this->kepangkatan = $dosen->kepangkatan;
            $this->kode_prodi = $dosen->kode_prodi;
        }
    }

    public function mount($id_dosen)
    {
        $dosen = Dosen::find($id_dosen);
        $this->prodi = Prodi::all() ?? collect();
        if ($dosen) {
            $this->id_dosen = $dosen->id_dosen;
            $this->nama_dosen = $dosen->nama_dosen;
            $this->nidn = $dosen->nidn;
            $this->jenis_kelamin = $dosen->jenis_kelamin;
            $this->jabatan_fungsional = $dosen->jabatan_fungsional;
            $this->kepangkatan = $dosen->kepangkatan;
            $this->kode_prodi = $dosen->kode_prodi;
        }
    }

    public function update()
    {
        $validatedData = $this->validate();

        $dosen = Dosen::find($this->id_dosen);
        if ($dosen) {
            $dosen->update($validatedData);

            // Reset form except 'prodi' and dispatch browser event
            $this->resetExcept('prodi');
            $this->dispatch('dosenUpdated');
        }
    }

    public function render()
    {
        return view('livewire.admin.dosen.edit');
    }
}

