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
    public $selectedprodi = '';
    public $selectedSemester = '';

    use WithPagination;

    public function render()
    {
        $Prodis = Prodi::all();

        $mahasiswas = Mahasiswa::query()->whereHas('tagihan');

        $semesters = Semester::all();

        if ($this->search) {
            $mahasiswas->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('NIM', 'like', '%' . $this->search . '%');

        }

        if ($this->selectedprodi) {
            $prodi = Prodi::where('nama_prodi', $this->selectedprodi)->first();
            $mahasiswas->whereHas('tagihan', function ($query) use ($prodi) {
                $query->where('kode_prodi', $prodi->kode_prodi);
            });
        }

        if ($this->selectedSemester) {
            $semester = Semester::where('nama_semester', $this->selectedSemester)->first();
            $mahasiswas->whereHas('tagihan', function ($query) use ($semester) {
                $query->where('mulai_semester', $semester->id_semester);
            });
        }


        return view('livewire.staff.tagihan.show', [
            'semesters' => $semesters,
            'mahasiswas' => $mahasiswas->latest()->paginate(20),
            'Prodis' => $Prodis,
        ]);
    }
}
