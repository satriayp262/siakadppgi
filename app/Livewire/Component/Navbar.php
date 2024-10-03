<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Auth;

class Navbar extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.component.navbar');
    }
}
