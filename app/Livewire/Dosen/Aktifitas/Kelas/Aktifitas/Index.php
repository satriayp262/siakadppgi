<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas\Aktifitas;


use App\Models\Aktifitas;
use App\Models\Kelas;
use App\Models\KHS;
use App\Models\KonversiNilai;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use Livewire\Component;
use Storage;

class Index extends Component
{
    public $id_kelas,
    $nama_kelas,
    $nama_aktifitas,
    $id_aktifitas,
    $id_mata_kuliah,
    $kode_mata_kuliah,
    $Nilai = [],
    $search = '';

    public function mount()
    {
        $this->id_mata_kuliah = Matakuliah::where(
            'kode_mata_kuliah',
            $this->kode_mata_kuliah
        )->where('nidn', Auth()->user()->nim_nidn)->first()->id_mata_kuliah;

        $this->id_kelas = Kelas::where('nama_kelas', str_replace('-', '/', $this->nama_kelas))->first()->id_kelas;

        $aktifitas = Aktifitas::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('nama_aktifitas', $this->nama_aktifitas)
            ->first();

        $this->id_aktifitas = $aktifitas->id_aktifitas;

        $this->loadFilteredNilaiData();
    }

    public function updatedSearch()
    {
        $this->loadFilteredNilaiData();
    }

    private function loadFilteredNilaiData()
    {
        $nims = KRS::where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->pluck('NIM');

        $excludedKrsIds = KonversiNilai::whereHas('krs', function ($query) {
            $query->where('id_mata_kuliah', $this->id_mata_kuliah)
                ->where('id_kelas', $this->id_kelas);
        })->pluck('id_krs');

        $excludedNims = KRS::whereIn('id_krs', $excludedKrsIds)->pluck('NIM');

        $nims = $nims->diff($excludedNims)->values();

        if ($nims->isEmpty()) {
            $this->Nilai = [];
            return;
        }

        // Query Mahasiswa filtered by search & NIMs from KRS
        $mahasiswa = Mahasiswa::whereIn('NIM', $nims)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('NIM', 'like', '%' . $this->search . '%')
                        ->orWhereHas('prodi', function ($subQuery) {
                            $subQuery->where('nama_prodi', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        // Map Nilai
        $this->Nilai = $mahasiswa->map(function ($item) {
            $nilaiRecord = Nilai::firstOrCreate(
                [
                    'id_aktifitas' => $this->id_aktifitas,
                    'id_kelas' => $this->id_kelas,
                    'NIM' => $item->NIM
                ],
                [
                    'nilai' => 0
                ]
            );

            return [
                'NIM' => $item->NIM,
                'nama' => $item->nama,
                'nilai' => $nilaiRecord->nilai,
            ];
        })->toArray();
    }





    protected $rules = [
        'Nilai.*.nilai' => 'nullable|numeric|min:0|max:100',
    ];
    protected $messages = [
        'Nilai.*.nilai.min' => 'Nilai minimal 0.',
        'Nilai.*.nilai.max' => 'Nilai maksimal 100.',
    ];

    public function save()
    {
        $this->validate();

        foreach ($this->Nilai as $index => $nilaiData) {
            if ($nilaiData['nilai'] === " " || $nilaiData['nilai'] === "") {
                $nilaiData['nilai'] = 0;
            }

            Nilai::updateOrCreate(
                [
                    'id_aktifitas' => $this->id_aktifitas,
                    'id_kelas' => $this->id_kelas,
                    'NIM' => $nilaiData['NIM'],
                ],
                [
                    'nilai' => $nilaiData['nilai'],
                ]
            );
        }

        $this->calculate();

        $this->loadFilteredNilaiData();

        $this->dispatch('updated', ['message' => 'Nilai Updated Successfully']);
    }

    public function calculate()
    {

        // Retrieve the KRS data for the given NIM and semester
        $krsData = KRS::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
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

    }


    public function render()
    {
        $mahasiswa = Mahasiswa::where('NIM', (string) KRS::where('id_mata_kuliah', $this->id_mata_kuliah)->pluck('NIM'))->get();
        return view('livewire.dosen.aktifitas.kelas.aktifitas.index', [
            'mahasiswa' => $mahasiswa,
        ]);
    }
}

