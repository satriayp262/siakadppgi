<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\User;


class Index extends Component
{

    public $selectedUser = [];

    use WithPagination;
    public $selectAll = false;
    public $showDeleteButton = false;
    public $selectedRole = ''; // Default is no filter (all roles)
    public $search = '';


    #[On('UserCreated')]
    public function handleUserCreated()
    {
        // session()->flash('message', 'User Berhasil di Tambahkan');
        // session()->flash('message_type', 'success');
        $this->dispatch('created', ['message' => 'User Berhasil di Tambahkan']);
    }

    #[On('UserUpdated')]
    public function handleUserUpdated()
    {
        // session()->flash('message', 'User Berhasil di Update');
        // session()->flash('message_type', 'update');
        $this->dispatch('updated', ['message' => 'User Berhasil di Update']);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_user
            $this->selectedUser = User::pluck('id')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedUser = [];
        }
    }

    public function updatedSelectedUser()
    {
        $this->showDeleteButton = count($this->selectedUser) > 0;
    }

    public function destroySelected()
    {
        // Hapus data user yang terpilih
        User::whereIn('id', $this->selectedUser)->delete();

        // Reset array selectedUser setelah penghapusan
        $this->selectedUser = [];
        $this->selectAll = false; // Reset juga selectAll
        $this->userDeleted();
    }

    public function userDeleted()
    {
        $this->dispatch('destroyed', ['message' => ' User Berhasil di Hapus']);
        $this->showDeleteButton = false;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        // session()->flash('message', 'User Berhasil di Hapus');
        // session()->flash('message_type', 'error');
        $this->dispatch('destroyed', ['message' => 'User Berhasil di Hapus']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $usersQuery = User::query();

        // Apply the role filter if selectedRole is not empty
        if ($this->selectedRole) {
            $usersQuery->where('role', $this->selectedRole);
        }

        // Search functionality (if implemented)
        if ($this->search) {
            $usersQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        return view('livewire.admin.user.index', [
            'users' => $usersQuery->paginate(10),
        ]);
    }
}
