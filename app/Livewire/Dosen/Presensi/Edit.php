<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use App\Models\Mahasiswa;
use Livewire\Component;

class Edit extends Component
{
    public $id_presensi, $nama, $nim, $keterangan, $alasan, $nama_mahasiswa;

    public function rules()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|min:10|max:10',
            'keterangan' => 'required',
        ];

        if ($this->keterangan === 'Ijin') {
            $rules['alasan'] = 'required|string';
        } else {
            $rules['alasan'] = 'nullable|string';
        }

        return $rules;
    }


    public function mount()
    {
        $presensi = Presensi::find($this->id_presensi);

        if ($presensi) {
            $this->nama = $presensi->nama;
            $this->nim = $presensi->nim;
            if ($presensi->keterangan == Null) {
                $this->keterangan = '';
            } else {
                $this->keterangan = $presensi->keterangan;
            }
            $this->alasan = $presensi->alasan;
        } else {
            $mahasiswa = Mahasiswa::where('NIM', $this->nim)->first();
            $this->nama = $mahasiswa->nama;
            $this->nim = $mahasiswa->NIM;
        }
        // dd($this->keterangan);
    }


    public function clear($id_presensi)
    {
        $this->resetExcept('prodi');
        $presensi = Presensi::find($id_presensi);
        if ($id_presensi) {
            $this->id_presensi = $presensi->id_presensi;
            $this->nama = $presensi->nama;
            $this->nim = $presensi->nim;
            $this->keterangan = $presensi->keterangan;
            $this->alasan = $presensi->alasan;
        }
    }


    public function update()
    {
        $validatedData = $this->validate();

        $presensi = Presensi::find($this->id_presensi);
        if ($presensi) {
            if ($this->keterangan != 'Ijin') {
                $validatedData['alasan'] = null;
            }

            $presensi->update($validatedData);

            $this->dispatch('presensiUpdated');
        }
    }

    public function render()
    {
        return view('livewire.dosen.presensi.edit');
    }
}
