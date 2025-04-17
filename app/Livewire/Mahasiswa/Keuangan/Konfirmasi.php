<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Models\Tagihan;
use App\Models\Konfirmasi_Pembayaran;
use Livewire\Component;
use Livewire\WithFileUploads;

class Konfirmasi extends Component
{
    public $bukti;
    public $jumlah_pembayaran;
    public $tanggal_pembayaran;
    public $id_tagihan;
    public $nim;

    use WithFileUploads;

    public function rules()
    {
        return [
            'id_tagihan' => 'required|exists:tagihan,id_tagihan',
            'bukti' => 'required|image|max:2048',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_pembayaran' => 'required|numeric|min:0',
        ];
    }
    public function messages()
    {
        return [
            'id_tagihan.required' => 'Tagihan tidak boleh kosong',
            'id_tagihan.exists' => 'Tagihan tidak ditemukan',
            'bukti.required' => 'Bukti pembayaran tidak boleh kosong',
            'bukti.image' => 'File harus berupa gambar',
            'bukti.max' => 'Ukuran file maksimal 2MB',
            'tanggal_pembayaran.required' => 'Tanggal pembayaran tidak boleh kosong',
            'tanggal_pembayaran.date' => 'Format tanggal tidak valid',
            'jumlah_pembayaran.required' => 'Jumlah pembayaran tidak boleh kosong',
            'jumlah_pembayaran.numeric' => 'Jumlah pembayaran harus berupa angka',
            'jumlah_pembayaran.min' => 'Jumlah pembayaran tidak boleh negatif',
        ];
    }

    public function save()
    {


        $validatedData = $this->validate();


        $konfirmasi = Konfirmasi_Pembayaran::create([
            'id_tagihan' => $this->id_tagihan,
            'bukti_pembayaran' => $this->bukti->store('public/image/bukti_pembayaran'),
            'NIM' => auth()->user()->nim_nidn,
            'jumlah_pembayaran' => $validatedData['jumlah_pembayaran'],
            'tanggal_pembayaran' => $validatedData['tanggal_pembayaran'],
        ]);

        $konfirmasi->save();

    }

    public function render()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('nim', $user->nim_nidn)->first();

        $tagihan = Tagihan::with('semester')
            ->where('NIM', $mahasiswa->NIM)
            ->where('status_tagihan', '!=', 'Lunas')
            ->get();

        return view('livewire.mahasiswa.keuangan.konfirmasi', [
            'tagihan' => $tagihan,
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
