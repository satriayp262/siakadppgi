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
            'nama_kelas' => 'required|string',
            'semester' => 'required',
            'bahasan' => 'required|string',
            'mode_kuliah' => 'required|string',
            'kode_prodi' => 'required|string',
            'lingkup_kelas' => 'required|string',
            'id_mata_kuliah' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong',
            'semester.required' => 'Semester tidak boleh kosong',
            'kode_prodi.required' => 'Kode prodi tidak boleh kosong',
            'lingkup_kelas.required' => 'Lingkup kelas tidak boleh kosong',
            'id_mata_kuliah.required' => 'Mata kuliah tidak boleh kosong',
            'bahasan.required' => 'Bahasan tidak boleh kosong',
            'mode_kuliah.required' => 'Mode kuliah tidak boleh kosong',
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
            $this->id_mata_kuliah = $kelas->id_mata_kuliah;
            $this->bahasan = $kelas->bahasan;
            $this->mode_kuliah = $kelas->mode_kuliah;
        }
        return $kelas;
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

    public function update()
    {
        // Validasi data sesuai rules
        $this->validate();

        $kelas = Kelas::find($this->id_kelas);

        if ($kelas) {
            $kelas->update([
                'nama_kelas' => $this->nama_kelas,
                'semester' => $this->semester,
                'kode_prodi' => $this->kode_prodi,
                'lingkup_kelas' => $this->lingkup_kelas,
                'bahasan' => $this->bahasan,
                'mode_kuliah' => $this->mode_kuliah,
                'id_mata_kuliah' => $this->id_mata_kuliah,
            ]);
        } else {
            $this->dispatch('warning', ['message' => 'Kelas tidak ditemukan']);
        }
        $this->dispatch('kelasUpdated');
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
