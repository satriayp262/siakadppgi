<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Models\Prodi;
use App\Models\Semester;
use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Pendidikan_Terakhir;
use App\Models\Orangtua_Wali;
use Illuminate\Support\Str;


class Edit extends Component
{

    public $nim,
    $nik,
    $nama,
    $jenis_kelamin,
    $tempat_lahir,
    $tanggal_lahir,
    $agama,
    $alamat,
    $jalur_pendaftaran,
    $kewarganegaraan,
    $jenis_pendaftaran,
    $tanggal_masuk_kuliah,
    $mulai_semester,
    $jenis_tempat_tinggal,
    $telp_rumah,
    $no_hp,
    $email,
    $terima_kps,
    $no_kps,
    $jenis_transportasi,
    $kode_prodi,
    $SKS_diakui,
    $kode_pt_asal,
    $nama_pt_asal,
    $kode_prodi_asal,
    $nama_prodi_asal,
    $jenis_pembiayaan,
    $jumlah_biaya_masuk,
    $nama_ayah,
    $nik_ayah,
    $pekerjaan_ayah,
    $pendidikan_ayah,
    $penghasilan_ayah,
    $nama_ibu,
    $nik_ibu,
    $pekerjaan_ibu,
    $pendidikan_ibu,
    $penghasilan_ibu,
    $nama_wali,
    $nik_wali,
    $pekerjaan_wali,
    $pendidikan_wali,
    $penghasilan_wali,
    $tanggal_lahir_ibu,
    $tanggal_lahir_ayah,
    $tanggal_lahir_wali;

    public $id_mahasiswa; 
    public $mahasiswa; 

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

        $this->nama_ayah = $mahasiswa->orangtuaWali->nama_ayah ?? null;
        $this->nik_ayah = $mahasiswa->orangtuaWali->NIK_ayah ?? null;
        $this->pekerjaan_ayah = $mahasiswa->orangtuaWali->pekerjaan_ayah ?? null;
        $this->pendidikan_ayah = $mahasiswa->orangtuaWali->pendidikan_ayah ?? null;
        $this->penghasilan_ayah = $mahasiswa->orangtuaWali->penghasilan_ayah ?? null;
        $this->nama_ibu = $mahasiswa->orangtuaWali->nama_ibu ?? null; 
        $this->nik_ibu = $mahasiswa->orangtuaWali->NIK_ibu ?? null;
        $this->pekerjaan_ibu = $mahasiswa->orangtuaWali->pekerjaan_ibu ?? null;
        $this->pendidikan_ibu = $mahasiswa->orangtuaWali->pendidikan_ibu ?? null;
        $this->penghasilan_ibu = $mahasiswa->orangtuaWali->penghasilan_ibu ?? null;
        $this->nama_wali = $mahasiswa->orangtuaWali->nama_wali ?? null;
        $this->nik_wali = $mahasiswa->orangtuaWali->NIK_wali ?? null;
        $this->pekerjaan_wali = $mahasiswa->orangtuaWali->pekerjaan_wali ?? null;
        $this->pendidikan_wali = $mahasiswa->orangtuaWali->pendidikan_wali ?? null;
        $this->penghasilan_wali = $mahasiswa->orangtuaWali->penghasilan_wali ?? null;
        $this->tanggal_lahir_ibu = $mahasiswa->orangtuaWali->tanggal_lahir_ibu ?? null;
        $this->tanggal_lahir_ayah = $mahasiswa->orangtuaWali->tanggal_lahir_ayah ?? null;
        $this->tanggal_lahir_wali = $mahasiswa->orangtuaWali->tanggal_lahir_wali ?? null;

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

        $this->nama_ayah = $mahasiswa->orangtuaWali->nama_ayah ?? null;
        $this->nik_ayah = $mahasiswa->orangtuaWali->NIK_ayah ?? null;
        $this->pekerjaan_ayah = $mahasiswa->orangtuaWali->pekerjaan_ayah ?? null;
        $this->pendidikan_ayah = $mahasiswa->orangtuaWali->pendidikan_ayah ?? null;
        $this->penghasilan_ayah = $mahasiswa->orangtuaWali->penghasilan_ayah ?? null;
        $this->nama_ibu = $mahasiswa->orangtuaWali->nama_ibu ?? null; 
        $this->nik_ibu = $mahasiswa->orangtuaWali->NIK_ibu ?? null;
        $this->pekerjaan_ibu = $mahasiswa->orangtuaWali->pekerjaan_ibu ?? null;
        $this->pendidikan_ibu = $mahasiswa->orangtuaWali->pendidikan_ibu ?? null;
        $this->penghasilan_ibu = $mahasiswa->orangtuaWali->penghasilan_ibu ?? null;
        $this->nama_wali = $mahasiswa->orangtuaWali->nama_wali ?? null;
        $this->nik_wali = $mahasiswa->orangtuaWali->NIK_wali ?? null;
        $this->pekerjaan_wali = $mahasiswa->orangtuaWali->pekerjaan_wali ?? null;
        $this->pendidikan_wali = $mahasiswa->orangtuaWali->pendidikan_wali ?? null;
        $this->penghasilan_wali = $mahasiswa->orangtuaWali->penghasilan_wali ?? null;
        $this->tanggal_lahir_ibu = $mahasiswa->orangtuaWali->tanggal_lahir_ibu ?? null;
        $this->tanggal_lahir_ayah = $mahasiswa->orangtuaWali->tanggal_lahir_ayah ?? null;
        $this->tanggal_lahir_wali = $mahasiswa->orangtuaWali->tanggal_lahir_wali ?? null;
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
            'mulai_semester' => 'required|integer',
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
            'kode_prodi.required' => 'Kode program studi tidak boleh kosong',
            'SKS_diakui.integer' => 'SKS diakui harus berupa angka',
            'kode_pt_asal.string' => 'Kode PT asal harus berupa string',
            'nama_pt_asal.string' => 'Nama PT asal harus berupa string',
            'kode_prodi_asal.string' => 'Kode prodi asal harus berupa string',
            'nama_prodi_asal.string' => 'Nama prodi asal harus berupa string',
            'jenis_pembiayaan.string' => 'Jenis pembiayaan harus berupa string',
            'jumlah_biaya_masuk.numeric' => 'Jumlah biaya masuk harus berupa angka',
            'mulai_semester.required' => 'Mulai semester tidak boleh kosong',
            'nama_ibu.required' => 'Nama ibu tidak boleh kosong',
            'tanggal_lahir_ibu.date' => 'Tanggal lahir ibu tidak valid',
            'tanggal_lahir_ayah.date' => 'Tanggal lahir ayah tidak valid',
            'tanggal_lahir_wali.date' => 'Tanggal lahir wali tidak valid',
            
        ];
    }
    

    public function save()
    {
        $validatedData = $this->validate(); 
        $mahasiswa = Mahasiswa::find($this->id_mahasiswa);
        $orangtua = Orangtua_Wali::find($mahasiswa->id_orangtua_wali);
        if ($orangtua) {
            $orangtua->update([
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
        } else {
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
            $mahasiswa->update(['id_orangtua_wali' => $orangtua->id_orangtua_wali]);
        }
        $mahasiswa->update([
            'NIM' => $validatedData['nim'],
            'NIK' => $validatedData['nik'],
            'nama' => $validatedData['nama'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
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
        session()->flash('message', 'Data mahasiswa berhasil diperbarui!');
        $this->dispatch('mahasiswaUpdated'); 
    }
    
    public function render()
    {
        $semesters = Semester::all();
        $prodis = Prodi::query()
        ->latest()
        ->get();
        $pendidikans = Pendidikan_Terakhir::all();

        return view('livewire.admin.mahasiswa.edit',[
            'prodis'=> $prodis,
            'semesters' => $semesters,
            'pendidikans' => $pendidikans,
        ]);
    }
}
