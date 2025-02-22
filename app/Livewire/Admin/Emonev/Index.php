<?php

namespace App\Livewire\Admin\Emonev;

use App\Models\Emonev;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $emonev = Emonev::query()->get();
        dd($emonev);
        return view('livewire.admin.emonev.index', [
            'emonev' => $emonev
        ]);
    }
}
