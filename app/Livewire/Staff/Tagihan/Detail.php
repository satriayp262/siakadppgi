<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Mahasiswa;
use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Semester;
use Livewire\Attributes\On;

class Detail extends Component
{
    public $id_tagihan;
    public $NIM;
    public $total_tagihan;
    public $id_semester;
    public $status_tagihan;
    public $tagihan;

    public function mount($NIM)
    {
        $this->tagihan = Tagihan::where('NIM', $NIM)->first();
        $this->NIM = $this->tagihan->NIM;
        $this->total_tagihan = $this->tagihan->total_tagihan;
        $this->id_semester = $this->tagihan->id_semester;
        $this->status_tagihan = $this->tagihan->status_tagihan;
    }

    #[On('TagihanUpdated')]
    public function handleTagihanUpdated()
    {
        session()->flash('message', 'Tagihan Berhasil di Update');
        session()->flash('message_type', 'success');
    }


    public function render()
    {
        $semesters = Semester::all();
        $mahasiswas = Mahasiswa::all();
        $tagihans = Tagihan::where('NIM', $this->NIM)->get();
        return view('livewire.staff.tagihan.detail', [
            'semesters' => $semesters,
            'tagihans' => $tagihans,
            'mahasiswas' => $mahasiswas,
        ]);
    }
}
