<?php

namespace App\Livewire\Admin\Matkul;

use App\Models\Matakuliah;
use Livewire\Component;


class Create extends Component
{
    public $kode_mata_kuliah;
    public $nama_mata_kuliah;
    public $jenis_mata_kuliah;
    public $sks_tatap_muka;
    public $sks_praktek;
    public $sks_praktek_lapangan;
    public $sks_simulasi;
    public $metode_pembelajaran;
    public $tgl_mulai_efektif;
    public $tgl_akhir_efektif;


    public function rules()
    {
        return [
            'kode_mata_kuliah' => 'required|string|unique:matkul,kode_mata_kuliah',
            'nama_mata_kuliah' => 'required|string',
            'jenis_mata_kuliah' => 'required|string',
            'sks_tatap_muka' => 'required|integer',
            'sks_praktek' => 'required|integer',
            'sks_praktek_lapangan' => 'required|integer',
            'sks_simulasi' => 'required|integer',
            'metode_pembelajaran' => 'required|string',
            'tgl_mulai_efektif' => 'required|date',
            'tgl_akhir_efektif' => 'required|date',
        ];
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();

        // Simpan data ke database
        $matkul = Matakuliah::create([
            'kode_mata_kuliah' => $validatedData['kode_mata_kuliah'],
            'nama_mata_kuliah' => $validatedData['nama_mata_kuliah'],
            'jenis_mata_kuliah' => $validatedData['jenis_mata_kuliah'],
            'sks_tatap_muka' => $validatedData['sks_tatap_muka'],
            'sks_praktek' => $validatedData['sks_praktek'],
            'sks_praktek_lapangan' => $validatedData['sks_praktek_lapangan'],
            'sks_simulasi' => $validatedData['sks_simulasi'],
            'metode_pembelajaran' => $validatedData['metode_pembelajaran'],
            'tgl_mulai_efektif' => $validatedData['tgl_mulai_efektif'],
            'tgl_akhir_efektif' => $validatedData['tgl_akhir_efektif']
        ]);

        $this->reset();

        $this->dispatch('matkulCreated');

        return $matkul;

    }

    public function render()
    {
        return view('livewire.admin.matkul.create');
    }
}
