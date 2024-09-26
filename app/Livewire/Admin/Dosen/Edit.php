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
            'nidn' => 'required|string|min:10|max:10|unique:dosen' . $this->id_dosen . ',id_dosen',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'jabatan_fungsional' => 'required|string|max:255',
            'kepangkatan' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:10',
        ];
    }

    public function clear($id_dosen)
    {
        $this->reset();
        $this->dispatch('refreshComponent');
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

    protected $listeners = ['refreshComponent' => '$refresh'];
    public function placeholder()
    {
        return <<<'BLADE'
        <div>
            <h5 class="card-title placeholder-glow">
                <span class="placeholder col-4"></span>
            </h5>
            <p class="card-text placeholder-glow">
                <span class="placeholder col-7"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-6"></span>
                <span class="placeholder col-8"></span>
            </p>
        </div>
        BLADE;
    }

    public function mount($id_dosen)
    {
        $dosen = Dosen::find($id_dosen);
        $this->prodi = Prodi::all();
        if ($dosen) {
            $this->id_dosen = $dosen->id_dosen;
            $this->nama_dosen = $dosen->nama_dosen;
            $this->nidn = $dosen->nidn;
            $this->jenis_kelamin = $dosen->jenis_kelamin;
            $this->jabatan_fungsional = $dosen->jabatan_fungsional;
            $this->kepangkatan = $dosen->kepangkatan;
            $this->kode_prodi = $dosen->kode_prodi;
        }
        return $dosen;
    }

    public function update()
    {

        $validatedData = $this->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|min:10|max:10',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'jabatan_fungsional' => 'required|string|max:255',
            'kepangkatan' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:255',
        ]);

        $dosen = Dosen::find($this->id_dosen);
        $dosen->update([
            'nama_dosen' => $validatedData['nama_dosen'],
            'nidn' => $validatedData['nidn'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'jabatan_fungsional' => $validatedData['jabatan_fungsional'],
            'kepangkatan' => $validatedData['kepangkatan'],
            'kode_prodi' => $validatedData['kode_prodi'],
        ]);

        // Reset form dan dispatch event
        $this->resetExcept('prodi');
        $this->dispatch('dosenUpdated');
        return $dosen;
    }

    public function render()
    {
        return view('livewire.admin.dosen.edit');
    }
}
