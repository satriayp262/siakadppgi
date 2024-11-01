<?php

namespace App\Livewire\Admin\Mahasiswa;

use Livewire\Component;
use App\Models\Mahasiswa;

class Show extends Component
{
    public $NIM,$NIK,$nama,$jenis_kelamin,$tempat_lahir,$tanggal_lahir,$agama,$alamat,$jalur_pendaftaran,$kewarganegaraan,$jenis_pendaftaran,$tanggal_masuk_kuliah,$mulai_semester,$jenis_tempat_tinggal,$telp_rumah,$no_hp,$email,$terima_kps,$no_kps,$jenis_transportasi,$kode_prodi,$SKS_diakui,$kode_pt_asal,$nama_pt_asal,$kode_prodi_asal,$nama_prodi_asal,$jenis_pembiayaan,$jumlah_biaya_masuk;

    public $id_mahasiswa; 

    public function render()
    {
        $mahasiswa = Mahasiswa::find($this->id_mahasiswa);
        
        return view('livewire.admin.mahasiswa.show',[
            'mahasiswa'=> $mahasiswa,
        ]);
    }
}
