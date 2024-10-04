<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Livewire\Attributes\On;



class Index extends Component
{
    use WithPagination;

    
    public $sortField = 'kode_prodi';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }


    
    #[On('tagihanCreated')]
    public function handletagihan()
    {
        session()->flash('message', 'Tagihan Berhasil di dibuat');
        session()->flash('message_type', 'success');
    }



    public function render()
    {
        $Prodis = Prodi::query()
            ->latest()
            ->get();
        $mahasiswas = Mahasiswa::query()
            ->latest()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(24);
        $semesters = Semester::query()
            ->latest()
            ->get();
        $tagihans = Tagihan::query()
            ->latest()
            ->get();

        return view('livewire.staff.tagihan.index', [
            'semesters' => $semesters,
            'tagihans' => $tagihans,
            'mahasiswas'=> $mahasiswas,
            'Prodis' => $Prodis,
        ]);
    }
}
