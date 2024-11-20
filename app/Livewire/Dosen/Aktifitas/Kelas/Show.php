<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Models\Aktifitas;
use App\Models\Kelas;
use App\Models\Matakuliah;
use Livewire\Component;
use Livewire\Attributes\On;

class Show extends Component
{
    public $id_kelas, $kode_mata_kuliah, $CheckDosen = false;

    #[On('aktifitasCreated')]
    public function handleAktifitasCreated()
    {
        $this->dispatch('created', ['message' => 'Aktifitas Created Successfully']);
    }
    #[On('aktifitasUpdated')]
    public function handleAktifitasUpdated()
    {
        $this->dispatch('updated', ['message' => 'Aktifitas Updated Successfully']);
    }
    public function mount()
    {
        
        $this->CheckDosen = (Auth()->user()->nim_nidn == Matakuliah::where('id_mata_kuliah', Kelas::where('id_kelas', $this->id_kelas)->first()->id_mata_kuliah)->first()->nidn);
    }
    public function destroy($id_aktifitas)
    {
        $acara = Aktifitas::find($id_aktifitas);

        $acara->delete();
        $this->dispatch('destroyed', params: ['message' => 'Berita Acara deleted Successfully']);
    }

    public function render()
    {
        $aktifitas = Aktifitas::where('id_kelas', $this->id_kelas)->get();
        return view('livewire.dosen.aktifitas.kelas.show', [
            'aktifitas' => $aktifitas
        ]);
    }
}
