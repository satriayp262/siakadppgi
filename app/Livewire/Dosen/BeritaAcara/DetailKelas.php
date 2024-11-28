<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Kelas;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;

class DetailKelas extends Component
{
    use WithPagination;

    public $id_kelas, $CheckDosen = false;
    public $id_mata_kuliah;
    public $kelas;
    public $matkul;
    public $search = '';

    protected $listeners = [
        'deleteBeritaAcara' => 'destroy',
    ];

    #[On('acaraUpdated')]
    public function handleAcaraUpdated()
    {
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
        $this->dispatch('created', params: ['message' => 'Berita Acara created Successfully']);
    }

    public function mount($id_kelas, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->id_mata_kuliah = $id_mata_kuliah;

        $this->CheckDosen = (Auth()->user()->nim_nidn == Matakuliah::where('id_mata_kuliah', Kelas::where('id_kelas', $this->id_kelas)->first()->id_mata_kuliah)->first()->nidn);

        // Ambil detail kelas
        $this->kelas = Kelas::with('matkul')->findOrFail($id_kelas);

        // Ambil data mata kuliah berdasarkan ID
        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);
    }

    public function render()
    {
        $beritaAcara = BeritaAcara::where('nidn', auth()->user()->nim_nidn)
            ->Where('id_mata_kuliah', $this->matkul->id_mata_kuliah)
            ->Where('id_kelas', Kelas::where('id_mata_kuliah', $this->matkul->id_mata_kuliah)->first()->id_kelas)
            ->when($this->search, function ($query) {
                $query->where('tanggal', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dosen.berita_acara.detail-kelas', [
            'kelas' => $this->kelas,
            'matkul' => $this->matkul,
            'beritaAcara' => $beritaAcara,
        ]);
    }
}
