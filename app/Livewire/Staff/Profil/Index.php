<?php

namespace App\Livewire\Staff\Profil;

use Livewire\Component;
use App\Models\Staff;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    public $search = '';

    use WithPagination;


    #[On('StaffCreated')]
    public function handleStaffCreated()
    {
        $this->dispatch('created', ['message' => 'Staff Berhasil di Tambahkan']);
    }

    #[On('StaffUpdated')]
    public function handleStaffUpdated()
    {
        $this->dispatch('updated', ['message' => 'Staff Berhasil di Update']);
    }


    public function destroy($id_staff)
    {
        $staff = Staff::find($id_staff);
        $staff->delete();
        $this->dispatch('destroyed', ['message' => 'Staff Berhasil di Hapus']);
    }

    public function render()
    {
        $staff = Staff::query()
            ->where('nama_staff', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);
        return view('livewire.staff.profil.index', [
            'staff' => $staff
        ]);
    }
}
