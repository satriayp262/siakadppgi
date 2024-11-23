<?php

namespace App\Livewire\Admin\Semester;

use App\Models\Semester;
use Livewire\Component;
use Livewire\Attributes\On;


class Index extends Component
{

    public $selectedSemester = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    #[On('semesterCreated')]
    public function handlesemesterCreated()
    {
        $this->dispatch('created', ['message' => 'Semester Berhasil Disimpan']);
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

    public function updatedSelectedSemester()
    {
        $this->showDeleteButton = count($this->selectedSemester) > 0;
    }

    public function destroySelected()
    {
        // Hapus data dosen yang terpilih
        Semester::whereIn('id_semester', $this->selectedSemester)->delete();

        // Reset array selectedDosen setelah penghapusan
        $this->selectedSemester = [];
        $this->selectAll = false; // Reset juga selectAll
        $this->semesterDeleted();
    }

    public function semesterDeleted()
    {
        $this->dispatch('destroyed', ['message' => 'Semester Berhasil di Hapus']);
        $this->showDeleteButton = false;
    }

    public function destroy($id_semester)
    {
        $semester = Semester::find($id_semester);
        $semester->delete();
        // session()->flash('message', 'Semester Berhasil di Hapus');
        // session()->flash('message_type', 'error');
        $this->dispatch('destroyed', ['message' => 'Semester Berhasil di Hapus']);
    }

    public function active($id_semester)
    {
        // Deactivate all other semesters
        Semester::query()->update(['is_active' => false]);

        // Activate the selected semester
        $semester = Semester::find($id_semester);
        if ($semester) {
            $semester->is_active = true;
            $semester->save();
        }
    }
    public function render()
    {
        $semesters = Semester::query()
            ->orderBy('id_semester', 'ASC')
            ->get();

        return view('livewire.admin.semester.index', [
            'semesters' => $semesters
        ]);
    }
}
