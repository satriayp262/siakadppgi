<?php

namespace App\Livewire\Admin\Pertanyaan;

use Livewire\Component;
use App\Models\Pertanyaan;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $pertanyaans = Pertanyaan::latest()->paginate(5);
        return view('livewire.admin.pertanyaan.index', [
            'pertanyaans' => $pertanyaans
        ]);
    }
}
