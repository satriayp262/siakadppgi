<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\User;


class Index extends Component
{
    public $search = '';
    use WithPagination;

    #[On('UserCreated')]
    public function handleUserCreated()
    {
        session()->flash('message', 'User Berhasil di Tambahkan');
        session()->flash('message_type', 'success');
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('role', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);
        return view('livewire.admin.user.index', ['users' => $users]);
    }
}
