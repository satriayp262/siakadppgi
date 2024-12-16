<?php

namespace App\Livewire\Khs;

use App\Models\KHS;
use App\Models\KRS;
use App\Models\Semester;
use Livewire\Component;

class Show extends Component
{
    public $NIM;
    public function calculate($NIM, $id_semester)
    {
        // Retrieve the KRS data for the given NIM and semester
        $krsData = KRS::where('NIM', $NIM)
            ->where('id_semester', $id_semester)
            ->get();
    
        // Loop through each KRS record
        foreach ($krsData as $krs) {
            // Call the KHS model to calculate the bobot
            $bobot = KHS::calculateBobot($krs->id_kelas, $NIM);
            
    
            // Create a new KHS entry for this specific class and bobot
            KHS::updateOrCreate([
                'NIM' => $NIM,
                'id_semester' => $id_semester,
                'id_mata_kuliah' => $krs->id_mata_kuliah,
                'id_kelas' => $krs->id_kelas,
                'id_prodi' => $krs->id_prodi,
            ], [
                'bobot' => $bobot
            ]);
            
        }
    }
    




    public function render()
    {
        $semester = Semester::all();
        return view('livewire.khs.show', [
            'semester' => $semester
        ]);
    }
}
