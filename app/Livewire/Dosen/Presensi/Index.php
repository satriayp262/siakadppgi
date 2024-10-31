<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    #[On('tokenCreated')]
    public function handletokenCreated($token)
    {
        $this->dispatch('created', params: ['message' => 'Token created Successfully']);

        // session()->flash('message', 'Token berhasil dibuat!');
        // session()->flash('message_type', 'success');
    }

    public function render()
    {
        $user = Auth::user();
        $tokens = Token::query()
            ->where('id', $user->id)
            ->whereHas('matkul', function ($query) {
                $query->where('nama_mata_kuliah', 'like', '%' . $this->search . '%')
                      ->orWhere('id_mata_kuliah', 'like', '%' . $this->search . '%');
            })
            ->orWhere('valid_until', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.dosen.presensi.index', [
            'tokens' => $tokens,
        ]);
    }
}
