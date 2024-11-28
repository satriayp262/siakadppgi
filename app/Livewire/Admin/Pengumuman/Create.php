<?php

namespace App\Livewire\Admin\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title, $desc, $image, $file;

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|image',
            'file' => 'nullable|mimes:pdf|max:10240',
        ], [
            'title.required' => 'Judul Pengumuman Tidak Boleh Kosong',
            'desc.required' => 'Deskripsi Pengumuman Tidak Boleh Kosong',
            'image.required' => 'Gambar Pengumuman Tidak Boleh Kosong',
            'image.image' => 'File Gambar Harus Berformat Gambar',
            'image.max' => 'Ukuran Gambar Tidak Boleh Lebih Dari 2MB',
            'file.mimes' => 'File Harus Berformat PDF',
            'file.max' => 'Ukuran File PDF Tidak Boleh Lebih Dari 10MB',
        ]);

        $imageName = $this->title . '_' . time() . '.' . $this->image->extension(); 
        $fileName = $this->file ? $this->title . '.' . $this->file->extension() : null;

        $this->image->storeAs('public/image/pengumuman', $imageName);
        if ($this->file) {
            $this->file->storeAs('public/pengumuman', $fileName);
        }

        Pengumuman::create([
            'title' => $this->title,
            'desc' => $this->desc,
            'image' => $imageName,
            'file' => $fileName,
        ]);

        $this->reset();

        $this->dispatch('created', ['message' => 'Pengumuman Created Successfully']);
        $this->dispatch('pengumumancreated');

    }



    public function render()
    {
        return view('livewire.admin.pengumuman.create');
    }

}
