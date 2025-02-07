<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas\Aktifitas;


use App\Models\Aktifitas;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use Livewire\Component;
use Storage;

class Index extends Component
{
    public $id_kelas;
    public $nama_aktifitas;
    public $id_aktifitas;
    public $id_mata_kuliah;
    public $kode_mata_kuliah;
    public $Nilai = [];
    public $search = '';

    public function mount()
    {
        $this->id_mata_kuliah = Matakuliah::where('kode_mata_kuliah', $this->kode_mata_kuliah)->where('nidn', Auth()->user()->nim_nidn)->first()->id_mata_kuliah;

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
        $query = Mahasiswa::query();

        // Filter based on search
        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('NIM', 'like', '%' . $this->search . '%')
                ->orWhereHas('prodi', function ($query) {
                    $query->where('nama_prodi', 'like', '%' . $this->search . '%');
                })
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        // Filter by kelas
        $query->whereIn('NIM', KRS::where('id_mata_kuliah', $this->id_mata_kuliah)->pluck('NIM'));

        // Get filtered mahasiswa and map their nilai
        $mahasiswa = $query->get();

        $this->Nilai = [];
        foreach ($mahasiswa as $item) {
            $nilaiRecord = Nilai::where('id_aktifitas', $this->id_aktifitas)
                ->where('NIM', $item->NIM)
                ->first();

            $this->Nilai[] = [
                'NIM' => $item->NIM,
                'nama' => $item->nama,
                'prodi' => $item->prodi->nama_prodi ?? '',
                'email' => $item->email,
                'nilai' => $nilaiRecord ? $nilaiRecord->nilai : '',
            ];
        }
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
                $nilaiData['nilai'] = null;
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

        $this->dispatch('updated', ['message' => 'Nilai Updated Successfully']);
    }



    public function render()
    {
        $mahasiswa = Mahasiswa::where('NIM', (string)KRS::where('id_mata_kuliah', $this->id_mata_kuliah)->pluck('NIM'))->get();
        return view('livewire.dosen.aktifitas.kelas.aktifitas.index', [
            'mahasiswa' => $mahasiswa,
        ]);
    }
}

