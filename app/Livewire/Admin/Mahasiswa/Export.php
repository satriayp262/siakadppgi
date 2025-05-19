<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Exports\MahasiswaExport;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Semester;
use Livewire\Component;
use Maatwebsite\Excel\Excel;

class Export extends Component
{
    public $semester, $prodi, $kelas;
    public $id_semester, $kode_prodi, $id_kelas;
public function export(Excel $excel)
{
    $fileName = 'Data Mahasiswa ' . now()->format('Y-m-d') . '.xlsx';
    return $excel->download(new MahasiswaExport($this->id_semester, $this->kode_prodi, $this->id_kelas), $fileName);
}
    public function mount(){
        $this->prodi = Prodi::all();
        $this->semester = Semester::all();
        $this->kelas = Kelas::latest()->get();
    }
    public function render()
    {
        return view('livewire.admin.mahasiswa.export');
    }
}
