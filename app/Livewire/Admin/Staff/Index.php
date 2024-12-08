<?php

namespace App\Livewire\Admin\Staff;

use Livewire\Component;
use App\Models\Staff;
use Livewire\Attributes\On;
use App\Models\User;

class Index extends Component
{
    #[On('StaffCreated')]
    public function handleStaffCreated()
    {
        $this->dispatch('created', ['message' => 'Staff Berhasil di Tambahkan']);
    }

    public function destroy($id_staff)
    {
        $staff = Staff::find($id_staff);

        $user = User::where('nim_nidn', $staff->nip)->first();
        $user->delete();

        // Delete the staff's signature file
        if ($staff->ttd) {
            $path = '/image/ttd/' . $staff->ttd;
            if (\Storage::exists($path)) {
                \Storage::delete($path);
            }
        }
        $staff->delete();
        $this->dispatch('destroyed', ['message' => 'Staff Berhasil di Hapus']);
    }

    public function render()
    {
        $staff = Staff::all();
        return view('livewire.admin.staff.index', [
            'staff' => $staff
        ]);
    }
}
