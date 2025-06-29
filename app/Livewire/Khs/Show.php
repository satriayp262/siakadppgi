<?php

namespace App\Livewire\Khs;

use App\Models\Kelas;
use App\Models\KHS;
use App\Models\KonversiNilai;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Livewire\Component;

class Show extends Component
{
    public $nama_kelas,$mahasiswa;

    public function mount()
    {
        
        $id_kelas = Kelas::where('nama_kelas',  str_replace('-', '/', $this->nama_kelas))->first()->id_kelas;
        $this->mahasiswa = Mahasiswa::wherein('NIM', KRS::where('id_kelas', $id_kelas)->pluck('NIM'))->get();
    }
    public function calculate($NIM, $id_semester)
    {
        // Retrieve the KRS data for the given NIM and semester
        $krsData = KRS::where('NIM', $NIM)
            ->where('id_semester', $id_semester)
            ->get();

        // Loop through each KRS record
        foreach ($krsData as $krs) {
            if(KonversiNilai::where('id_krs', $krs->id_krs)->exists() ){
                $bobot = KonversiNilai::where('id_krs', $krs->id_krs)->first()->nilai;
                }else{
                    $bobot = KHS::calculateBobot($krs->id_kelas, $NIM,null,null);
                }

            // Create a new KHS entry for this specific class and bobot
            KHS::updateOrCreate([
                'id_krs' => $krs->id_krs
            ], [
                'bobot' => $bobot
            ]);

        }

        $this->dispatch('updatedKHS', ['KHS Berhasil Diupdate']);
    }

    public function render()
    {
        return view('livewire.khs.show', [
        ]);
    }
}
