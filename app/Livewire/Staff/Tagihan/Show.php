<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;

class Show extends Component
{
    public $search = '';
    public $filter_prodi = '';
    public $filter_tahun = '';


    public function render()
    {
        $Prodis = Prodi::all();
        $mahasiswas = Mahasiswa::query()
            ->whereHas('tagihan');
        $semesters = Semester::all();

        if ($this->search) {
            $mahasiswas->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('NIM', 'like', '%' . $this->search . '%');

        }

        if ($this->filter_prodi) {
            $mahasiswas->where('kode_prodi', $this->filter_prodi);
        }

        if ($this->filter_tahun) {
            $mahasiswas->where('mulai_semester', $this->filter_tahun);
        }

        $mahasiswas = $mahasiswas->latest()->paginate(20);  
        
        return view('livewire.staff.tagihan.show', [
            'semesters' => $semesters,
            'mahasiswas' => $mahasiswas,
            'Prodis' => $Prodis,
        ]);
    }
}
