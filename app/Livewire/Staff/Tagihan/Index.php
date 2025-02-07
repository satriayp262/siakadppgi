<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Livewire\Attributes\On;



class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $selectedprodi = '';
    public $selectedSemester = '';
    public $selectedMahasiswa = [];
    public $showUpdateButton = false;

    public $buttontransaksi = false;

    #[On('TagihanCreated')]
    public function handletagihanCreated()
    {
        $this->dispatch('created', ['message' => 'Tagihan Berhasil Ditambahkan']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedselectedMahasiswa()
    {
        $this->showUpdateButton = count($this->selectedMahasiswa) > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedMahasiswa = Mahasiswa::pluck('id_mahasiswa')->toArray();
        } else {

            $this->selectedMahasiswa = [];
        }
    }


    public function createTagihan()
    {

        $Mahasiswa = Mahasiswa::whereIn('id_mahasiswa', $this->selectedMahasiswa)->get();

        // Simpan data mahasiswa ke session sebelum redirect
        session(['selectedMahasiswa' => $Mahasiswa]);
        $this->buttontransaksi = true;

        return $Mahasiswa;
    }


    public function render()
    {
        $query = Mahasiswa::with('prodi', 'semester');

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('NIM', 'like', '%' . $this->search . '%');
        }

        $Prodis = Prodi::all();


        $semesters = Semester::all();

        if ($this->selectedprodi) {
            $prodi = Prodi::where('nama_prodi', $this->selectedprodi)->first();
            $query->where('kode_prodi', $prodi->kode_prodi);
        }


        if ($this->selectedSemester) {
            $semester = Semester::where('nama_semester', $this->selectedSemester)->first();
            $query->where('mulai_semester', $semester->id_semester);
        }



        return view('livewire.staff.tagihan.index', [
            'mahasiswas' => $query->latest()->paginate(20),
            'Prodis' => $Prodis,
            'semesters' => $semesters,
        ]);
    }
}
