<?php

namespace App\Livewire\Admin\Anggota;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Livewire\Component;

class Edit extends Component
{
    public $search = '';
    public $nama_kelas,$id_kelas;
    public $selectedMahasiswa = "";
    public $mahasiswa = [];

    public function mount()
    {
        $this->mahasiswa = Mahasiswa::take(10)->get();
        $this->id_kelas = Kelas::where('nama_kelas', str_replace('-', '/', $this->nama_kelas))->first()->id_kelas ?? null;

    }
    public function updatedSearch()
    {
        // Fetch mahasiswa based on search query
        $this->mahasiswa = Mahasiswa::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('nim', 'like', '%' . $this->search . '%')
            ->limit(10)
            ->get();

    }

    public function selectMahasiswa($id)
    {
        $this->selectedMahasiswa = Mahasiswa::find($id);
        $this->search = $this->selectedMahasiswa->nama;
        $this->mahasiswa = [];
    }
    public function update()
    {
        $mahasiswa = mahasiswa::find($this->selectedMahasiswa);
        if ($mahasiswa->id_kelas == $this->id_kelas) {
            $this->dispatch('KelasWarning', params: ['message' => 'Mahasiswa sudah ada di kelas ini']);
        } else if ($mahasiswa->id_kelas !== null) {
            $kelas = Kelas::find($mahasiswa->id_kelas);
            $this->dispatch('confirmation', params: [$kelas->nama_kelas]);
        } else {
            $mahasiswa->id_kelas = $this->id_kelas;
            $mahasiswa->save();
            $this->dispatch('AnggotaUpdatedSuccess');

        }
    }
    public function confirmed()
    {
        $mahasiswa = mahasiswa::find($this->selectedMahasiswa);
        $mahasiswa->id_kelas = $this->id_kelas;
        $mahasiswa->save();
        $this->dispatch('AnggotaUpdatedSuccess');

    }
    public function render()
    {
        return view('livewire.admin.anggota.edit', [
        ]);
    }
}
