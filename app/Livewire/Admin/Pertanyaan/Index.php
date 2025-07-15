<?php

namespace App\Livewire\Admin\Pertanyaan;

use App\Models\Jawaban;
use Livewire\Component;
use App\Models\Pertanyaan;
use Livewire\WithPagination;
use App\Models\PeriodeEMonev;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $selectedPertanyaan = [];
    public $showDeleteButton = false;

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
        $jawaban = Jawaban::where('id_pertanyaan', $id)->count();
        if ($jawaban > 0) {
            $this->dispatch('warning', ['message' => 'Pertanyaan tidak bisa dihapus karena sudah ada data jawaban yang terkait']);
            return;
        }
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

    public function updatingSearch()
    {
        $this->refreshPage();
    }


    public function render()
    {


        return view('livewire.admin.pertanyaan.index', [

        ]);
    }
}
