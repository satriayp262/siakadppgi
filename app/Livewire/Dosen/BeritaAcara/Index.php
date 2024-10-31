<?php

namespace App\Livewire\Dosen\BeritaAcara;

use Livewire\Component;
use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\BeritaAcara;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $matkul, $dosen;

    protected $listeners = [
        'deleteBeritaAcara' => 'destroy',
    ];

    #[On('acaraUpdated')]
    public function handleacaraUpdated()
    {
        $this->dispatch('updated', params: ['message' => 'Berita Acara updated Successfully']);

        // session()->flash('message', 'Berita Acara Berhasil di Update');
        // session()->flash('message_type', 'warning');
    }

    public function destroy($id_berita_acara)
    {
        $acara = BeritaAcara::find($id_berita_acara);

        $acara->delete();

        $this->dispatch('destroyed', params: ['message' => 'Berita Acara deleted Successfully']);

        // session()->flash('message', 'Berita Acara Berhasil di Hapus');
        // session()->flash('message_type', 'error');
    }

    #[On('acaraCreated')]
    public function handleacaraCreated()
    {
        $this->dispatch('created', params: ['message' => 'Berita Acara created Successfully']);

        // session()->flash('message', 'Berita Acara Berhasil di Tambahkan');
        // session()->flash('message_type', 'success');
    }

    public function mount()
    {
        $this->matkul = Matakuliah::all() ?? collect([]);
        $this->dosen = Dosen::all() ?? collect([]);
    }

    public function render()
    {
        $beritaAcaras = BeritaAcara::query()
            ->where('nidn', 'like', '%' . $this->search . '%')
            ->orWhere('id_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('jumlah_mahasiswa', 'like', '%' . $this->search . '%')
            ->orWhere('materi', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.dosen.berita_acara.index', [
            'beritaAcaras' => $beritaAcaras,
        ]);
    }
}
