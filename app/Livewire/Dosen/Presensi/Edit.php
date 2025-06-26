<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use App\Models\Mahasiswa;
use Livewire\Component;

class Edit extends Component
{
    public $id_presensi, $nama, $nim, $keterangan, $alasan, $nama_mahasiswa, $token;

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

    public function mount($nim, $token)
    {
        $this->nim = $nim;
        $this->token = $token;
        // dd($this->token);
        $presensi = Presensi::where('token', $this->token)
            ->where('nim', $this->nim)->first();

        // dd($this->nim, $presensi->nim);

        if ($presensi) {
            $this->nama = $presensi->mahasiswa->nama;
            $this->keterangan = $presensi->keterangan ?? '';
            $this->alasan = $presensi->alasan;
            $this->id_presensi = $presensi->id;
        } else {
            $mahasiswa = Mahasiswa::where('NIM', $this->nim)->first();
            $this->nama = $mahasiswa->nama;
        }
    }


    public function clear($id_presensi)
    {
        $this->resetExcept('prodi');
        $presensi = Presensi::find($id_presensi);
        if ($id_presensi) {
            $this->id_presensi = $presensi->id;
            $this->nama = $presensi->nama;
            $this->nim = $presensi->nim;
            $this->keterangan = $presensi->keterangan;
            $this->alasan = $presensi->alasan;
        }
    }

    public function update()
    {
        // dd($this->validate());
        $validatedData = $this->validate();

        $presensi = Presensi::find($this->id_presensi);
        // dd($this->id_presensi, $validatedData);
        if ($presensi) {
            if ($this->keterangan != 'Ijin') {
                $validatedData['alasan'] = null;
            }

            if ($presensi->update($validatedData)) {
                $this->dispatch('presensi-updated');
            }
        }
    }

    public function render()
    {
        return view('livewire.dosen.presensi.edit');
    }
}
