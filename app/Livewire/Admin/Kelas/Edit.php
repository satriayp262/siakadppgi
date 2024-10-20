<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Matakuliah;

class Edit extends Component
{
    public $id_kelas;
    public $kode_kelas;
    public $nama_kelas;
    public $semester = '';
    public $kode_prodi = '';
    public $lingkup_kelas;
    public $kode_matkul = '';


    public function rules()
    {
        return [
            'kode_kelas' => 'required|string|unique:kelas,kode_kelas,' . $this->id_kelas . ',id_kelas',
            'nama_kelas' => 'required|string',
            'semester' => 'required|int',
            'kode_prodi' => 'required|string',
            'lingkup_kelas' => 'required|string',
            'kode_matkul' => 'required|string',
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
            'kode_matkul.required' => 'Kode mata kuliah tidak boleh kosong',
        ];
    }

    public function mount($id_kelas)
    {
        $kelas = Kelas::find($id_kelas);
        if ($kelas) {
            $this->id_kelas = $kelas->id_kelas;
            $this->kode_kelas = $kelas->kode_kelas;
            $this->nama_kelas = $kelas->nama_kelas;
            $this->semester = $kelas->semester;
            $this->kode_prodi = $kelas->kode_prodi;
            $this->lingkup_kelas = $kelas->lingkup_kelas;
            $this->kode_matkul = $kelas->kode_matkul;
        }
        return $kelas;
    }

    public function clear($id_kelas)
    {
        $this->resetExcept('kode_prodi', 'kode_matkul', 'semester');
        $kelas = Kelas::find($id_kelas);
        if ($kelas) {
            $this->id_kelas = $kelas->id_kelas;
            $this->kode_kelas = $kelas->kode_kelas;
            $this->nama_kelas = $kelas->nama_kelas;
            $this->semester = $kelas->semester;
            $this->kode_prodi = $kelas->kode_prodi;
            $this->lingkup_kelas = $kelas->lingkup_kelas;
            $this->kode_matkul = $kelas->kode_matkul;
        }

    }

    public function update()
    {
        // Validasi data sesuai rules
        $validatedData = $this->validate();

        $kelas = Kelas::find($this->id_kelas);

        if ($kelas) {
            // Update data kelas dengan data yang sudah divalidasi
            $kelas->update([
                'kode_kelas' => $validatedData['kode_kelas'],
                'nama_kelas' => $validatedData['nama_kelas'],
                'semester' => $validatedData['semester'],
                'kode_prodi' => $validatedData['kode_prodi'],
                'lingkup_kelas' => $validatedData['lingkup_kelas'],
                'kode_matkul' => $validatedData['kode_matkul'],
            ]);

            // Reset form dan dispatch event
            $this->resetExcept('kode_prodi', 'kode_matkul', 'semester');
            $this->dispatch('kelasUpdated');
        }
    }



    public function render()
    {
        $prodi = Prodi::all();
        $Semester = Semester::all();
        $mata_kuliah = Matakuliah::all();
        return view(
            'livewire.admin.kelas.edit',
            [
                'prodi' => $prodi,
                'Semester' => $Semester,
                'mata_kuliah' => $mata_kuliah
            ]
        );
    }
}
