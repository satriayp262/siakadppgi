<?php

namespace App\Livewire\Admin\Dosen;
use App\Models\Dosen;
use Livewire\Component;

class Create extends Component
{
    public $id_dosen, $nama_dosen, $nidn, $jenis_kelamin = '', $jabatan_fungsional, $kepangkatan, $kode_prodi = '';

    public function rules()
    {
        return [
            // 'id_dosen' => 'required|string|max:255',
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|max:255|unique:dosen',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'jabatan_fungsional' => 'required|string|max:255',
            'kepangkatan' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:20',
        ];
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();
        // Simpan data ke database
        $dosen = Dosen::create([
            // 'id_dosen' => $validatedData['id_dosen'],
            'nama_dosen' => $validatedData['nama_dosen'],
            'nidn' => $validatedData['nidn'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'jabatan_fungsional' => $validatedData['jabatan_fungsional'],
            'kepangkatan' => $validatedData['kepangkatan'],
            'kode_prodi' => $validatedData['kode_prodi'],
        ]);


        $this->reset();

        $this->dispatch('dosenCreated');

        return $dosen;

    }

    public function render()
    {
        return view('livewire.admin.dosen.create');
    }
}
