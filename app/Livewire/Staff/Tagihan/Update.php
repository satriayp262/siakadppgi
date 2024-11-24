<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Mahasiswa;
use Livewire\Component;
use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Staff;

class Update extends Component
{
    use WithFileUploads;

    public $NIM;
    public $total_tagihan;
    public $total_bayar;
    public $id_semester;
    public $bukti_bayar_tagihan;
    public $tagihan;
    public $id_tagihan;
    public $status_tagihan = '';
    public $id_staff = '';



    public function rules()
    {
        return [
            'total_bayar' => 'required',
            'id_staff' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total_bayar.required' => 'Total bayar tidak boleh kosong',
            'id_staff.required' => 'Staff tidak boleh kosong',
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
        $total_tagihan_cleaned = preg_replace('/\D/', '', $this->total_bayar);

        if ($this->tagihan) {
            $this->tagihan->update([
                'total_bayar' => $total_tagihan_cleaned,
                'status_tagihan' => $this->status_tagihan,
                'id_staff' => $this->id_staff,
            ]);

            $this->dispatch('TagihanUpdated');
            $this->reset();
        }

    }

    public function render()
    {
        $staffs = Staff::all();
        return view('livewire.staff.tagihan.update', [
            'staffs' => $staffs
        ]);
    }
}
