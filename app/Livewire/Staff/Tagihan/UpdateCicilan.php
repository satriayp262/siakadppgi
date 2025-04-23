<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Cicilan_BPP;
use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Staff;
use Illuminate\Support\Facades\Mail;

class UpdateCicilan extends Component
{
    public $NIM;
    public $total_tagihan;
    public $total_bayar;
    public $id_semester;
    public $tagihan;
    public $id_tagihan;
    public $tanggal_pembayaran;
    public $status_tagihan = '';
    public $id_staff = '';
    public function mount()
    {
        $this->tagihan = Tagihan::find($this->id_tagihan);

        $user = auth()->user();
        $this->id_staff = $user->id_staff;

        $total = $this->tagihan->total_tagihan;
        $cicil = round($total / 6, -3);

        //untuk pembuatan cicilan
        if ($cicil * 6 < $total) {
            $cicil = $cicil + 500;
        }

        if ($this->tagihan) {
            $this->NIM = $this->tagihan->mahasiswa->NIM;
            $this->total_tagihan = $this->tagihan->total_tagihan;
            $this->id_semester = $this->tagihan->semester->nama_semester;
            $this->status_tagihan = $this->tagihan->status_tagihan;
            $this->total_bayar = $cicil;
        }
    }
    public function rules()
    {
        return [
            'tanggal_pembayaran' => 'required|date',

            'total_bayar' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'tanggal_pembayaran.required' => 'Tanggal pembayaran tidak boleh kosong',
            'tanggal_pembayaran.date' => 'Tanggal pembayaran harus berupa tanggal yang valid',
            'total_bayar.required' => 'Total bayar tidak boleh kosong',
            'total_bayar.numeric' => 'Total bayar harus berupa angka',
        ];
    }
    public function save()
    {
        $validatedata = $this->validate();

        $s = Cicilan_BPP::where('id_tagihan', $this->id_tagihan)->count();
        $count_cicilan = $s + 1;

        $tagihan = Tagihan::find($this->id_tagihan);
        $tagihan->total_bayar = $tagihan->total_bayar + $validatedata['total_bayar'];
        $tagihan->metode_pembayaran = 'cicilan';

        if ($tagihan->total_bayar >= $tagihan->total_tagihan) {
            $tagihan->status_tagihan = 'Lunas';
            $tagihan->no_kwitansi = rand();
            while (Tagihan::where('no_kwitansi', $tagihan->no_kwitansi)->exists()) {
                $tagihan->no_kwitansi = rand();
            }
        } else {
            $tagihan->status_tagihan = 'Belum Lunas';
        }
        $tagihan->id_staff = $this->id_staff;
        $tagihan->save();

        $semester = Semester::where('nama_semester', $this->id_semester)->first();

        $cicilan = Cicilan_BPP::create([
            'id_tagihan' => $this->id_tagihan,
            'id_semester' => $semester->id_semester,
            'jumlah_bayar' => $validatedata['total_bayar'],
            'tanggal_bayar' => $validatedata['tanggal_pembayaran'],
            'cicilan_ke' => $count_cicilan,
            'metode_pembayaran' => 'Tunai',
        ]);

        $cicilan->save();

        $this->reset(['total_bayar', 'tanggal_pembayaran']);

        $this->dispatch('created', [
            'message' => 'Data Pembayaran berhasil disimpan',
        ]);

        return redirect()->route('staff.detail', ['NIM' => $this->NIM]);
    }
    public function render()
    {
        return view('livewire.staff.tagihan.update-cicilan');
    }
}
