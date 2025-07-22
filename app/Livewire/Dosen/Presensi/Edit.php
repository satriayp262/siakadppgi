<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use App\Models\Mahasiswa;
use Livewire\Component;

class Edit extends Component
{
    public $id_presensi;
    public $id_mahasiswa;
    public $token;
    public $nama;
    public $nim;
    public $keterangan;
    public $alasan;

    public function rules()
    {
        $rules = [
            'keterangan' => 'required',
        ];

        if ($this->keterangan === 'Ijin') {
            $rules['alasan'] = 'required|string';
        } else {
            $rules['alasan'] = 'nullable|string';
        }

        return $rules;
    }

    public function mount($id_mahasiswa, $token)
    {
        $this->id_mahasiswa = $id_mahasiswa;
        $this->token = $token;

        $presensi = Presensi::where('token', $this->token)
            ->where('id_mahasiswa', $this->id_mahasiswa)
            ->first();

        if ($presensi) {
            $this->id_presensi = $presensi->id;
            $this->keterangan = $presensi->keterangan ?? '';
            $this->alasan = $presensi->alasan ?? null;
            $this->nama = $presensi->mahasiswalist->nama ?? '-';
            $this->nim = $presensi->mahasiswalist->NIM ?? '-';
        } else {
            $mahasiswalist = Mahasiswa::find($this->id_mahasiswa);
            $this->nama = $mahasiswalist->nama ?? '-';
            $this->nim = $mahasiswalist->NIM ?? '-';
        }
    }


    public function clear($id_presensi)
    {
        $this->resetExcept(['id_mahasiswa', 'token']); // reset selain yang penting
        $presensi = Presensi::find($id_presensi);

        if ($presensi) {
            $this->id_presensi = $presensi->id;
            $this->keterangan = $presensi->keterangan;
            $this->alasan = $presensi->alasan;

            // Tetap ambil dari relasi
            $this->nama = $presensi->mahasiswa->nama ?? '-';
            $this->nim = $presensi->mahasiswa->NIM ?? '-';
        }
    }

    public function update()
    {
        $validatedData = $this->validate();

        $presensi = Presensi::find($this->id_presensi);

        if ($presensi) {
            if ($this->keterangan !== 'Ijin') {
                $validatedData['alasan'] = null;
            }

            $presensi->update($validatedData);

            // Kirim event ke komponen tabel agar bisa refresh
            $this->dispatch('presensi-updated');
        }
    }

    public function render()
    {
        return view('livewire.dosen.presensi.edit');
    }
}
