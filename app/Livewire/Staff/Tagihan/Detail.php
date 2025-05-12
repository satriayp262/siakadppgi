<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Cicilan_BPP;
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
    public $search = '';
    public $lunas;
    public $id;
    public $cicilan_bpp;



    public function mount($NIM)
    {
        $this->tagihan = Tagihan::where('NIM', $NIM)->first();
        $this->NIM = $this->tagihan->NIM;
        $this->total_tagihan = $this->tagihan->total_tagihan;
        $this->id_semester = $this->tagihan->id_semester;
        $this->status_tagihan = $this->tagihan->status_tagihan;
    }


    public function updatePembayaran($id, $status)
    {
        $this->lunas = $status;
        $this->id = $id;

    }

    #[On('TagihanUpdated')]
    public function handleTagihanUpdated()
    {
        $this->dispatch('updated', ['message' => 'Pembayaran Berhasil Diinput']);
    }


    public function render()
    {
        return view('livewire.staff.tagihan.detail', [
        ]);
    }
}
