<?php

namespace App\Livewire\Admin\PresensiDosen;

use Livewire\Component;
use App\Models\Dosen;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $month;
    public $year;
    public $search = '';


    public function mount()
    {
        // Set default month and year
        $this->month = now()->month;
        $this->year = now()->year;
    }

    public function render()
    {
        $dosenWithTokens = Dosen::withCount(['tokens' => function ($query) {
            $query->whereMonth('token.created_at', $this->month)
                ->whereYear('token.created_at', $this->year);
        }])
            ->where(function ($query) {
                $query->where('nama_dosen', 'like', '%' . $this->search . '%')
                    ->orWhere('nidn', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_prodi', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        // Calculate total_jam by multiplying the tokens_count with 1.5
        $dosenWithTokens->getCollection()->transform(function ($dosen) {
            $dosen->total_jam = $dosen->tokens_count * 1.5; // Multiply token count by 1.5
            return $dosen;
        });

        return view('livewire.admin.presensi-dosen.index', [
            'dosenWithTokens' => $dosenWithTokens,
        ]);
    }
}
