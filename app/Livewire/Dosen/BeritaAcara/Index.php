<?php

namespace App\Livewire\Dosen\BeritaAcara;

use Livewire\Component;
use App\Models\Matakuliah;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $matkul, $dosen;
    public $nama_dosen, $nidn;

    // protected $listeners = [
    //     'deleteBeritaAcara' => 'destroy',
    // ];

    // #[On('acaraUpdated')]
    // public function handleacaraUpdated()
    // {
    //     $this->dispatch('updated', params: ['message' => 'Berita Acara updated Successfully']);

    //     // session()->flash('message', 'Berita Acara Berhasil di Update');
    //     // session()->flash('message_type', 'warning');
    // }

    // public function destroy($id_berita_acara)
    // {
    //     $acara = BeritaAcara::find($id_berita_acara);

    //     $acara->delete();

    //     $this->dispatch('destroyed', params: ['message' => 'Berita Acara deleted Successfully']);

    //     // session()->flash('message', 'Berita Acara Berhasil di Hapus');
    //     // session()->flash('message_type', 'error');
    // }

    // #[On('acaraCreated')]
    // public function handleacaraCreated()
    // {
    //     $this->dispatch('created', params: ['message' => 'Berita Acara created Successfully']);

    //     // session()->flash('message', 'Berita Acara Berhasil di Tambahkan');
    //     // session()->flash('message_type', 'success');
    // }

    public function render()
    {
        $beritaAcaraByMatkul = Matakuliah::where('nidn', auth()->user()->nim_nidn)
            ->when($this->search, function ($query) {
                $query->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(5);

        return view('livewire.dosen.berita_acara.index', [
            'beritaAcaraByMatkul' => $beritaAcaraByMatkul,
        ]);
    }
}
