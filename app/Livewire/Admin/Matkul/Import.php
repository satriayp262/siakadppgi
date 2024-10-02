<?php

namespace App\Livewire\Admin\Matkul;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MatkulImport;

class Import extends Component
{
    use WithFileUploads;

    public $file;

    public function import()
    {
        // Validate that the file is provided and is a valid Excel file
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240', // max 10MB
        ]);

        // Store the file temporarily
        $path = $this->file->store('temp');

        // Use Excel to import the file
        Excel::import(new MatkulImport, storage_path('app/' . $path));

        // Emit a success message or refresh the page
        session()->flash('message', 'Mahasiswa Berhasil dimpor.');

        // Optionally, reset the file input after import
        $this->reset('file');
    }

    public function render()
    {
        return view('livewire.admin.matkul.import');
    }
}
