<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Mahasiswa;
use Livewire\Component;
use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Create extends Component
{

    use WithFileUploads;

    public $nim;
    public $total_tagihan;
    public $id_semester;
    public $bukti_bayar_tagihan;
    public $tagihan;
    public $id_tagihan;
    public $path;



    public function rules()
    {
        return [
            'bukti_bayar_tagihan' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'bukti_bayar_tagihan.image' => 'Bukti Pembayaran harus berupa gambar',
            'bukti_bayar_tagihan.mimes' => 'Bukti Pembayaran harus berupa gambar dengan format jpeg, png, jpg, atau svg',
        ];
    }
    public function mount(Tagihan $tagihan)
    {
        // Get the mahasiswa based on the authenticated user
        $mahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();

        // Fetch the tagihan based on NIM and set the necessary properties
        $this->tagihan = Tagihan::where('NIM', $mahasiswa->NIM)
            ->where('id_tagihan', $this->id_tagihan)
            ->first();

        if (!$this->tagihan) {
            // Handle the case where tagihan is not found
            session()->flash('error', 'Tagihan not found');
            return;
        }

        $this->nim = $this->tagihan->NIM;
        $this->id_semester = Semester::where('id_semester', $this->tagihan->id_semester)->first()->nama_semester;
        $this->total_tagihan = $this->tagihan->total_tagihan;

    }

    public function save()
    {
        $mahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();
        $this->tagihan = Tagihan::where('NIM', $mahasiswa->NIM)
            ->where('id_tagihan', $this->id_tagihan)
            ->first();
        $path = $this->bukti_bayar_tagihan->storeAs('public/storage/bukti_pembayaran', $this->bukti_bayar_tagihan->getClientOriginalName());

        if ($this->tagihan) {
            $this->tagihan->save(
                [
                    'bukti_bayar_tagihan' => $path,
                ]
            );
            dd($this);
        }

        $this->reset();
        $this->dispatch('TagihanAdded');
    }

    public function render()
    {
        return view('livewire.mahasiswa.keuangan.create');
    }
}
