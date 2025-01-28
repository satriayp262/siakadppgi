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

    #[On('TagihanCreated')]
    public function handletagihanCreated()
    {
        $this->dispatch('created', ['message' => 'Tagihan Berhasil Ditambahkan']);
    }


    public function render()
    {
        $mahasiswas = Mahasiswa::with(['tagihan', 'semester', 'prodi'])
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('NIM', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(20);

        return view('livewire.staff.tagihan.index', [
            'mahasiswas' => $mahasiswas,
        ]);
    }
}
