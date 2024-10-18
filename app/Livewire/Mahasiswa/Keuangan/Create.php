<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Mahasiswa;
use Livewire\Component;
use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;


class Create extends Component
{

    use WithFileUploads;

    public $NIM;
    public $total_tagihan;
    public $id_semester;
    public $bukti_bayar_tagihan;
    public $tagihan;
    public $id_tagihan;
    public $status_tagihan;



    public function rules()
    {
        return [
            'bukti_bayar_tagihan' => 'required|image', // Assuming the file is an image and max size is 1MB
        ];
    }

    public function messages()
    {
        return [
            'bukti_bayar_tagihan.required' => 'Bukti bayar tagihan tidak boleh kosong',
            'bukti_bayar_tagihan.image' => 'Bukti bayar tagihan harus berupa gambar',
        ];
    }

    public function mount()
    {
        $this->tagihan = Tagihan::find($this->id_tagihan);

        if ($this->tagihan) {
            $this->NIM = $this->tagihan->mahasiswa->NIM;
            $this->total_tagihan = $this->tagihan->total_tagihan;
            $this->id_semester = $this->tagihan->semester->nama_semester;
            $this->status_tagihan = $this->tagihan->status_tagihan;
        }
    }

    public function save()
    {
        // Validate the input fields
        $this->validate();

        $filename = Str::random(10) . '.' . $this->bukti_bayar_tagihan->getClientOriginalExtension();
        $this->bukti_bayar_tagihan->storeAs('public/images/bukti_pembayaran', $filename);


        if ($this->tagihan) {
            $this->tagihan->update([
                'bukti_bayar_tagihan' => $filename,
            ]);
        }

    }

    public function render()
    {
        return view('livewire.mahasiswa.keuangan.create');
    }
}
