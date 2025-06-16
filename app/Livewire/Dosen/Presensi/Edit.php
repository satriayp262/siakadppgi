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
            $this->keterangan = $presensi->keterangan ?? '';
            $this->alasan = $presensi->alasan;
        } else {
            $mahasiswa = Mahasiswa::where('NIM', $this->nim)->first();
            $this->nama = $mahasiswa->nama;
            $this->nim = $mahasiswa->NIM;
        }
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

            if ($presensi->update($validatedData)) {
                // Dispatch event untuk refresh data
                $this->dispatch('presensi-updated');

                // Tutup modal edit (jika menggunakan modal)
                $this->dispatch('close-modal');

                // Tampilkan alert langsung dari komponen
                $this->js("
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data presensi berhasil diperbarui',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            ");
            }
        }
    }

    public function render()
    {
        return view('livewire.dosen.presensi.edit');
    }
}
