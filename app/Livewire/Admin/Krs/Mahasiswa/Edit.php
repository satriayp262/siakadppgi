<?php

namespace App\Livewire\Admin\Krs\Mahasiswa;

use Livewire\Component;
use App\Models\KRS;
use App\Models\Mahasiswa;

class Edit extends Component
{
    public $semester,$mahasiswa;
    public $krsRecords = [];
    public $NIM;

    public function mount($semester, $NIM)
    {
        $this->semester = $semester;
        $this->NIM = $NIM;
        $this->mahasiswa = Mahasiswa::where('NIM', $NIM)->first();
        $this->loadKRSRecords();
    }

    public function loadKRSRecords()
    {
        $this->krsRecords = KRS::where('id_semester', $this->semester)
            ->where('NIM', $this->NIM)
            ->with(['matkul', 'matkul.dosen', 'kelas'])
            ->get()
            ->toArray();
    }

    public function save()
    {
        foreach ($this->krsRecords as $record) {
            KRS::where('id_krs', $record['id_krs'])->update([
                'nilai_huruf' => $record['nilai_huruf'],
                'nilai_index' => $record['nilai_index'],
                'nilai_angka' => $record['nilai_angka'],
            ]);
        }
        $this->dispatch('updatedKRS',  ['Update KRS Berhasil']);

        $this->loadKRSRecords(); 
    }
    public function render()
    {
        return view('livewire.admin.krs.mahasiswa.edit');
    }
}
