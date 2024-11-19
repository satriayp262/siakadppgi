<?php

namespace App\Livewire\Admin\Krs;

use App\Exports\KRSExport;
use App\Models\KRS;
use App\Models\Prodi;
use App\Models\Semester;
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

    public $file, $importing = false,$id_semester = "semua",$id_prodi = "semua";



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
        if($this->id_semester === "semua"){
            $this->id_semester = null;
        }
        if($this->id_prodi === "semua"){
            $this->id_prodi = null;
        }
        $nama_semester = Semester::where('id_semester', $this->id_semester)->first()->nama_semester ?? null;
        $nama_prodi = Prodi::where('id_prodi', $this->id_prodi)->first()->nama_prodi ?? null;
        // dd($this->id_semester !== "semua" && $this->id_prodi === "semua");
        if(!$this->id_semester  && !$this->id_prodi ){
            $fileName = 'Data KRS ' . now()->format('Y-m-d') . '.xlsx';
            return Excel::download(new KRSExport(null,null,null), $fileName);
        }
        else if($this->id_semester && !$this->id_prodi){

            $fileName = 'Data KRS ' . $nama_semester . ' '. now()->format('Y-m-d') . '.xlsx';
            return Excel::download(new KRSExport($this->id_semester,null,null), $fileName);
        }else if(!$this->id_semester && $this->id_prodi){

            $fileName = 'Data KRS ' . $nama_prodi . ' '. now()->format('Y-m-d') . '.xlsx';
            return Excel::download(new KRSExport(null,null,$this->id_prodi), $fileName);
        }else{
            $fileName = 'Data KRS ' . $nama_semester . ' ' . $nama_prodi . ' '. now()->format('Y-m-d') . '.xlsx';
            return Excel::download(new KRSExport($this->id_semester,null,$this->id_prodi), $fileName);
        }
        
    }
    public function render()
    {
        $mahasiswa = KRS::whereIn('id_krs', function ($query) {
            $query->selectRaw('MIN(id_krs)')
                ->from('krs')
                ->groupBy('nim');
        })->paginate(10);
        $semester = Semester::all();
        $prodi = Prodi::all();


        return view('livewire.admin.krs.index', [
            'mahasiswa' => $mahasiswa,
            'semester' => $semester,
            'prodi' => $prodi
        ]);
    }
}
