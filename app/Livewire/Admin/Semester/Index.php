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
    public $id_semester;

    #[On('semesterCreated')]
    public function handlesemesterCreated()
    {
        $this->dispatch('pg:eventRefresh-semester-table-4jkmt3-table');
        $this->dispatch('created', ['message' => 'Semester Berhasil Disimpan']);
    }

    public function destroySelected($ids)
    {
        Semester::whereIn('id_semester', $ids)->delete();
        $this->dispatch('pg:eventRefresh-semester-table-4jkmt3-table');
        $this->dispatch('destroyed', ['message' => 'Semester Berhasil di Hapus']);
    }


    public function destroy($id_semester)
    {
        $semester = Semester::find($id_semester);
        $semester->delete();
        $this->dispatch('pg:eventRefresh-semester-table-4jkmt3-table');
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

        $this->dispatch('pg:eventRefresh-semester-table-4jkmt3-table');
        $this->dispatch('created', ['message' => 'Semester Berhasil di Aktifkan']);
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
