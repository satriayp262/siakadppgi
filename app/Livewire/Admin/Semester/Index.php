<?php

namespace App\Livewire\Admin\Semester;

use App\Models\Semester;
use Livewire\Component;
use Livewire\Attributes\On;


class Index extends Component
{

    public $selectedSemester = [];
    public $selectAll = false;

    #[On('semesterCreated')]
    public function handlesemesterCreated()
    {
        session()->flash('message', 'Semester Berhasil di Tambahkan');
        session()->flash('message_type', 'success');
    }

    #[On('semesterUpdated')]
    public function handlesemesterupdate(){

    }

     public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_semester
            $this->selectedSemester = Semester::pluck('id_semester')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedSemester = [];
        }
    }

   public function destroy($id_semester)
    {
        $semester = Semester::find($id_semester);
        $semester->delete();
        session()->flash('message', 'Semester Berhasil di Hapus');
        session()->flash('message_type', 'error');
    }

    public function destroySelected()
    {
        // Hapus data semester yang terpilih
        Semester::whereIn('id_semester', $this->selectedSemester)->delete();

        // Reset array selectedSemester setelah penghapusan
        $this->selectedSemester = [];
        $this->selectAll = false; // Reset juga selectAll

        // Emit event ke frontend untuk reset checkbox
        $this->dispatch('semesterDeleted');
    }

    public function render()
    {
        $semesters = Semester::query()
        ->latest()
        ->get();
        
        return view('livewire.admin.semester.index',[
            'semesters'=> $semesters
        ]);
    }
}
