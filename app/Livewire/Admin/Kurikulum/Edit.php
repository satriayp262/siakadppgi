<?php

namespace App\Livewire\Admin\Kurikulum;

use Livewire\Component;
use App\Models\Kurikulum;
use App\Models\Prodi;
use App\Models\Semester;

class Edit extends Component
{
    public $id_kurikulum;
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
            'jumlah_sks_lulus' => 'nullable|numeric',
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
            'jumlah_sks_lulus.numeric' => 'Jumlah SKS lulus harus berupa angka',
            'jumlah_sks_wajib.required' => 'Jumlah SKS wajib tidak boleh kosong',
            'jumlah_sks_pilihan.required' => 'Jumlah SKS pilihan tidak boleh kosong',
        ];
    }

    public function mount($id_kurikulum)
    {
        $kurikulum = Kurikulum::find($id_kurikulum);
        if ($kurikulum) {
            $this->nama_kurikulum = $kurikulum->nama_kurikulum;
            $this->mulai_berlaku = $kurikulum->mulai_berlaku;
            $this->kode_prodi = $kurikulum->kode_prodi;
            $this->jumlah_sks_lulus = $kurikulum->jumlah_sks_lulus;
            $this->jumlah_sks_wajib = $kurikulum->jumlah_sks_wajib;
            $this->jumlah_sks_pilihan = $kurikulum->jumlah_sks_pilihan;
        }
        return $kurikulum;
    }

    public function clear($id_kurikulum)
    {
        $this->dispatch('refreshComponent');
        $kurikulum = Kurikulum::find($id_kurikulum);
        if ($kurikulum) {
            $this->id_kurikulum = $kurikulum->id_kurikulum;
            $this->nama_kurikulum = $kurikulum->nama_kurikulum;
            $this->mulai_berlaku = $kurikulum->mulai_berlaku;
            $this->kode_prodi = $kurikulum->kode_prodi;
            $this->jumlah_sks_lulus = $kurikulum->jumlah_sks_lulus;
            $this->jumlah_sks_wajib = $kurikulum->jumlah_sks_wajib;
            $this->jumlah_sks_pilihan = $kurikulum->jumlah_sks_pilihan;
        }
    }

    public function update()
    {
        $validateData = $this->validate();
        $kurikulum = Kurikulum::find($this->id_kurikulum);
        if ($kurikulum) {
            $kurikulum->update($validateData);

        }
        $this->clear($this->id_kurikulum);
        $this->dispatch('KurikulumUpdated');

    }

    public function render()
    {
        $semesters = Semester::all();
        $prodis = Prodi::all();
        return view('livewire.admin.kurikulum.edit', [
            'semesters' => $semesters,
            'prodis' => $prodis
        ]);
    }
}
