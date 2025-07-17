<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Kelas;
use App\Models\BeritaAcara;
use App\Models\KRS;
use App\Models\Matakuliah;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;


class DetailKelas extends Component
{
    use WithPagination;

    public $id_kelas, $CheckDosen = false;
    public $id_mata_kuliah;
    public $mataKuliah;
    public $kelas;
    public $matkul;
    public $search = '';

    protected $listeners = [
        'deleteBeritaAcara' => 'destroy',
    ];

    #[On('acaraUpdated')]
    public function handleAcaraUpdated()
    {
        $this->dispatch('pg:eventRefresh-berita-acara-dosen-table');
        $this->dispatch('updated', params: ['message' => 'Berita Acara updated Successfully']);
    }

    public function destroy($id_berita_acara)
    {
        $acara = BeritaAcara::find($id_berita_acara);
        $acara->delete();
        $this->dispatch('destroyed', params: ['message' => 'Berita Acara deleted Successfully']);
    }

    #[On('acaraCreated')]
    public function handleAcaraCreated()
    {
        $this->dispatch('pg:eventRefresh-berita-acara-dosen-table');
        $this->dispatch('created', params: ['message' => 'Berita Acara created Successfully']);
    }

    public function mount($id_kelas, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->id_mata_kuliah = $id_mata_kuliah;

        $this->kelas = Kelas::with('matkul')->findOrFail($id_kelas);

        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.detail-kelas', [
            'kelas' => $this->kelas,
            'matkul' => $this->matkul,
            'id_kelas' => $this->kelas->id_kelas,
            'id_mata_kuliah' => $this->matkul->id_mata_kuliah,
        ]);
    }
}
