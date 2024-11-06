<?php

namespace App\Livewire\Admin\Kurikulum;

use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Kurikulum;
use Livewire\Component;

class Create extends Component
{
    public $nama_kurikulum;
    public $mulai_berlaku = '';
    public $kode_prodi = '';
    public $jumlah_sks_lulus;
    public $jumlah_sks_wajib;
    public $jumlah_sks_pilihan;


    public function rules()
    {
        return [
            'nama_kurikulum' => 'required|string',
            'mulai_berlaku' => 'required',
            'kode_prodi' => 'required',
            'jumlah_sks_lulus' => 'required|numeric',
            'jumlah_sks_wajib' => 'required|numeric',
            'jumlah_sks_pilihan' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nama_kurikulum.required' => 'Nama kurikulum tidak boleh kosong',
            'mulai_berlaku.required' => 'Semester tidak boleh kosong',
            'kode_prodi.required' => 'Prodi tidak boleh kosong',
            'jumlah_sks_lulus.required' => 'Jumlah SKS lulus tidak boleh kosong',
            'jumlah_sks_wajib.required' => 'Jumlah SKS wajib tidak boleh kosong',
            'jumlah_sks_pilihan.required' => 'Jumlah SKS pilihan tidak boleh kosong',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Simpan data ke database
        $kurikulum = Kurikulum::create([
            'nama_kurikulum' => $validatedData['nama_kurikulum'],
            'mulai_berlaku' => $validatedData['mulai_berlaku'],
            'kode_prodi' => $validatedData['kode_prodi'],
            'jumlah_sks_lulus' => $validatedData['jumlah_sks_lulus'],
            'jumlah_sks_wajib' => $validatedData['jumlah_sks_wajib'],
            'jumlah_sks_pilihan' => $validatedData['jumlah_sks_pilihan'],
        ]);

        $this->reset();
        $this->dispatch('KurikulumCreated');
        return $kurikulum;
    }

    public function render()
    {
        $semesters = Semester::all();
        $prodis = Prodi::all();
        return view('livewire.admin.kurikulum.create', [
            'semesters' => $semesters,
            'prodis' => $prodis
        ]);
    }
}
