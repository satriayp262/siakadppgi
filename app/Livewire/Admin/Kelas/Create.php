<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Matakuliah;

class Create extends Component
{

    public $kode_kelas;
    public $nama_kelas;
    public $semester = '';
    public $kode_prodi = '';
    public $lingkup_kelas;
    public $id_mata_kuliah = '';


    public function rules()
    {
        return [
            'kode_kelas' => 'required|string|unique:kelas,kode_kelas',
            'nama_kelas' => 'required|string',
            'semester' => 'required|string',
            'kode_prodi' => 'required|string',
            'lingkup_kelas' => 'required|string',
            'id_mata_kuliah' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'kode_kelas.unique' => 'Kode kelas sudah dipakai',
            'kode_kelas.required' => 'Kode kelas tidak boleh kosong',
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong',
            'semester.required' => 'Semester tidak boleh kosong',
            'kode_prodi.required' => 'Kode prodi tidak boleh kosong',
            'lingkup_kelas.required' => 'Lingkup kelas tidak boleh kosong',
            'id_mata_kuliah.required' => 'Mata kuliah tidak boleh kosong',
        ];
    }


    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();

        // Simpan data ke database
        $kelas = Kelas::create([
            'kode_kelas' => $validatedData['kode_kelas'],
            'nama_kelas' => $validatedData['nama_kelas'],
            'semester' => $validatedData['semester'],
            'kode_prodi' => $validatedData['kode_prodi'],
            'lingkup_kelas' => $validatedData['lingkup_kelas'],
            'id_mata_kuliah' => $validatedData['id_mata_kuliah'],
        ]);

        $this->reset();
        $this->dispatch('kelasCreated');
        return $kelas;
    }



    public function render()
    {
        $prodi = Prodi::all();
        $Semester = Semester::all();
        $mata_kuliah = Matakuliah::all();
        if ($this->kode_prodi) {
            $mata_kuliah = Matakuliah::where('kode_prodi', $this->kode_prodi)->get();
        }

        return view(
            'livewire.admin.kelas.create',
            [
                'Semester' => $Semester,
                'mata_kuliah' => $mata_kuliah,
                'prodi' => $prodi,
            ]
        );
    }
}
