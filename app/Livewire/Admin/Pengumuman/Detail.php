<?php

namespace App\Livewire\Admin\Pengumuman;

use Livewire\Component;
use App\Models\Pengumuman;

class Detail extends Component
{

    public $id_pengumuman;

    public function mount($id_pengumuman)
    {

        $pengumuman = Pengumuman::find($id_pengumuman);
        if ($pengumuman) {
            $this->id_pengumuman = $pengumuman->id_pengumuman;
            $this->title = $pengumuman->title;
            $this->desc = $pengumuman->desc;
        }
        return $pengumuman;
    }

    public function render()
    {
        $pengumuman = Pengumuman::find($this->id_pengumuman);
        return view('livewire.admin.pengumuman.detail', [
            'pengumuman' => $pengumuman
        ]);
    }
}
