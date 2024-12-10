<?php

namespace App\Livewire\Admin\Jadwal;

use Livewire\Component;
use App\Models\Jadwal;

class Edit extends Component
{
    public $id_jadwal;
    public $id_kelas;
    public $id_ruangan;
    public $hari;
    public $jam_mulai;
    public $jam_selesai;
    public $sesi;
    public $tanggal;
    public $id_semester;
    public $kode_prodi;
    public $target;


    public function mount($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);

        $this->id_jadwal = $jadwal->id_jadwal;
        $this->id_kelas = $jadwal->id_kelas;
        $this->id_ruangan = $jadwal->id_ruangan;
        $this->hari = $jadwal->hari;
        $this->jam_mulai = $jadwal->jam_mulai;
        $this->jam_selesai = $jadwal->jam_selesai;
        $this->sesi = $jadwal->sesi;
        $this->tanggal = $jadwal->tanggal;
        $this->id_semester = $jadwal->id_semester;
        $this->kode_prodi = $jadwal->kode_prodi;
    }

    public function clear($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);

        $this->id_jadwal = $jadwal->id_jadwal;
        $this->id_kelas = $jadwal->id_kelas;
        $this->id_ruangan = $jadwal->id_ruangan;
        $this->hari = $jadwal->hari;
        $this->jam_mulai = $jadwal->jam_mulai;
        $this->jam_selesai = $jadwal->jam_selesai;
        $this->sesi = $jadwal->sesi;
        $this->tanggal = $jadwal->tanggal;
        $this->id_semester = $jadwal->id_semester;
        $this->kode_prodi = $jadwal->kode_prodi;
    }

    public function tukar()
    {
        $target = Jadwal::find($this->target);
        $ammo = Jadwal::find($this->id_jadwal);

        // Simpan nilai asli id_kelas ke variabel sementara
        $tempIdKelas = $target->id_kelas;

        // Tukar id_kelas antara target dan ammo
        $target->update([
            'id_kelas' => $ammo->id_kelas,
        ]);

        $ammo->update([
            'id_kelas' => $tempIdKelas,
        ]);
        
        $this->dispatch('jadwalUpdated');
    }


    public function render()
    {
        $jadwals = jadwal::get()
            ->where('kode_prodi', $this->kode_prodi)
            ->where('id_semester', $this->id_semester);

        $ammo = jadwal::get()
            ->where('id_jadwal', $this->id_jadwal);

        return view('livewire.admin.jadwal.edit',[
            'jadwals' => $jadwals,
            'ammo' => $ammo
        ]);
    }
}
