<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Mahasiswa;
use App\Models\PembayaranTunai;
use Auth;
use Livewire\Component;
use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Staff;

class Update extends Component
{
    public $NIM;
    public $total_tagihan;
    public $tanggal_pembayaran;
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
            'tanggal_pembayaran' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'total_bayar.required' => 'Total bayar tidak boleh kosong',
            'tanggal_pembayaran.required' => 'Tanggal pembayaran tidak boleh kosong',


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
            $this->total_bayar = $this->tagihan->total_tagihan;
        }
    }

    public function save()
    {
        // Validate the input fields
        $validated = $this->validate();

        $user = Auth::user();
        $staff = Staff::where('nip', $user->nim_nidn)->first();
        $this->id_staff = $staff->id_staff;

        $this->tagihan->no_kwitansi = rand();
        while (Tagihan::where('no_kwitansi', $this->tagihan->no_kwitansi)->exists()) {
            $this->tagihan->no_kwitansi = rand();
        }

        $this->tagihan->update([
            'total_bayar' => $validated['total_bayar'],
            'metode_pembayaran' => 'Tunai',
            'status_tagihan' => 'Lunas',
        ]);

        $tunai = PembayaranTunai::create([
            'id_pembayaran' => Str::uuid(),
            'id_tagihan' => $this->tagihan->id_tagihan,
            'nominal' => $validated['total_bayar'],
            'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
        ]);

        $tunai->save();
        $this->dispatch('TagihanUpdated');
        $this->reset(['total_bayar']);
    }



    public function render()
    {
        $staffs = Staff::all();
        return view('livewire.staff.tagihan.update', [
            'staffs' => $staffs
        ]);
    }
}
