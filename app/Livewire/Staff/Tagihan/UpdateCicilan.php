<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Staff;
use Illuminate\Support\Facades\Mail;

class UpdateCicilan extends Component
{
    public $NIM;
    public $total_tagihan;
    public $total_bayar;
    public $id_semester;
    public $bukti_bayar_tagihan;
    public $tagihan;
    public $id_tagihan;
    public $status_tagihan = '';
    public $id_staff = '';
    public function mount()
    {
        $this->tagihan = Tagihan::find($this->id_tagihan);

        if ($this->tagihan) {
            $this->NIM = $this->tagihan->mahasiswa->NIM;
            $this->total_tagihan = $this->tagihan->total_tagihan;
            $this->id_semester = $this->tagihan->semester->nama_semester;
            $this->status_tagihan = $this->tagihan->status_tagihan;
        }
    }
    public function render()
    {
        return view('livewire.staff.tagihan.update-cicilan');
    }
}
