<?php

namespace App\Livewire\Admin\Prodi;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Prodi;


class Index extends Component
{
    public $search = '';
    public $selectedProdi = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    use WithPagination;

    #[On('ProdiCreated')]
    public function handleProdiCreated()
    {
        $this->dispatch('pg:eventRefresh-prodi-table-pzqflt-table');
        $this->dispatch('created', ['message' => 'Prodi Berhasil di Tambahkan']);
    }

    #[On('ProdiUpdated')]
    public function handleProdiUpdated()
    {
        $this->dispatch('pg:eventRefresh-prodi-table-pzqflt-table');
        $this->dispatch('updated', ['message' => 'Prodi Berhasil di Update']);
    }

    public function destroySelected($ids)
    {
        Prodi::whereIn('id_prodi', $ids)->delete();
        $this->dispatch('pg:eventRefresh-prodi-table-pzqflt-table');
        $this->dispatch('destroyed', ['message' => 'Prodi Berhasil Dihapus']);

    }

    public function destroy($id_prodi)
    {
        $prodi = Prodi::find($id_prodi);

        $prodi->delete();

        $this->dispatch('pg:eventRefresh-prodi-table-pzqflt-table');

        $this->dispatch('destroyed', ['message' => 'Prodi Berhasil di Hapus']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $prodis = Prodi::query()
            ->where('kode_prodi', 'like', '%' . $this->search . '%')
            ->orWhere('nama_prodi', 'like', '%' . $this->search . '%')
            ->orWhere('jenjang', 'like', '%' . $this->search . '%')
            ->oldest()
            ->paginate(5);

        return view('livewire.admin.prodi.index', [
            'prodis' => $prodis,
        ]);
    }
}
