<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;


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



    public function render()
    {
        $Prodis = Prodi::query()
            ->latest()
            ->get();
        $mahasiswas = Mahasiswa::query()
            ->latest()
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
        $semesters = Semester::query()
            ->latest()
            ->get();
        // $tagihans = Tagihan::query()
        //     ->latest()
        //     ->paginate(5);

        return view('livewire.staff.tagihan.index', [
            'semesters' => $semesters,
            'mahasiswas'=> $mahasiswas,
            'Prodis' => $Prodis,
        ]);
    }
}
