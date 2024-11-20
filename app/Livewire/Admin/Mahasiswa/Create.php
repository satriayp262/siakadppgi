<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Models\Mahasiswa;
use App\Models\Orangtua_Wali;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Pendidikan_Terakhir;

class Create extends Component
{
    public $nim,
    $nik,
    $nisn,
    $npwp,
    $nama,
    $jenis_kelamin = ' ',
    $tempat_lahir,
    $tanggal_lahir, 
    $agama = ' ', 
    $alamat, 
    $jalur_pendaftaran = ' ', 
    $kewarganegaraan, 
    $jenis_pendaftaran = ' ', 
    $tanggal_masuk_kuliah, 
    $mulai_semester = ' ', 
    $jenis_tempat_tinggal = ' ', 
    $telp_rumah, 
    $no_hp, 
    $email, 
    $terima_kps = " ", 
    $no_kps, 
    $jenis_transportasi = ' ', 
    $kode_prodi = ' ', 
    $SKS_diakui, 
    $kode_pt_asal, 
    $nama_pt_asal, 
    $kode_prodi_asal, 
    $nama_prodi_asal, 
    $jenis_pembiayaan =' ', 
    $jumlah_biaya_masuk,
    $nama_ayah,
    $nik_ayah,
    $pekerjaan_ayah = " ",
    $pendidikan_ayah = " ",
    $penghasilan_ayah = " ",
    $nama_ibu,
    $nik_ibu,
    $pekerjaan_ibu = " ",
    $pendidikan_ibu = " ",
    $penghasilan_ibu = " ",
    $nama_wali,
    $nik_wali,
    $pekerjaan_wali = " ",
    $pendidikan_wali = " ",
    $penghasilan_wali = " ",
    $tanggal_lahir_ibu,
    $tanggal_lahir_ayah,
    $tanggal_lahir_wali;
    public function rules()
    {
        return [
            'nim' => 'required|string|unique:mahasiswa,NIM',
            'nik' => 'required|string|unique:mahasiswa,NIK',
            'nisn' => 'required|string',
            'npwp' => 'nullable|string',
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
            'mulai_semester' => 'required|string',
            'jenis_tempat_tinggal' => 'nullable|string',
            'telp_rumah' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'email' => 'nullable|email',
            'terima_kps' => 'nullable|string',
            'no_kps' => 'nullable|string',
            'jenis_transportasi' => 'nullable|string',
            'kode_prodi' => 'required|string',
            'SKS_diakui' => 'nullable|integer',
            'kode_pt_asal' => 'nullable|string',
            'nama_pt_asal' => 'nullable|string',
            'kode_prodi_asal' => 'nullable|string',
            'nama_prodi_asal' => 'nullable|string',
            'jenis_pembiayaan' => 'nullable|string',
            'jumlah_biaya_masuk' => 'nullable|numeric',
            'nama_ayah' => 'nullable|string',
            'nik_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'pendidikan_ayah' => 'nullable|string',
            'penghasilan_ayah' => 'nullable|string',
            'nama_ibu' => 'required|string',
            'nik_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'pendidikan_ibu' => 'nullable|string',  
            'penghasilan_ibu' => 'nullable|string',
            'nama_wali' => 'nullable|string',
            'nik_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'pendidikan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'tanggal_lahir_ayah' => 'nullable|date',
            'tanggal_lahir_wali' => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'nim.unique' => 'NIM harus unik',
            'nim.required' => 'NIM tidak boleh kosong',
            'nik.unique' => 'NIK harus unik',
            'nik.required' => 'NIK tidak boleh kosong',
            'nisn.required' => 'NISN tidak boleh kosong',
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
            'mulai_semester.required' => 'Mulai semester tidak boleh kosong',
            'jenis_tempat_tinggal.string' => 'Jenis tempat tinggal harus berupa string',
            'telp_rumah.string' => 'Telepon rumah harus berupa string',
            'no_hp.string' => 'Nomor HP harus berupa string',
            'email.email' => 'Format email tidak valid',
            'terima_kps.string' => 'Terima KPS harus berupa string',
            'no_kps.string' => 'Nomor KPS harus berupa string',
            'jenis_transportasi.string' => 'Jenis transportasi harus berupa string',
            'kode_prodi.required' => 'Kode program studi tidak boleh kosong',
            'SKS_diakui.integer' => 'SKS diakui harus berupa angka',
            'kode_pt_asal.string' => 'Kode PT asal harus berupa string',
            'nama_pt_asal.string' => 'Nama PT asal harus berupa string',
            'kode_prodi_asal.string' => 'Kode prodi asal harus berupa string',
            'nama_prodi_asal.string' => 'Nama prodi asal harus berupa string',
            'jenis_pembiayaan.string' => 'Jenis pembiayaan harus berupa string',
            'jumlah_biaya_masuk.numeric' => 'Jumlah biaya masuk harus berupa angka',
            'nama_ibu.required' => 'Nama ibu tidak boleh kosong',
            'tanggal_lahir_ibu.date' => 'Tanggal lahir ibu tidak valid',
            'tanggal_lahir_ayah.date' => 'Tanggal lahir ayah tidak valid',
            'tanggal_lahir_wali.date' => 'Tanggal lahir wali tidak valid',
        ];
    }
    public function save()
    {
        $validatedData = $this->validate();
        $orangtua = Orangtua_Wali::create([
            'id_orangtua_wali' => (string) Str::uuid(),
            'nama_ayah' => $validatedData['nama_ayah'],
            'NIK_ayah' => $validatedData['nik_ayah'],
            'tanggal_lahir_ayah' => $validatedData['tanggal_lahir_ayah'],
            'pekerjaan_ayah' => $validatedData['pekerjaan_ayah'],
            'pendidikan_ayah' => $validatedData['pendidikan_ayah'],
            'penghasilan_ayah' => $validatedData['penghasilan_ayah'],
            'nama_ibu' => $validatedData['nama_ibu'],
            'NIK_ibu' => $validatedData['nik_ibu'],
            'tanggal_lahir_ibu' => $validatedData['tanggal_lahir_ibu'],
            'pekerjaan_ibu' => $validatedData['pekerjaan_ibu'],
            'pendidikan_ibu' => $validatedData['pendidikan_ibu'],
            'penghasilan_ibu' => $validatedData['penghasilan_ibu'],
            'nama_wali' => $validatedData['nama_wali'],
            'NIK_wali' => $validatedData['nik_wali'],
            'tanggal_lahir_wali' => $validatedData['tanggal_lahir_wali'],
            'pekerjaan_wali' => $validatedData['pekerjaan_wali'],   
            'pendidikan_wali' => $validatedData['pendidikan_wali'],
            'penghasilan_wali' => $validatedData['penghasilan_wali'],
        ]);
        $mahasiswa = Mahasiswa::create([
            'id_mahasiswa' => (string) Str::uuid(),
            'id_orangtua_wali' => $orangtua->id_orangtua_wali,
            'NIM' => $validatedData['nim'],
            'NIK' => $validatedData['nik'],
            'NISN' => $validatedData['nisn'],
            'NPWP' => $validatedData['npwp'],
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
        $pendidikans = Pendidikan_Terakhir::all();

        return view('livewire.admin.mahasiswa.create', [
            'prodis' => $prodis,
            'semesters' => $semesters,
            'pendidikans' => $pendidikans,
        ]);
    }
}
