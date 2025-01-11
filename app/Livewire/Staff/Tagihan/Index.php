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
    public $search = '';
    public $url;

    #[On('TagihanCreated')]
    public function handletagihanCreated()
    {
        $this->dispatch('created', ['message' => 'Tagihan Berhasil Ditambahkan', 'link' => $this->url]);

    }


    public function render()
    {
        $this->url = request()->url();
        $Prodis = Prodi::all();
        $mahasiswas = Mahasiswa::query()
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('NIM', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(24);
        $semesters = Semester::all();
        $tagihans = Tagihan::all();

        return view('livewire.staff.tagihan.index', [
            'semesters' => $semesters,
            'tagihans' => $tagihans,
            'mahasiswas' => $mahasiswas,
            'Prodis' => $Prodis,
        ]);
    }
}
