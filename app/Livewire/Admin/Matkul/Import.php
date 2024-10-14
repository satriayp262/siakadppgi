<?php

namespace App\Livewire\Admin\Matkul;

use App\Exports\MatkulExport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MatkulImport;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

        $import = new MatkulImport();

        // Use Excel to import the file
        Excel::import($import, Storage::path($path));

        // Emit a success message or refresh the page
        $this->dispatch('matkulImported', [
            'existingRows' => $import->getExistingRows(),
            'addedRows' => $import->getAddedRows(),
            'errors' => $import->geterrors()
        ]);

        // Optionally, reset the file input after import
        $this->reset('file');
    }

    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new MatkulExport, 'template_matkul.xlsx');
    }


    public function render()
    {
        return view('livewire.admin.matkul.import');
    }
}
