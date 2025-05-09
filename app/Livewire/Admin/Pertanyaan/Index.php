<?php

namespace App\Livewire\Admin\Pertanyaan;

use Livewire\Component;
use App\Models\Pertanyaan;
use Livewire\WithPagination;
use App\Models\PeriodeEMonev;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $selectedPertanyaan = [];
    public $search = '';
    public $selectAll = false;
    public $showDeleteButton = false;
    protected $updatesQueryString = ['search'];

    #[On('PertanyaanCreated')]
    public function handlePertanyaanCreated()
    {
        $this->dispatch('pg:eventRefresh-pertanyaan-table-adupmv-table');
        $this->dispatch('created', ['message' => 'Pertanyaan Berhasil di Tambahkan']);
    }

    #[On('PertanyaanUpdated')]
    public function handlePertanyaanUpdated()
    {
        $this->dispatch('pg:eventRefresh-pertanyaan-table-adupmv-table');
        $this->dispatch('created', ['message' => 'Pertanyaan Berhasil di Perbaharui']);
    }

    public function destroy($id)
    {
        $pengumuman = Pertanyaan::find($id);
        $pengumuman->delete();
        $this->dispatch('pg:eventRefresh-pertanyaan-table-adupmv-table');
        $this->dispatch('destroyed', ['message' => 'Pertanyaan Berhasil di Hapus']);
    }

    public function destroySelected($ids)
    {
        $pertanyaan = Pertanyaan::whereIn('id_pertanyaan', $ids)->delete();
        $this->dispatch('pg:eventRefresh-pertanyaan-table-adupmv-table');
        $this->dispatch('destroyed', ['message' => 'Pertanyaan Berhasil di Hapus']);
    }

    public function deleted()
    {

    }
    public function updatingSearch()
    {
        $this->refreshPage();
    }


    public function render()
    {
        $pertanyaans = Pertanyaan::query()
            ->where('nama_pertanyaan', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.pertanyaan.index', [
            'pertanyaans' => $pertanyaans
        ]);
    }
}
