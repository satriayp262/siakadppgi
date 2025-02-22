<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use Livewire\Component;

class Edit extends Component
{
    public $id_presensi, $nama, $nim, $keterangan, $alasan;

    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|min:10|max:10|unique:dosen,nidn,' . $this->id_dosen . ',id_dosen',
            'keterangan' => 'required|in:laki-laki,perempuan',
            'alasan' => 'required|string|max:255',
        ];
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

    public function mount($id_presensi)
    {
        $presensi = Presensi::find($id_presensi);
        $this->id_presensi = Presensi::all() ?? collect();
        if ($presensi) {
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
            $presensi->update($validatedData);

            // Reset form except 'prodi' and dispatch browser event
            $this->reset();
            // $this->dispatch('dosenUpdated');
        }
    }

    public function render()
    {
        return view('livewire.dosen.presensi.edit');
    }
}
