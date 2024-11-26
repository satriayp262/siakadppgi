<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Kelas;
use App\Models\BeritaAcara;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;

class DetailKelas extends Component
{
    use WithPagination;
    public $id_kelas;
    public $id_mata_kuliah;
    public $kelas;
    public $matkul;
    public $beritaAcara;
    public $search = '';

    protected $listeners = [
        'deleteBeritaAcara' => 'destroy',
    ];

    #[On('acaraUpdated')]
    public function handleacaraUpdated()
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
    public function handleacaraCreated()
    {
        $this->dispatch('created', params: ['message' => 'Berita Acara created Successfully']);
    }

    public function mount($id_kelas, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->id_mata_kuliah = $id_mata_kuliah;

        // Ambil detail kelas
        $this->kelas = Kelas::with('matkul')->findOrFail($id_kelas);

        // Ambil berita acara terkait kelas
        $this->beritaAcara = BeritaAcara::where('id_kelas', $id_kelas)->get();

        // Ambil data mata kuliah berdasarkan ID
        $this->matkul = \App\Models\Matakuliah::findOrFail($id_mata_kuliah);
    }

    public function render()
    {
        $beritaAcara = BeritaAcara::where('nidn', auth()->user()->nim_nidn)
            ->orWhere('id_mata_kuliah', $this->matkul->id_mata_kuliah)
            ->orWhere('id_kelas', Kelas::where('id_mata_kuliah', $this->matkul->id_mata_kuliah)->first()->id_kelas)
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
