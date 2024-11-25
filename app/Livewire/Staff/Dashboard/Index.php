<?php

namespace App\Livewire\Staff\Dashboard;

use Livewire\Component;
use App\Models\Tagihan;
use Livewire\WithPagination;

class Index extends Component
{
    public $total_bayar;
    use WithPagination;
    public $NIM;
    public function render()
    {
        $tagihans = Tagihan::query()
            ->where('NIM', $this->NIM)
            ->orWhere('status_tagihan', 'Lunas')
            ->paginate(10);
        return view('livewire.staff.dashboard.index', [
            'tagihans' => $tagihans
        ]);
    }
}
