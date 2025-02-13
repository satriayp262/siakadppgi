<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Presensi;
use App\Models\KRS;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Kurikulum;
use App\Models\Token;
use Illuminate\Support\Carbon;


class Index extends Component
{
    public $matakuliah;
    public $prodi;
    public $dosen;
    public $mahasiswa;
    public $user;
    public $kelas;
    public $semester;
    public $kurikulum;

    public function mount()
    {
        $matkul = Matakuliah::query()->count();
        $this->matakuliah = $matkul;

        $prodis = Prodi::query()->count();
        $this->prodi = $prodis;

        $dosens = Dosen::query()->count();
        $this->dosen = $dosens;

        $mahasiswas = Mahasiswa::query()->count();
        $this->mahasiswa = $mahasiswas;

        $users = User::query()->count();
        $this->user = $users;

        $kelass = Kelas::query()->count();
        $this->kelas = $kelass;

        $semesters = Semester::query()->count();
        $this->semester = $semesters;

        $kurikulums = Kurikulum::query()->count();
        $this->kurikulum = $kurikulums;

        $this->tandaiAlfa();
    }

    private function tandaiAlfa()
    {
        $token = Token::all(); // Ambil semua token yang ada

        foreach ($token as $token) {
            // Cek apakah waktu valid_until sudah lewat
            if (Carbon::now()->greaterThan($token->valid_until)) {

                // Ambil mahasiswa yang terdaftar di kelas dan mata kuliah tertentu
                $mahasiswaTerdaftar = Mahasiswa::whereIn(
                    'NIM',
                    KRS::where('id_kelas', $token->id_kelas)
                        ->where('id_mata_kuliah', $token->id_mata_kuliah)
                        ->pluck('NIM')
                )->get();

                // Ambil mahasiswa yang sudah presensi
                $sudahPresensi = Presensi::where('id_kelas', $token->id_kelas)
                    ->where('id_mata_kuliah', $token->id_mata_kuliah)
                    ->where('token', $token->token)
                    ->pluck('nim');

                // Cari mahasiswa yang belum presensi
                $belumPresensi = $mahasiswaTerdaftar->whereNotIn('NIM', $sudahPresensi);

                // Simpan presensi dengan keterangan "Alfa"
                foreach ($belumPresensi as $mhs) {
                    Presensi::create([
                        'nim' => $mhs->NIM,
                        'id_mata_kuliah' => $token->id_mata_kuliah,
                        'id_kelas' => $token->id_kelas,
                        'token' => $token->token,
                        'keterangan' => 'Alfa',
                        'waktu_submit' => Carbon::now(), // Waktu saat data disimpan
                    ]);

                    echo "Mahasiswa dengan NIM {$mhs->NIM} otomatis diberi keterangan Alfa.<br>";
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.index');
    }
}
