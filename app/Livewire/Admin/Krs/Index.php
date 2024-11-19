<?php

namespace App\Livewire\Admin\Krs;

use App\Exports\KRSExport;
use App\Models\KRS;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KRSImport;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $file, $importing = false;



    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240',
        ]);

        $path = $this->file->store('temp');

        $skippedRecords = [];
        $createdRecords = [];

        $import = new KRSImport;

        try {
            Excel::import($import, Storage::path($path));

            $skippedRecords = $import->getSkippedRecords();
            $createdRecords = $import->getCreatedRecords();
            $incompleteRecords = $import->getIncompleteRecords();
            if (empty($createdRecords)) {
                session()->flash('message', 'Tidak ada data yang disimpan');
                session()->flash('message_type', 'error');
            } else {
                $this->dispatch('created', ['message' => count($createdRecords) . ' data berhasil disimpan']);
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
            $this->importing = false;
        }
    }
    public function export()
    {
        $fileName = 'Data KRS ' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new KRSExport(null,null), $fileName);
    }
    public function render()
    {
        $mahasiswa = KRS::whereIn('id_krs', function ($query) {
            $query->selectRaw('MIN(id_krs)')
                ->from('krs')
                ->groupBy('nim');
        })->paginate(10);

        return view('livewire.admin.krs.index', [
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
