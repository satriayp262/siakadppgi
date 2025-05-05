<?php

namespace App\Livewire\Admin\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[On('pengumumanAdded')]
    public function handlepengumumanAdded()
    {
        $this->dispatch('created', ['message' => 'Pengumuman Berhasil di Tambahkan']);
    }
    public function destroy($id)
    {
        $pengumuman = Pengumuman::find($id);
        $pengumuman->delete();

        $this->dispatch('destroyed', ['message' => 'Pengumuman Deleted Successfully']);
    }

    protected $listeners = ['showPengumumanDetail'];

    public function showPengumumanDetail($id_pengumuman)
    {
        $this->pengumuman = Pengumuman::find($id_pengumuman); // Replace with your model
        $this->title = $this->pengumuman->title ?? 'No Title';
        $this->desc = $this->pengumuman->desc ?? 'No Description';

        $this->dispatch('open-modal'); // Trigger frontend modal
    }

    public function render()
    {
        $pengumuman = Pengumuman::query()->orderBy('created_at', 'desc')->paginate(10);
        $pengumumanQuery = Pengumuman::query();
        return view('livewire.admin.pengumuman.index', [
            'pengumuman' => $pengumumanQuery->latest()->paginate(10),
        ]);
    }
}
