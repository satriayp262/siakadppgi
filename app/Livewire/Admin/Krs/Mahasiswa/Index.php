<?php

namespace App\Livewire\Admin\Krs\Mahasiswa;

use App\Models\Mahasiswa;
use Livewire\Component;
use App\Models\Semester;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KRSExport;


class Index extends Component
{
    public $NIM;
    public $ada = false;

    public function export()
    {
        $nama = Mahasiswa::where('NIM', $this->NIM)->first()->nama;
        $fileName = 'Data KRS ' . $nama .' '. now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new KRSExport(null,$this->NIM,null), $fileName);
    }
    public function render()
    {
        $mulai_semester = Mahasiswa::where('NIM', $this->NIM)->first()->mulai_semester;
        $semester = Semester::where('id_semester', '>=', $mulai_semester)
            ->orderBy('nama_semester', 'desc')
            ->get();
        return view('livewire.admin.krs.mahasiswa.index',[
            'semester' => $semester,
        ]);
    }
}
