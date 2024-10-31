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
use App\Exports\TemplateExport; // Pastikan TemplateExport sudah dibuat
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Imports\MahasiswaImport;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = '';

    public $selectedMahasiswa = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    public $file;

    // Update pagination when 'search' is updated
    protected $updatesQueryString = ['search'];

    // Reset pagination page on search update
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_dosen
            $this->selectedMahasiswa = Mahasiswa::pluck('id_mahasiswa')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedMahasiswa = [];
        }
    }

    public function updatedselectedMahasiswa()
    {
        // Jika ada Mahasiswa yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedMahasiswa) > 0;
    }

    public function destroySelected()
    {
        // Hapus data Mahasiswa yang terpilih
        Mahasiswa::whereIn('id_dosen', $this->selectedMahasiswa)->delete();

        // Reset array selectedMahasiswa setelah penghapusan
        $this->selectedMahasiswa = [];
        $this->selectAll = false; // Reset juga selectAll

        // Emit event ke frontend untuk reset checkbox
        session()->flash('message', 'Dosen Berhasil di Hapus');
        session()->flash('message_type', 'error');
    }

    #[On('mahasiswaUpdated')]
    public function handleMahasiswaEdited()
    {
        $this->dispatch('updated', ['message' => 'Mahasiswa Edited Successfully']);

        // session()->flash('message', 'Mahasiswa Berhasil di Update');
        // session()->flash('message_type', 'update');
    }

    public function destroy($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::find($id_mahasiswa);
        $mahasiswa->delete();
        $this->dispatch('destroyed', params: ['message' => 'Mahasiswa deleted Successfully']);

        // session()->flash('message', 'Mahasiswa Berhasil di Hapus');
        // session()->flash('message_type', 'error');
    }

    #[On('mahasiswaCreated')]
    public function handleMahasiswaCreated()
    {
        $this->dispatch('created', ['message' => 'Mahasiswa Created Successfully']);

        // session()->flash('message', 'Mahasiswa Berhasil di Tambahkan');
        // session()->flash('message_type', 'success');
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
                session()->flash('message', count($createdRecords) . ' Data Berhasil disimpan');
                session()->flash('message_type', 'success');
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
        }



    }

    public function loadModal()
    {

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

        $query = Mahasiswa::with('semester'); // Eager load the semester relationship

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('NIM', 'like', '%' . $this->search . '%')
                ->orWhereHas('prodi', function ($query) {
                    $query->where('nama_prodi', 'like', '%' . $this->search . '%');
                })
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        $mahasiswas = $query->latest()->paginate(20);

        return view('livewire.admin.mahasiswa.index', [
            'mahasiswas' => $mahasiswas,
            'semesters' => $semesters,
            'prodis' => $prodis,
        ]);
    }
}
