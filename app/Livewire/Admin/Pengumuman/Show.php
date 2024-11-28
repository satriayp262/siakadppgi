<?php

namespace App\Livewire\Admin\Pengumuman;

use Livewire\Component;
use App\Models\Pengumuman;

class Show extends Component
{
    public $pengumuman;
    public $title, $desc, $image, $file;

    public function mount(Pengumuman $pengumuman)
    {
        $this->pengumuman = $pengumuman;
        $this->title = $pengumuman->title;
        $this->desc = $pengumuman->desc;
        $this->image = $pengumuman->image;
        $this->file = $pengumuman->file;
    }
    public function render()
    {
        return view('livewire.admin.pengumuman.show');
    }
}
