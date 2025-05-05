<?php

namespace App\Livewire\Admin\Pengumuman;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pengumuman;

class Edit extends Component
{
    use WithFileUploads;

    public $title, $desc, $image, $file, $id_pengumuman, $pengumuman;
    public $newImage, $newFile;

    public function mount()
    {
        $this->pengumuman = Pengumuman::where('id_pengumuman', $this->id_pengumuman)->first();
        $this->title = $this->pengumuman->title;
        $this->desc = $this->pengumuman->desc;
        $this->image = $this->pengumuman->image;
        $this->file = $this->pengumuman->file;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'desc' => 'required',
            'newImage' => 'nullable|image',
            'newFile' => 'nullable|mimes:pdf|max:10240',
        ], [
            'title.required' => 'Judul Pengumuman Tidak Boleh Kosong',
            'desc.required' => 'Deskripsi Pengumuman Tidak Boleh Kosong',
            'newImage.image' => 'File Gambar Harus Berformat Gambar',
            'newImage.max' => 'Ukuran Gambar Tidak Boleh Lebih Dari 2MB',
            'newFile.mimes' => 'File Harus Berformat PDF',
            'newFile.max' => 'Ukuran File PDF Tidak Boleh Lebih Dari 10MB',
        ]);

        if ($this->newImage) {
            $imagePath = $this->newImage->store('images/pengumuman', 'public');
            $this->image = $imagePath;
        }

        if ($this->newFile) {
            $filePath = $this->newFile->store('files/pengumuman', 'public');
            $this->file = $filePath;
        }

        $this->pengumuman->update([
            'title' => $this->title,
            'desc' => $this->desc,
            'image' => $this->image,
            'file' => $this->file,
        ]);

        $this->dispatch('aaaaa', ['message' => 'Pengumuman Updated Successfully']);
        $this->dispatch('updated', ['message' => 'Pengumuman Edited Successfully']);
        return redirect()->route('admin.pengumuman');


    }
    public function render()
    {
        return view('livewire.admin.pengumuman.edit');
    }
}
