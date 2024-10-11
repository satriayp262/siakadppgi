<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Models\Prodi;
use App\Models\Semester;
use Livewire\Component;
use App\Models\Mahasiswa;

class Edit extends Component
{

    public $nim,$nik,$nama,$jenis_kelamin,$tempat_lahir,$tanggal_lahir,$agama,$alamat,$jalur_pendaftaran,$kewarganegaraan,$jenis_pendaftaran,$tanggal_masuk_kuliah,$mulai_semester,$jenis_tempat_tinggal,$telp_rumah,$no_hp,$email,$terima_kps,$no_kps,$jenis_transportasi,$kode_prodi,$SKS_diakui,$kode_pt_asal,$nama_pt_asal,$kode_prodi_asal,$nama_prodi_asal,$jenis_pembiayaan,$jumlah_biaya_masuk;

    public $id_mahasiswa; 
    public $mahasiswa; 

    public function resetFields()
    {
        $this->resetExcept('id_mahasiswa'); 
    }
    public function mount() 
    {
        $mahasiswa = Mahasiswa::find($this->id_mahasiswa);
        // dd($mahasiswa);
        $this->nim = $mahasiswa->NIM ?? null;
        $this->nik = $mahasiswa->NIK ?? null;
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
        $this->email = $mahasiswa->email ?? null;
        $this->terima_kps = $mahasiswa->terima_kps ?? null;
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
    

    public function clear($id){
        $mahasiswa = Mahasiswa::find($id);
        // $this->reset();
        // dd($mahasiswa);
        $this->nim = $mahasiswa->NIM ?? null;
        $this->nik = $mahasiswa->NIK ?? null;
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
        $this->email = $mahasiswa->email ?? null;
        $this->terima_kps = $mahasiswa->terima_kps ?? null;
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
    public function rules()
    {
        return [
            'nim' => 'required|string|unique:mahasiswa,NIM,' . $this->id_mahasiswa . ',id_mahasiswa',
            'nik' => 'required|string|unique:mahasiswa,NIK,' . $this->id_mahasiswa . ',id_mahasiswa',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jalur_pendaftaran' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'jenis_pendaftaran' => 'nullable|string',
            'tanggal_masuk_kuliah' => 'nullable|date',
            'mulai_semester' => 'nullable|integer',
            'jenis_tempat_tinggal' => 'nullable|string',
            'telp_rumah' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'email' => 'nullable|email',
            'terima_kps' => 'nullable|string',
            'no_kps' => 'nullable|string',
            'jenis_transportasi' => 'nullable|string',
            'kode_prodi' => 'nullable|string',
            'SKS_diakui' => 'nullable|integer',
            'kode_pt_asal' => 'nullable|string',
            'nama_pt_asal' => 'nullable|string',
            'kode_prodi_asal' => 'nullable|string',
            'nama_prodi_asal' => 'nullable|string',
            'jenis_pembiayaan' => 'nullable|string',
            'jumlah_biaya_masuk' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nim.unique' => 'NIM harus unik',
            'nim.required' => 'NIM tidak boleh kosong',
            'nik.unique' => 'NIK harus unik',
            'nik.required' => 'NIK tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'tempat_lahir.required' => 'Tempat lahir tidak boleh kosong',
            'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
            'agama.string' => 'Agama harus berupa string',
            'alamat.string' => 'Alamat harus berupa string',
            'jalur_pendaftaran.string' => 'Jalur pendaftaran harus berupa string',
            'kewarganegaraan.string' => 'Kewarganegaraan harus berupa string',
            'jenis_pendaftaran.string' => 'Jenis pendaftaran harus berupa string',
            'tanggal_masuk_kuliah.date' => 'Tanggal masuk kuliah tidak valid',
            'jenis_tempat_tinggal.string' => 'Jenis tempat tinggal harus berupa string',
            'telp_rumah.string' => 'Telepon rumah harus berupa string',
            'no_hp.string' => 'Nomor HP harus berupa string',
            'email.email' => 'Format email tidak valid',
            'terima_kps.string' => 'Terima KPS harus berupa string',
            'no_kps.string' => 'Nomor KPS harus berupa string',
            'jenis_transportasi.string' => 'Jenis transportasi harus berupa string',
            'kode_prodi.string' => 'Kode program studi harus berupa string',
            'SKS_diakui.integer' => 'SKS diakui harus berupa angka',
            'kode_pt_asal.string' => 'Kode PT asal harus berupa string',
            'nama_pt_asal.string' => 'Nama PT asal harus berupa string',
            'kode_prodi_asal.string' => 'Kode prodi asal harus berupa string',
            'nama_prodi_asal.string' => 'Nama prodi asal harus berupa string',
            'jenis_pembiayaan.string' => 'Jenis pembiayaan harus berupa string',
            'jumlah_biaya_masuk.numeric' => 'Jumlah biaya masuk harus berupa angka',
        ];
    }
    

    public function save()
    {
        $this->validate(); 

        $mahasiswa = Mahasiswa::find($this->id_mahasiswa);
        $mahasiswa->update([
            'NIM' => $this->nim,
            'NIK' => $this->nik,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'agama' => $this->agama,
            'alamat' => $this->alamat,
            'jalur_pendaftaran' => $this->jalur_pendaftaran,
            'kewarganegaraan' => $this->kewarganegaraan,
            'jenis_pendaftaran' => $this->jenis_pendaftaran,
            'tanggal_masuk_kuliah' => $this->tanggal_masuk_kuliah,
            'mulai_semester' => $this->mulai_semester,
            'jenis_tempat_tinggal' => $this->jenis_tempat_tinggal,
            'telp_rumah' => $this->telp_rumah,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'terima_kps' => $this->terima_kps,
            'no_kps' => $this->no_kps,
            'jenis_transportasi' => $this->jenis_transportasi,
            'kode_prodi' => $this->kode_prodi,
            'SKS_diakui' => $this->SKS_diakui,
            'kode_pt_asal' => $this->kode_pt_asal,
            'nama_pt_asal' => $this->nama_pt_asal,
            'kode_prodi_asal' => $this->kode_prodi_asal,
            'nama_prodi_asal' => $this->nama_prodi_asal,
            'jenis_pembiayaan' => $this->jenis_pembiayaan,
            'jumlah_biaya_masuk' => $this->jumlah_biaya_masuk,
        ]);

        session()->flash('message', 'Data mahasiswa berhasil diperbarui!'); 

        // $this->reset(); 
        // $this->mount(); 
        $this->dispatch('mahasiswaUpdated'); 
    }
    public function render()
    {
        $semesters = Semester::all();
        $prodis = Prodi::query()
        ->latest()
        ->get();
        return view('livewire.admin.mahasiswa.edit',[
            'prodis'=> $prodis,
            'semesters' => $semesters
        ]);
    }
}
