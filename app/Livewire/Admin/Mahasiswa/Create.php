<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Models\Mahasiswa;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Prodi;

class Create extends Component
{
    public $NIM, $NIK, $nama, $jenis_kelamin = '', $kode_prodi = '', $tempat_lahir, $tanggal_lahir;
    public function rules()
    {
        return [
            'NIM' => 'required|string|unique:mahasiswa,NIM',
            'NIK' => 'required|string|unique:mahasiswa,NIK',
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'NIM.unique' => 'NIM harus unik',
            'NIM.required' => 'NIM tidak boleh kosong',
            'NIK.unique' => 'NIK harus unik',
            'NIK.required' => 'NIK tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'tempat_lahir.required' => 'SKS tatap muka tidak boleh kosong',
            'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
        ];
    }
    public function save()
    {
        $validatedData = $this->validate();
        $mahasiswa = Mahasiswa::create([
            'id_mahasiswa' => (string) Str::uuid(),
            'NIK' => $validatedData['NIK'],
            'nama' => $validatedData['nama'],
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'NIM' => $validatedData['NIM'],
        ]);

        $this->reset();

        $this->dispatch('mahasiswaCreated');

        return $mahasiswa;

    }

    public function render()
    {
        $prodis = Prodi::all();
        return view('livewire.admin.mahasiswa.create',[
            'prodis' => $prodis,
        ]);
    }
}
