<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Models\Mahasiswa;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Prodi;
use App\Models\Semester;

class Create extends Component
{
    public $nim,$nik,$nama,$jenis_kelamin = '',$tempat_lahir,$tanggal_lahir,$agama = '',$alamat,$jalur_pendaftaran,$kewarganegaraan,$jenis_pendaftaran,$tanggal_masuk_kuliah,$mulai_semester = '',$jenis_tempat_tinggal,$telp_rumah,$no_hp,$email,$terima_kps,$no_kps,$jenis_transportasi,$kode_prodi = '',$SKS_diakui,$kode_pt_asal,$nama_pt_asal,$kode_prodi_asal,$nama_prodi_asal,$jenis_pembiayaan,$jumlah_biaya_masuk;
    public function rules()
    {
        return [
            'nim' => 'required|string|unique:mahasiswa,NIM',
            'nik' => 'required|string|unique:mahasiswa,NIK',
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
            'mulai_semester' => 'nullable|string',
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
            'mulai_semester.string' => 'Mulai semester harus berupa string',
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
        $validatedData = $this->validate();
        $mahasiswa = Mahasiswa::create([
            'id_mahasiswa' => (string) Str::uuid(),
            'NIM' => $validatedData['nim'],
            'NIK' => $validatedData['nik'],
            'nama' => $validatedData['nama'],
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'agama' => $validatedData['agama'],
            'alamat' => $validatedData['alamat'],
            'jalur_pendaftaran' => $validatedData['jalur_pendaftaran'],
            'kewarganegaraan' => $validatedData['kewarganegaraan'],
            'jenis_pendaftaran' => $validatedData['jenis_pendaftaran'],
            'tanggal_masuk_kuliah' => $validatedData['tanggal_masuk_kuliah'],
            'mulai_semester' => $validatedData['mulai_semester'],
            'jenis_tempat_tinggal' => $validatedData['jenis_tempat_tinggal'],
            'telp_rumah' => $validatedData['telp_rumah'],
            'no_hp' => $validatedData['no_hp'],
            'email' => $validatedData['email'],
            'terima_kps' => $validatedData['terima_kps'],
            'no_kps' => $validatedData['no_kps'],
            'jenis_transportasi' => $validatedData['jenis_transportasi'],
            'kode_prodi' => $validatedData['kode_prodi'],
            'SKS_diakui' => $validatedData['SKS_diakui'],
            'kode_pt_asal' => $validatedData['kode_pt_asal'],
            'nama_pt_asal' => $validatedData['nama_pt_asal'],
            'kode_prodi_asal' => $validatedData['kode_prodi_asal'],
            'nama_prodi_asal' => $validatedData['nama_prodi_asal'],
            'jenis_pembiayaan' => $validatedData['jenis_pembiayaan'],
            'jumlah_biaya_masuk' => $validatedData['jumlah_biaya_masuk'],
        ]);

        $this->reset();

        $this->dispatch('mahasiswaCreated');

        return $mahasiswa;

    }

    public function render()
    {
        $semesters = Semester::all();
        $prodis = Prodi::all();
        return view('livewire.admin.mahasiswa.create',[
            'prodis' => $prodis,
            'semesters' => $semesters,
        ]);
    }
}
