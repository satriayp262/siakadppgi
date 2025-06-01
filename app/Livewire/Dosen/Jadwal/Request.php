<?php

namespace App\Livewire\Dosen\Jadwal;

use Livewire\Component;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\KRS;
use App\Models\Ruangan;
use App\Models\Prodi;
use App\Models\request_dosen;
use Carbon\Carbon;


class Request extends Component
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
    public $edit = '';
    public $z = '';
    public $x = '';

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

        $this->edit = '';
        $this->z = '';
        $this->x = '';
    }

    public function update()
    {
        $batas = Jadwal::find($this->id_jadwal);

        if (Carbon::now()->format('Y-m-d') <= $batas->batas_pengajuan) {
            $ammo = Jadwal::find($this->id_jadwal);

            $cek = request_dosen::where('nidn', $ammo->nidn)
                ->where('id_mata_kuliah', $ammo->id_mata_kuliah)
                ->where('id_kelas', $ammo->id_kelas)
                ->where('hari', $ammo->hari)
                ->where('sesi', $ammo->sesi)
                ->first();

            if ($cek) {
                request_dosen::where('id_request', $cek->id_request)->update([
                    'nidn' => $ammo->nidn,
                    'id_mata_kuliah' => $ammo->id_mata_kuliah,
                    'id_kelas' => $ammo->id_kelas,
                    'hari' => $ammo->hari,
                    'sesi' => $ammo->sesi,
                    'to_hari' => $this->z,
                    'to_sesi' => $this->x,
                    'status' => "edit"
                ]);
            }else {
                request_dosen::create([
                    'nidn' => $ammo->nidn,
                    'id_mata_kuliah' => $ammo->id_mata_kuliah,
                    'id_kelas' => $ammo->id_kelas,
                    'hari' => $ammo->hari,
                    'sesi' => $ammo->sesi,
                    'to_hari' => $this->z,
                    'to_sesi' => $this->x,
                    'status' => "edit"
                ]);
            }

            $this->dispatch('updated', ['message' => 'Request Edit Jadwal Berhasil Dibuat']);
        }else {
            $this->dispatch('warning', ['message' => 'Sudah Melewati Batas Pengajuan']);
        }
    }

    public function update2()
    {
        $ammo = Jadwal::find($this->id_jadwal);

        $cek = request_dosen::where('nidn', $ammo->nidn)
            ->where('id_mata_kuliah', $ammo->id_mata_kuliah)
            ->where('id_kelas', $ammo->id_kelas)
            ->where('hari', $ammo->hari)
            ->where('sesi', $ammo->sesi)
            ->first();

        if ($cek) {
            request_dosen::where('id_request', $cek->id_request)->update([
                'nidn' => $ammo->nidn,
                'id_mata_kuliah' => $ammo->id_mata_kuliah,
                'id_kelas' => $ammo->id_kelas,
                'hari' => $ammo->hari,
                'sesi' => $ammo->sesi,
                'status' => "ok"
            ]);
        }else {
            request_dosen::create([
                'nidn' => $ammo->nidn,
                'id_mata_kuliah' => $ammo->id_mata_kuliah,
                'id_kelas' => $ammo->id_kelas,
                'hari' => $ammo->hari,
                'sesi' => $ammo->sesi,
                'status' => "ok"
            ]);
        }

        $this->dispatch('updated', ['message' => 'Jadwal Berhasil Divalidasi']);
    }

    public function render()
    {
        $ammo = jadwal::where('id_jadwal', $this->id_jadwal)
            ->first();

        $batas = Jadwal::find($this->id_jadwal);

        return view('livewire.dosen.jadwal.request',[
            'ammo' => $ammo,
            'batas' => $batas
        ]);
    }
}
