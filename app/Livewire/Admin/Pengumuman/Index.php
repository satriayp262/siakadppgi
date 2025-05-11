<?php

namespace App\Livewire\Admin\Pengumuman;

use App\Models\Pengumuman;
use App\Models\Pertanyaan;
use Livewire\Component;
use livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[On('PengumumanCreated')]
    public function handlePengumumanCreated()
    {
        $this->dispatch('pg:eventRefresh-pengumuman-table-evxe2o-table');
        $this->dispatch('created', ['message' => 'Pengumuman Berhasil di Tambahkan']);
    }
    public function destroy($id)
    {
        $pengumuman = Pengumuman::find($id);
        $pengumuman->delete();
        $this->dispatch('pg:eventRefresh-pengumuman-table-evxe2o-table');
        $this->dispatch('destroyed', ['message' => 'Pengumuman Berhasil di Hapus']);
    }

    public function destroySelected($ids)
    {
        Pengumuman::whereIn('id_pengumuman', $ids)->delete();
        $this->dispatch('pg:eventRefresh-pengumuman-table-evxe2o-table');
        $this->dispatch('destroyed', ['message' => 'Pengumuman Berhasil di Hapus']);
    }

    protected $listeners = ['showPengumumanDetail'];

    public function showPengumumanDetail($id_pengumuman)
    {
        $this->pengumuman = Pengumuman::find($id_pengumuman); // Replace with your model
        $this->title = $this->pengumuman->title ?? 'No Title';
        $this->desc = $this->pengumuman->desc ?? 'No Description';
        $this->dispatch('open-modal');
    }

    public function render()
    {
        $pengumumanQuery = Pengumuman::query();
        return view('livewire.admin.pengumuman.index', [
            'pengumuman' => $pengumumanQuery->latest()->paginate(10),
        ]);
    }
}
