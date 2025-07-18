<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Exports\MahasiswaExport;
use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Models\Prodi;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;


class Index extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = '';

    public $selectedMahasiswa = [];
    public $selectAll = false;
    public $showDeleteButton = false;
    public $selectedSemester = '';
    public $selectedprodi = '';
    public $file;
    public $importing = false;


    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {

            $this->selectedMahasiswa = Mahasiswa::pluck('id_mahasiswa')->toArray();
        } else {

            $this->selectedMahasiswa = [];
        }
    }

    public function updatedselectedMahasiswa()
    {

        $this->showDeleteButton = count($this->selectedMahasiswa) > 0;
    }


    public function destroySelected($ids): void
    {
        Mahasiswa::whereIn('id_mahasiswa', $ids)->delete();

        $this->dispatch('pg:eventRefresh-mahasiswa-table-s8eldb-table');
        $this->dispatch('destroyed', ['message' => 'Mahasiswa Berhasil dibahpus']);

    }

    #[On('mahasiswaUpdated')]
    public function handleMahasiswaEdited()
    {
        $this->dispatch('pg:eventRefresh-mahasiswa-table-s8eldb-table');

        $this->dispatch('updated', ['message' => 'Mahasiswa Edited Successfully']);

    }

    public function destroy($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::find($id_mahasiswa);
        $mahasiswa->delete();
        $this->dispatch('pg:eventRefresh-mahasiswa-table-s8eldb-table');

        $this->dispatch('destroyed', params: ['message' => 'Mahasiswa deleted Successfully']);


    }

    #[On('mahasiswaCreated')]
    public function handleMahasiswaCreated()
    {
        $this->dispatch('pg:eventRefresh-mahasiswa-table-s8eldb-table');
        $this->dispatch('created', ['message' => 'Mahasiswa Created Successfully']);


    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240',
        ]);

        $path = $this->file->store('temp');

        // $skippedRecords = [];
        $createdRecords = [];

        $import = new MahasiswaImport;

        try {
            Excel::import($import, Storage::path($path));

            $skippedRecords = $import->getSkippedRecords();
            $createdRecords = $import->getCreatedRecords();
            $incompleteRecords = $import->getIncompleteRecords();
            if (empty($createdRecords)) {
                session()->flash('message', 'Tidak ada data yang disimpan');
                session()->flash('message_type', 'error');
            } else {
                $this->dispatch('created', ['message' => count($createdRecords) . ' Mahasiswa Berhasil disimpan']);
            }
            if ($skippedRecords > 0 && !empty($incompleteRecords)) {

                session()->flash('message2', $skippedRecords . ' Data sudah ada <br>' . implode($incompleteRecords));
                session()->flash('message_type2', 'warning');

            } elseif ($skippedRecords > 0 && empty($incompleteRecords)) {
                session()->flash('message2', $skippedRecords . ' Data sudah ada');
                session()->flash('message_type2', 'warning');
            } elseif ($skippedRecords == 0 && !empty($incompleteRecords)) {
                session()->flash('message2', implode($incompleteRecords));
                session()->flash('message_type2', 'warning');
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            session()->flash('message', 'Invalid file format: ' . $e->getMessage());
            session()->flash('message_type', 'error');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                session()->flash('message', 'Data Sudah Ada ' . $e->getMessage());
                session()->flash('message_type', 'error');
            } else {
                session()->flash('message', 'Database error: ' . $e->getMessage());
                session()->flash('message_type', 'error');
            }
        } catch (\Exception $e) {
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('message_type', 'error');
        } finally {
            $this->reset('file');
            $this->dispatch('pg:eventRefresh-mahasiswa-table-s8eldb-table');
        }



    }




    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $prodis = Prodi::query()
            ->latest()
            ->get();

        $semesters = Semester::query()
            ->latest()
            ->get();

        $query = Mahasiswa::with('semester');

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('NIM', 'like', '%' . $this->search . '%')
                ->orWhereHas('prodi', function ($query) {
                    $query->where('nama_prodi', 'like', '%' . $this->search . '%');
                })
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedprodi) {
            $query->whereHas('prodi', function ($query) {
                $query->where('nama_prodi', $this->selectedprodi);
            });
        }

        if ($this->selectedSemester) {
            $query->whereHas('Semester', function ($query) {
                $query->where('nama_semester', $this->selectedSemester);
            });
        }

        return view('livewire.admin.mahasiswa.index', [
            'mahasiswas' => $query->latest()->paginate(20),
            'semesters' => $semesters,
            'Prodis' => $prodis,
        ]);
    }
}
