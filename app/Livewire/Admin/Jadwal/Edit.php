<?php

namespace App\Livewire\Admin\Jadwal;

use Livewire\Component;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\KRS;
use App\Models\Ruangan;
use App\Models\request_dosen;

class Edit extends Component
{
    public $id_jadwal;
    public $id_kelas;
    public $nidn;
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
    public $r = '';


    public function mount($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);

        $this->id_jadwal = $jadwal->id_jadwal;
        $this->id_kelas = $jadwal->id_kelas;
        $this->nidn = $jadwal->nidn;
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

    public function switch()
    {
        $this->edit = 'switch';
    }

    public function ganti()
    {
        $this->edit = 'ganti';
    }

    public function gabung()
    {
        $this->edit = 'gabung';
    }

    public function ruangan()
    {
        $this->edit = 'ruangan';
    }

    public function tukar()
    {
        $target = Jadwal::find($this->target);
        $ammo = Jadwal::find($this->id_jadwal);
        $request = request_dosen::where('nidn', $target->nidn)
            ->where('id_mata_kuliah', $target->id_mata_kuliah)
            ->where('id_kelas', $target->id_kelas)
            ->where('status', 'edit')
            ->first();
        $request2 = request_dosen::where('nidn', $ammo->nidn)
            ->where('id_mata_kuliah', $ammo->id_mata_kuliah)
            ->where('id_kelas', $ammo->id_kelas)
            ->where('status', 'edit')
            ->first();

        // Simpan nilai asli id_kelas ke variabel sementara
        $tempHari = $target->hari;
        $tempSesi = $target->sesi;


            // $jumlahTarget = KRS::where('id_kelas', $target->id_kelas)->count();
            // $kapasitasTarget = Ruangan::where('id_ruangan', $target->id_ruangan)->first()->kapasitas;
            // $jumlahAmmo = KRS::where('id_kelas', $ammo->id_kelas)->count();
            // $kapasitasAmmo = Ruangan::where('id_ruangan', $ammo->id_ruangan)->first()->kapasitas;

            // if ($kapasitasTarget >= $jumlahAmmo && $kapasitasAmmo >= $jumlahTarget) {
                $conflict = jadwal::where('hari', $target->hari)
                    ->where('sesi', $target->sesi)
                    ->where('nidn', $ammo->nidn)
                    ->exists();

                $conflict2 = jadwal::where('hari', $ammo->hari)
                    ->where('sesi', $ammo->sesi)
                    ->where('nidn', $target->nidn)
                    ->exists();
            // }

            if (!$conflict && !$conflict2) {
                // Tukar id_kelas antara target dan ammo
                $target->update([
                    'hari' => $ammo->hari,
                    'sesi' => $ammo->sesi
                ]);

                if ($request) {
                    if ($request->to_hari == $ammo->hari && $request->to_sesi == $ammo->sesi) {
                        $request->update([
                            'status' => 'ok',
                            'to_hari' => null,
                            'to_sesi' => null
                        ]);
                    }

                    $request->update([
                        'hari' => $ammo->hari,
                        'sesi' => $ammo->sesi
                    ]);
                }

                $ammo->update([
                    'hari' => $tempHari,
                    'sesi' => $tempSesi
                ]);

                if ($request2) {
                    if ($request2->to_hari == $tempHari && $request2->to_sesi == $tempSesi) {
                        $request2->update([
                            'status' => 'ok',
                            'to_hari' => null,
                            'to_sesi' => null
                        ]);
                    }

                    $request2->update([
                        'hari' => $tempHari,
                        'sesi' => $tempSesi
                    ]);

                }

                $this->clear($this->id_jadwal);
            $this->dispatch('Tukar');
            } else {
                if ($conflict) {

                    if ($target->hari == 'Monday') {
                        $target->hari = 'Senin';
                    } elseif ($target->hari == 'Tuesday') {
                        $target->hari = 'Selasa';
                    } elseif ($target->hari == 'Wednesday') {
                        $target->hari = 'Rabu';
                    } elseif ($target->hari == 'Thursday') {
                        $target->hari = 'Kamis';
                    } elseif ($target->hari == 'Friday') {
                        $target->hari = 'Jumat';
                    }

                    $dosen = $ammo->dosen->nama_dosen;
                    $this->dispatch('warning', ['message' => 'Sudah ada jadwal untuk dosen ' . $dosen . ' di hari ' . $target->hari . ' sesi ' . $target->sesi]);

                } elseif ($conflict2) {

                    if ($ammo->hari == 'Monday') {
                        $ammo->hari = 'Senin';
                    } elseif ($ammo->hari == 'Tuesday') {
                        $ammo->hari = 'Selasa';
                    } elseif ($ammo->hari == 'Wednesday') {
                        $ammo->hari = 'Rabu';
                    } elseif ($ammo->hari == 'Thursday') {
                        $ammo->hari = 'Kamis';
                    } elseif ($ammo->hari == 'Friday') {
                        $ammo->hari = 'Jumat';
                    }

                    $dosen = $target->dosen->nama_dosen;
                    $this->dispatch('warning', ['message' => 'Sudah ada jadwal untuk dosen ' . $dosen . ' di hari ' . $ammo->hari . ' sesi ' . $ammo->sesi]);

                }
            }
    }

    public function combine()
    {
        $target = Jadwal::find($this->target);
        $ammo = Jadwal::find($this->id_jadwal);

        $exists = Jadwal::where('id_jadwal', '!=', $target->id_jadwal)
            ->where('id_jadwal', '!=', $ammo->id_jadwal)
            ->where('hari', $ammo->hari)
            ->where('sesi', $ammo->sesi)
            ->exists();

        if ($exists) {
            $this->dispatch('warning', ['message' => 'Jadwal di hari ' . $ammo->hari . ' dan sesi ' . $ammo->sesi . ' sudah terpakai.']);
            return;
        }

        $target->update([
            'id_ruangan' => $ammo->id_ruangan,
            'hari' => $ammo->hari,
            'sesi' => $ammo->sesi
        ]);

        $this->dispatch('Gabung');
    }

    public function room()
    {
        $jadwal = Jadwal::find($this->id_jadwal);

        $conflict = jadwal::where('id_kelas', '!=', $jadwal->id_kelas)
            ->where('id_jadwal', '!=', $jadwal->id_jadwal)
            ->where('id_ruangan', $this->r)
            ->where('hari', $jadwal->hari)
            ->where('sesi', $jadwal->sesi)
            ->exists();

        $conflict2 = jadwal::where('id_kelas', $jadwal->id_kelas)
            ->where('id_jadwal', '!=', $jadwal->id_jadwal)
            ->where('id_ruangan', $this->r)
            ->where('hari', $jadwal->hari)
            ->where('sesi', $jadwal->sesi)
            ->exists();

        $ruangan = ruangan::where('id_ruangan', $this->r)->first();

        $jumlah = Krs::where('id_kelas', $jadwal->id_kelas)
            ->where('grup_praktikum', $jadwal->grup)
            ->where('id_semester', $jadwal->id_semester)
            ->distinct('NIM')
            ->count('NIM');
        if (!$conflict && !$conflict2 && $ruangan->kapasitas >= $jumlah) {
            $jadwal->update([
                'id_ruangan' => $this->r
            ]);

            $this->dispatch('ruanganUpdated');
        }elseif ($conflict || $conflict2) {
            if ($jadwal->hari == 'Monday') {
                $jadwal->hari = 'Senin';
            } elseif ($jadwal->hari == 'Tuesday') {
                $jadwal->hari = 'Selasa';
            } elseif ($jadwal->hari == 'Wednesday') {
                $jadwal->hari = 'Rabu';
            } elseif ($jadwal->hari == 'Thursday') {
                $jadwal->hari = 'Kamis';
            } elseif ($jadwal->hari == 'Friday') {
                $jadwal->hari = 'Jumat';
            }

            $ruangan = ruangan::where('id_ruangan', $this->r)->first();
            $this->dispatch('warning', ['message' => 'Ruangan ' . $ruangan->kode_ruangan . ' Pada Hari ' . $jadwal->hari . ' Dan Sesi ' . $jadwal->sesi . ' Sudah Dipakai']);
        }elseif ($ruangan->kapasitas < $jumlah) {
            $this->dispatch('warning', ['message' => 'Ruangan ' . $ruangan->kode_ruangan . ' Kapasitasnya Tidak Mencukupi']);
        }
    }

    public function update()
    {

        $jadwal = Jadwal::find($this->id_jadwal);
        $request = request_dosen::where('nidn', $jadwal->nidn)
            ->where('id_mata_kuliah', $jadwal->id_mata_kuliah)
            ->where('id_kelas', $jadwal->id_kelas)
            ->where('status', 'edit')
            ->first();


        if (!$this->z) {
            $conflict3 = jadwal::where('hari', $jadwal->hari)
                ->where('sesi', $this->x)
                // ->where('nidn', $jadwal->nidn)
                ->where('id_kelas', $jadwal->id_kelas)
                ->where('id_jadwal', '!=', $jadwal->id_jadwal)
                ->exists();
        }elseif (!$this->x) {
            $conflict3 = jadwal::where('hari', $this->z)
                ->where('sesi', $jadwal->sesi)
                // ->where('nidn', $jadwal->nidn)
                ->where('id_kelas', $jadwal->id_kelas)
                ->where('id_jadwal', '!=', $jadwal->id_jadwal)
                ->exists();
        }else{
            $conflict3 = jadwal::where('hari', $this->z)
                ->where('sesi', $this->x)
                // ->where('nidn', $jadwal->nidn)
                ->where('id_kelas', $jadwal->id_kelas)
                ->where('id_jadwal', '!=', $jadwal->id_jadwal)
                ->exists();
        }

        if (!$this->z) {
            $conflict4 = jadwal::where('id_kelas', '!=', $jadwal->id_kelas)
                ->where('id_jadwal', '!=', $jadwal->id_jadwal)
                ->where('nidn', $jadwal->nidn)
                ->where('hari', $jadwal->hari)
                ->where('sesi', $this->x)
                ->exists();
        }elseif (!$this->x) {
            $conflict4 = jadwal::where('id_kelas', '!=', $jadwal->id_kelas)
                ->where('id_jadwal', '!=', $jadwal->id_jadwal)
                ->where('nidn', $jadwal->nidn)
                ->where('hari', $this->z)
                ->where('sesi', $jadwal->sesi)
                ->exists();
        } else {
            $conflict4 = jadwal::where('id_kelas', '!=', $jadwal->id_kelas)
                ->where('id_jadwal', '!=', $jadwal->id_jadwal)
                ->where('nidn', $jadwal->nidn)
                ->where('hari', $this->z)
                ->where('sesi', $this->x)
                ->exists();
        }

        if (!$conflict3 && !$conflict4) {
            if ($this->z && $this->x) {
                $jadwal->update([
                    'hari' => $this->z,
                    'sesi' => $this->x
                ]);

                if ($request) {
                    if ($request->to_hari == $this->z && $request->to_sesi == $this->x) {
                        $request->update([
                            'status' => 'ok',
                            'to_hari' => null,
                            'to_sesi' => null
                        ]);
                    }

                    $request->update([
                        'hari' => $this->z,
                        'sesi' => $this->x
                    ]);
                }

                $this->clear($this->id_jadwal);
                $this->dispatch('Update');
            }elseif ($this->z) {
                $jadwal->update([
                    'hari' => $this->z
                ]);

                if ($request) {
                    if ($request->to_hari == $this->z && $request->to_sesi == null) {
                        $request->update([
                            'status' => 'ok',
                            'to_hari' => null,
                        ]);
                    }

                    if ($request->to_sesi == $request->sesi && $request->to_hari == $this->z) {
                        $request->update([
                            'status' => 'ok',
                            'to_hari' => null,
                            'to_sesi' => null
                        ]);
                    }

                    $request->update([
                        'hari' => $this->z,
                    ]);
                }

                $this->clear($this->id_jadwal);
                $this->dispatch('Update');
            }elseif ($this->x) {
                $jadwal->update([
                    'sesi' => $this->x
                ]);

                if ($request) {
                    if ($request->to_sesi == $this->x && $request->to_hari == null) {
                        $request->update([
                            'status' => 'ok',
                            'to_sesi' => null
                        ]);
                    }

                    if ($request->to_sesi == $this->x && $request->to_hari == $request->hari) {
                        $request->update([
                            'status' => 'ok',
                            'to_hari' => null,
                            'to_sesi' => null
                        ]);
                    }

                    $request->update([
                        'sesi' => $this->x
                    ]);

                }

                $this->clear($this->id_jadwal);
                $this->dispatch('Update');
            }
        }

        if ($conflict3) {

            if ($this->hari == 'Monday') {
                $this->hari = 'Senin';
            } elseif ($this->hari == 'Tuesday') {
                $this->hari = 'Selasa';
            } elseif ($this->hari == 'Wednesday') {
                $this->hari = 'Rabu';
            } elseif ($this->hari == 'Thursday') {
                $this->hari = 'Kamis';
            } elseif ($this->hari == 'Friday') {
                $this->hari = 'Jumat';
            }

            if ($this->z == 'Monday') {
                $this->z = 'Senin';
            } elseif ($this->z == 'Tuesday') {
                $this->z = 'Selasa';
            } elseif ($this->z == 'Wednesday') {
                $this->z = 'Rabu';
            } elseif ($this->z == 'Thursday') {
                $this->z = 'Kamis';
            } elseif ($this->z == 'Friday') {
                $this->z = 'Jumat';
            }

            if (!$this->x) {
                $this->dispatch('warning', ['message' => 'Jadwal di kelas ' . $jadwal->kelas->nama_kelas . ' hari ' . $this->z . ' dan sesi ' . $this->sesi . ' sudah ada']);

            }else if (!$this->z) {
                $this->dispatch('warning', ['message' => 'Jadwal di kelas ' . $jadwal->kelas->nama_kelas . ' hari ' . $this->hari . ' dan sesi ' . $this->x . ' sudah ada']);
            }else{

                $this->dispatch('warning', ['message' => 'Jadwal di kelas ' . $jadwal->kelas->nama_kelas . ' hari ' . $this->z . ' dan sesi ' . $this->x . ' sudah ada']);
            }
        }elseif ($conflict4) {

            if ($this->z == 'Monday') {
                $this->z = 'Senin';
            } elseif ($this->z == 'Tuesday') {
                $this->z = 'Selasa';
            } elseif ($this->z == 'Wednesday') {
                $this->z = 'Rabu';
            } elseif ($this->z == 'Thursday') {
                $this->z = 'Kamis';
            } elseif ($this->z == 'Friday') {
                $this->z = 'Jumat';
            }

            if ($jadwal->hari == 'Monday') {
                $jadwal->hari = 'Senin';
            } elseif ($jadwal->hari == 'Tuesday') {
                $jadwal->hari = 'Selasa';
            } elseif ($jadwal->hari == 'Wednesday') {
                $jadwal->hari = 'Rabu';
            } elseif ($jadwal->hari == 'Thursday') {
                $jadwal->hari = 'Kamis';
            } elseif ($jadwal->hari == 'Friday') {
                $jadwal->hari = 'Jumat';
            }

            $dosen = $jadwal->dosen->nama_dosen;
            $a = jadwal::where('nidn', $jadwal->nidn)
                ->where('id_jadwal', '!=', $jadwal->id_jadwal)
                ->first();
            $b = $a->id_kelas;
            $c = Kelas::where('id_kelas', $b)->first();
            $kelas = $c->nama_kelas;

            if (!$this->x) {
                $this->dispatch('warning', ['message' => 'Dosen ' . $dosen . ' sudah memiliki jadwal di hari ' . $this->z . ' dan sesi ' . $jadwal->sesi . ' pada kelas ' . $kelas]);
            }elseif (!$this->z) {
                $this->dispatch('warning', ['message' => 'Dosen ' . $dosen . ' sudah memiliki jadwal di hari ' . $jadwal->hari . ' dan sesi ' . $this->x . ' pada kelas ' . $kelas]);

            } else {
                $this->dispatch('warning', ['message' => 'Dosen ' . $dosen . ' sudah memiliki jadwal di hari ' . $this->z . ' dan sesi ' . $this->x . ' pada kelas ' . $kelas]);
            }
        }

    }

    public function render()
    {
        $jadwals = jadwal::where('id_jadwal', '!=', $this->id_jadwal)
            ->where('id_kelas', $this->id_kelas)
            ->where('kode_prodi', $this->kode_prodi)
            ->where('id_semester', $this->id_semester)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")            ->get();

        $jadwals2 = jadwal::where('id_jadwal', '!=', $this->id_jadwal)
            ->where('nidn', $this->nidn)
            ->where('kode_prodi', $this->kode_prodi)
            ->where('id_semester', $this->id_semester)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")            ->get();

        $ammo = jadwal::where('id_jadwal', $this->id_jadwal)
            ->first();

        $request = request_dosen::all();

        $jadwal = Jadwal::find($this->id_jadwal);

        $jumlahMahasiswa = Krs::where('id_kelas', $jadwal->id_kelas)
            ->where('grup_praktikum', $jadwal->grup)
            ->where('id_semester', $jadwal->id_semester)
            ->distinct('NIM')
            ->count('NIM');

        $ruanganTerpakai = Jadwal::where('hari', $jadwal->hari)
            ->where('sesi', $jadwal->sesi)
            ->where('id_jadwal', '!=', $jadwal->id_jadwal)
            ->pluck('id_ruangan');

        $ruangans = Ruangan::where('kapasitas', '>=', $jumlahMahasiswa)
            ->whereNotIn('id_ruangan', $ruanganTerpakai)
            ->where('id_ruangan', '!=', $jadwal->id_ruangan)
            ->get();

        // Filter data yang cocok dengan ammo (untuk efisiensi & keterbacaan)
        $matchRequest = $request->filter(function ($item) use ($ammo) {
            return $item->nidn == $ammo->nidn &&
                $item->id_mata_kuliah == $ammo->id_mata_kuliah &&
                $item->id_kelas == $ammo->id_kelas &&
                $item->hari == $ammo->hari &&
                $item->sesi == $ammo->sesi;
        });

        // Cek apakah ada request dengan status 'edit' dan 'ok'
        $l = $matchRequest->contains('status', 'edit');
        $ok = $matchRequest->contains('status', 'ok');

        // Ambil request pertama dengan status 'edit'
        $editRequest = $matchRequest->firstWhere('status', 'edit');

        // Return ke view
        return view('livewire.admin.jadwal.edit', [
            'jadwals' => $jadwals,
            'jadwals2' => $jadwals2,
            'ammo' => $ammo,
            'ruangans' => $ruangans,
            'l' => $l,
            'ok' => $ok,
            'request' => $request,
            'editRequest' => $editRequest,
        ]);
    }
}
