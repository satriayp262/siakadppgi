<?php

namespace App\Livewire\Admin\Mahasiswa;

use Livewire\Component;
use App\Models\Mahasiswa;

class Show extends Component
{
    public $NIM,$NIK,$nama,$jenis_kelamin,$tempat_lahir,$tanggal_lahir,$agama,$alamat,$jalur_pendaftaran,$kewarganegaraan,$jenis_pendaftaran,$tanggal_masuk_kuliah,$mulai_semester,$jenis_tempat_tinggal,$telp_rumah,$no_hp,$email,$terima_kps,$no_kps,$jenis_transportasi,$kode_prodi,$SKS_diakui,$kode_pt_asal,$nama_pt_asal,$kode_prodi_asal,$nama_prodi_asal,$jenis_pembiayaan,$jumlah_biaya_masuk;

    public $id_mahasiswa; 

    public function mount() 
    {
        // $mahasiswa = Mahasiswa::find($this->id_mahasiswa);
        // dd($mahasiswa);
        $this->NIM = $mahasiswa->NIM ?? null;
        $this->NIK = $mahasiswa->NIK ?? null;
        $this->nama = $mahasiswa->nama ?? null;
        $this->jenis_kelamin = $mahasiswa->jenis_kelamin ?? null;
        $this->tempat_lahir = $mahasiswa->tempat_lahir ?? null;
        $this->tanggal_lahir = $mahasiswa->tanggal_lahir ?? null;
        $this->agama = $mahasiswa->agama ?? null;
        $this->alamat = $mahasiswa->alamat ?? null;
        $this->jalur_pendaftaran = $mahasiswa->jalur_pendaftaran ?? null;
        $this->kewarganegaraan = $mahasiswa->kewarganegaraan ?? null;
        $this->jenis_pendaftaran = $mahasiswa->jenis_pendaftaran ?? null;
        $this->tanggal_masuk_kuliah = $mahasiswa->tanggal_masuk_kuliah ?? null;
        $this->mulai_semester = $mahasiswa->mulai_semester ?? null;
        $this->jenis_tempat_tinggal = $mahasiswa->jenis_tempat_tinggal ?? null;
        $this->telp_rumah = $mahasiswa->telp_rumah ?? null;
        $this->no_hp = $mahasiswa->no_hp ?? null;
        $this->terima_kps = $mahasiswa->terima_kps ?? null;
        $this->email = $mahasiswa->email ?? null;
        $this->no_kps = $mahasiswa->no_kps ?? null;
        $this->jenis_transportasi = $mahasiswa->jenis_transportasi ?? null;
        $this->kode_prodi = $mahasiswa->kode_prodi ?? null;
        $this->SKS_diakui = $mahasiswa->SKS_diakui ?? null;
        $this->kode_pt_asal = $mahasiswa->kode_pt_asal ?? null;
        $this->nama_pt_asal = $mahasiswa->nama_pt_asal ?? null;
        $this->kode_prodi_asal = $mahasiswa->kode_prodi_asal ?? null;
        $this->nama_prodi_asal = $mahasiswa->nama_prodi_asal ?? null;
        $this->jenis_pembiayaan = $mahasiswa->jenis_pembiayaan ?? null;
        $this->jumlah_biaya_masuk = $mahasiswa->jumlah_biaya_masuk ?? null;
    }

    public function render()
    {
        $mahasiswa = Mahasiswa::find($this->id_mahasiswa);
        return view('livewire.admin.mahasiswa.show',[
            'mahasiswa'=> $mahasiswa,
        ]);
    }
}
