<?php

namespace App\Livewire\Khs;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\KHS;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\Semester;
use Livewire\Component;

class Index extends Component
{
    public $search, $semester, $prodi;
    public $toggleValue = false;


    public function toggleClicked()
    {
        $khs = KHS::where('id_semester', $this->semester)->
            where('id_prodi', $this->prodi)->
            get();
        foreach ($khs as $x) {
            $x->publish = $this->toggleValue ? 'Yes' : 'No';
            $x->save();
        }

    }

    public function setProdi($id)
    {
        $this->prodi = $id;
        $this->load();

    }
    public function setSemester($id)
    {
        $this->semester = $id;
        $this->load();

    }
    public function mount()
    {

        $this->search = null;
        $this->prodi = Prodi::min('id_prodi');
        $this->semester = semester::where('nama_semester', Semester::max('nama_semester'))->first()->id_semester;
        $this->load();


    }
    public function load()
    {
        $ada = KHS::where('id_semester', $this->semester)
            ->where('id_prodi', $this->prodi)
            ->first()->publish ?? "No";
        if ($ada === 'Yes') {
            $this->toggleValue = true;
        }else{
            $this->toggleValue = false;
        }
    }
    public function calculate()
    {
        $krs = KRS::where('id_semester', $this->semester)
            ->where('id_prodi', $this->prodi)
            ->distinct()
            ->pluck('NIM');
        foreach ($krs as $x) {


            $krsData = KRS::where('NIM', $x)
                ->where('id_semester', $this->semester)
                ->get();

            foreach ($krsData as $krs) {
                // Call the KHS model to calculate the bobot
                $bobot = KHS::calculateBobot($krs->id_kelas, $x,null,null);


                // Create a new KHS entry for this specific class and bobot
                KHS::updateOrCreate([
                    'NIM' => $x,
                    'id_semester' => $this->semester,
                    'id_mata_kuliah' => $krs->id_mata_kuliah,
                    'id_kelas' => $krs->id_kelas,
                    'id_prodi' => $krs->id_prodi,
                ], [
                    'bobot' => $bobot
                ]);

            }
        }
        $this->dispatch('updatedKHS', ['KHS untuk Prodi ' . Prodi::where('id_prodi', $this->prodi)->first()->nama_prodi . ' pada semester ' . semester::where('id_semester', $this->semester)->first()->nama_semester . ' berhasil diupdate']);

    }

    public function render()
    {
        // $Mahasiswa = Mahasiswa::join('semester', 'mahasiswa.mulai_semester', '=', 'semester.id_semester')
        //     ->join('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi') // Join the 'prodi' table
        //     ->orderBy('semester.nama_semester', 'desc')
        //     ->select('mahasiswa.*')
        //     ->when($this->search, function ($query) {
        //         $query->where('mahasiswa.nama', 'like', '%' . $this->search . '%'); // Search filter
        //     })
        //     ->when($this->prodi, function ($query) {
        //         $query->where('prodi.id_prodi', $this->prodi); // Prodi filter
        //     })
        //     ->paginate(20);

        $semesterList = Semester::orderBy('nama_semester', 'desc')->take(4)->get();

        $prodiList = Prodi::all();
        
        //////////////////////////
        $kelas = Kelas::paginate(10);


        return view('livewire.khs.index', [
            // 'mahasiswa' => $Mahasiswa,
            'kelas'=> $kelas,
            'semesterList' => $semesterList,
            'prodiList' => $prodiList,
        ]);
    }
}
