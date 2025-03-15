<?php

namespace App\Livewire\Khs;

use App\Models\KHS;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Livewire\Component;

class Detail extends Component
{
    public $NIM;

    public function mount()
    {
        if (auth()->user()->role == 'mahasiswa') {
            if (!($this->NIM === auth()->user()->nim_nidn)) {
                return redirect(route('mahasiswa.khs.detail', ['NIM' => auth()->user()->nim_nidn]));
            }
        }
    }
    public function download($NIM,$id_semester,$IndexKumulatif){
        session([
            'IPK' => $IndexKumulatif,
        ]);
        if(auth()->user()->role == 'mahasiswa'){
            return redirect()->route('mahasiswa.khs.download', [$NIM, $id_semester]);
        }else if(auth()->user()->role == 'dosen'){
            return redirect()->route('dosen.khs.download', [$NIM, $id_semester]);
        }
    }
    public function calculate($NIM, $id_semester)
    {
        // Retrieve the KRS data for the given NIM and semester
        $krsData = KRS::where('NIM', $NIM)
            ->where('id_semester', $id_semester)
            ->get();

        // Loop through each KRS record
        $cek = 1;
        foreach ($krsData as $krs) {
            // Call the KHS model to calculate the bobot
            $bobot = KHS::calculateBobot($id_semester, $NIM, $krs->id_mata_kuliah,$krs->id_kelas);
            
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

        $this->dispatch('updatedKHS', ['KHS Berhasil Diupdate']);
    }
    public function render()
    {
        $semester = Semester::where(
            'nama_semester',
            '>=',
            Semester::where(
                'id_semester',
                Mahasiswa::where('NIM', $this->NIM)
                    ->first()->mulai_semester
            )->first()->nama_semester
        )->get();
        return view('livewire.khs.detail', [
            'semester' => $semester
        ]);
    }
}
