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
use DateTime;
use DateTimeZone;


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
        $tokens = Token::all();
        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

        foreach ($tokens as $token) {
            // Convert valid_until to DateTime object for proper comparison
            $validUntil = new DateTime($token->valid_until, new DateTimeZone('Asia/Jakarta'));

            // Debug: uncomment to see what's happening
            // Log::info("Current time: " . $now->format('Y-m-d H:i:s'));
            // Log::info("Valid until: " . $validUntil->format('Y-m-d H:i:s'));
            // Log::info("Is expired: " . ($now > $validUntil ? 'YES' : 'NO'));

            // Proper DateTime comparison
            if ($now > $validUntil) {

                // Get registered students for this class and subject
                $registeredStudents = Mahasiswa::whereIn(
                    'NIM',
                    KRS::where('id_kelas', $token->id_kelas)
                        ->where('id_mata_kuliah', $token->id_mata_kuliah)
                        ->pluck('NIM')
                )->get();

                // Get students who already have attendance
                $attendedStudentIds = Presensi::where('id_kelas', $token->id_kelas)
                    ->where('id_mata_kuliah', $token->id_mata_kuliah)
                    ->where('token', $token->token)
                    ->pluck('id_mahasiswa')
                    ->toArray();

                // Find students who haven't attended
                $absentStudents = $registeredStudents->whereNotIn('id_mahasiswa', $attendedStudentIds);

                // Mark absent students as "Alpha"
                foreach ($absentStudents as $student) {
                    Presensi::create([
                        'id_mahasiswa' => $student->id_mahasiswa,
                        'id_mata_kuliah' => $token->id_mata_kuliah,
                        'id_kelas' => $token->id_kelas,
                        'token' => $token->token,
                        'keterangan' => 'Alpha',
                        'waktu_submit' => $now->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.index');
    }
}
