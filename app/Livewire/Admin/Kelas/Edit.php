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
    public $nama_kelas;
    public $semester = '';
    public $kode_prodi = '';
    public $lingkup_kelas = '';
    public $bahasan;
    public $mode_kuliah = '';
    public $id_mata_kuliah = '';


    public function rules()
    {
        return [
            'semester' => 'required',
            'kode_prodi' => 'required',
            'id_mata_kuliah' => 'required',
            'nama_kelas' => 'required|string|max:5',
            'lingkup_kelas' => 'required|string|max:1',
            'bahasan' => 'required|string',
            'mode_kuliah' => 'required|string|max:1',
        ];
    }

    public function messages()
    {
        return [
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong',
            'nama_kelas.max' => 'Nama kelas maksimal 5 karakter',
            'nama_kelas.string' => 'Nama kelas harus berupa string',
            'semester.required' => 'Semester tidak boleh kosong',
            'kode_prodi.required' => 'Kode prodi tidak boleh kosong',
            'kode_prodi.string' => 'Kode prodi harus berupa string',
            'lingkup_kelas.string' => 'Lingkup kelas harus berupa string',
            'lingkup_kelas.max' => 'Lingkup kelas maksimal 1 karakter',
            'mode_kuliah.max' => 'Mode kuliah maksimal 1 karakter',
            'lingkup_kelas.required' => 'Lingkup kelas tidak boleh kosong',
            'id_mata_kuliah.required' => 'Mata kuliah tidak boleh kosong',
            'bahasan.required' => 'Bahasan tidak boleh kosong',
            'mode_kuliah.required' => 'Mode kuliah tidak boleh kosong',
        ];
    }

    public function clear($id_kelas)
    {
        $kelas = Kelas::find($id_kelas);
        if ($kelas) {
            $this->id_kelas = $kelas->id_kelas;
            $this->nama_kelas = $kelas->nama_kelas;
            $this->semester = $kelas->semester;
            $this->kode_prodi = $kelas->kode_prodi;
            $this->lingkup_kelas = $kelas->lingkup_kelas;
            $this->id_mata_kuliah = $kelas->id_mata_kuliah;
            $this->bahasan = $kelas->bahasan;
            $this->mode_kuliah = $kelas->mode_kuliah;
        }
    }

    public function mount($id_kelas)
    {
        $kelas = Kelas::find($id_kelas);
        if ($kelas) {
            $this->id_kelas = $kelas->id_kelas;
            $this->nama_kelas = $kelas->nama_kelas;
            $this->semester = $kelas->semester;
            $this->kode_prodi = $kelas->kode_prodi;
            $this->lingkup_kelas = $kelas->lingkup_kelas;
            $this->id_mata_kuliah = $kelas->id_mata_kuliah;
            $this->bahasan = $kelas->bahasan;
            $this->mode_kuliah = $kelas->mode_kuliah;
        }
    }

    public function update()
    {
        // Validasi data sesuai rules
        $validatedData = $this->validate();

        $kelas = Kelas::find($this->id_kelas);

        if ($kelas) {
            $kelas->update([
                'nama_kelas' => $validatedData['nama_kelas'],
                'semester' => $validatedData['semester'],
                'kode_prodi' => $validatedData['kode_prodi'],
                'lingkup_kelas' => $validatedData['lingkup_kelas'],
                'id_mata_kuliah' => $validatedData['id_mata_kuliah'],
                'bahasan' => $validatedData['bahasan'],
                'mode_kuliah' => $validatedData['mode_kuliah'],
            ]);
        }
        $this->dispatch('kelasUpdated');
        $this->reset();
    }

    public function render()
    {
        $prodi = Prodi::all();
        $Semester = Semester::all();
        $mata_kuliah = Matakuliah::where('kode_prodi', $this->kode_prodi)->get();
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
