<?php

namespace App\Livewire\Khs;

use App\Models\KHS;
use App\Models\KonversiNilai;
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
    public function download($NIM, $id_semester, $IndexKumulatif)
    {

        session([
            'IPK' => $IndexKumulatif,
        ]);
        if (auth()->user()->role == 'mahasiswa') {
            return redirect()->route('mahasiswa.khs.download', [$NIM, $id_semester]);
        } else if (auth()->user()->role == 'dosen' || auth()->user()->role == 'admin') {
            return redirect()->route('dosen.khs.download', [$NIM, $id_semester]);
        }
    }
/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Redirects to the 'dosen.khs.rekap' route for the given NIM.
     *
     * @param string $NIM The NIM of the mahasiswa to rekap.
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */

/*******  782819bf-015f-422c-ac2f-3d9ddab8ed1f  *******/
    public function rekap($NIM)
    {
            return redirect()->route('dosen.khs.rekap', $NIM);
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
           if (KonversiNilai::where('id_krs', $krs->id_krs)->exists()) {
                $bobot = KonversiNilai::where('id_krs', $krs->id_krs)->first()->nilai;
            } else {
                $bobot = KHS::calculateBobot($krs->id_semester, $krs->NIM, $krs->id_mata_kuliah, $krs->id_kelas);
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
    public function presensiMahasiswa($NIM, $id_semester)
    {
        $dataMahasiswa = Mahasiswa::select('nim')->where('nim', $NIM)
            ->with([
                'presensi' => function ($query) use ($id_semester) {
                    $query->select('nim', 'keterangan', 'created_at')
                        ->whereHas('tokenList', function ($tokenQuery) use ($id_semester) {
                            $tokenQuery->where('id_semester', intval($id_semester));
                        });
                }
            ])
            ->withCount([
                'presensi as hadir_count' => function ($query) use ($id_semester) {
                    $query->where('keterangan', 'Hadir')
                        ->whereHas('tokenList', function ($tokenQuery) use ($id_semester) {
                            $tokenQuery->where('id_semester', intval($id_semester));
                        });
                },
                'presensi as alpa_count' => function ($query) use ($id_semester) {
                    $query->where('keterangan', 'Alpha')
                        ->whereHas('tokenList', function ($tokenQuery) use ($id_semester) {
                            $tokenQuery->where('id_semester', intval($id_semester));
                        });
                },
                'presensi as ijin_count' => function ($query) use ($id_semester) {
                    $query->where('keterangan', 'Ijin')
                        ->whereHas('tokenList', function ($tokenQuery) use ($id_semester) {
                            $tokenQuery->where('id_semester', intval($id_semester));
                        });
                },
                'presensi as sakit_count' => function ($query) use ($id_semester) {
                    $query->where('keterangan', 'Sakit')
                        ->whereHas('tokenList', function ($tokenQuery) use ($id_semester) {
                            $tokenQuery->where('id_semester', intval($id_semester));
                        });
                },
            ])
            ->first();
        return $dataMahasiswa;
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
