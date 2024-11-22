<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas\Aktifitas;


use App\Models\Aktifitas;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use Livewire\Component;
use Storage;

class Index extends Component
{
    public $id_kelas;
    public $nama_aktifitas;
    public $id_aktifitas;
    public $Nilai = [];
    public $search = '';

    public function mount()
    {
        $aktifitas = Aktifitas::where('id_kelas', $this->id_kelas)
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
        $query->whereIn('NIM', KRS::where('id_kelas', $this->id_kelas)->pluck('NIM'));

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




    public function save()
    {
        foreach ($this->Nilai as $index => $nilaiData) {
            $nilai = trim($nilaiData['nilai']);

            if (empty($nilai) || !is_numeric($nilai)) {
                session()->flash('message', 'Nilai must be a valid integer for NIM ' . $nilaiData['NIM']);
                session()->flash('message_type', 'error');
                return;
            }

            $nilai = (int) $nilai;

            Nilai::updateOrCreate(
                [
                    'id_aktifitas' => $this->id_aktifitas,
                    'id_kelas' => $this->id_kelas,
                    'NIM' => $nilaiData['NIM'],
                ],
                [
                    'nilai' => $nilai,
                ]
            );
        }
        $this->dispatch('updated', ['Update Nilai Berhasil']);

    }



    public function render()
    {
        $mahasiswa = Mahasiswa::whereIn('NIM', KRS::where('id_kelas', $this->id_kelas)->pluck('NIM'))->get();
        return view('livewire.dosen.aktifitas.kelas.aktifitas.index', [
            'mahasiswa' => $mahasiswa,
        ]);
    }
}

