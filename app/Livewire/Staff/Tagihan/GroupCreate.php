<?php

namespace App\Livewire\Staff\Tagihan;

use App\Mail\TagihanMail;
use App\Models\Staff;
use Livewire\Component;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Tagihan;

use Illuminate\Support\Facades\Mail;


class GroupCreate extends Component
{
    public $total_tagihan;
    public $angkatan = '';
    public $status_tagihan = '';
    public $semester = '';
    public $jenis_tagihan = '';
    public $kode_prodi = '';
    public $tagihan_lain;
    public $selectedMahasiswa = [];
    public $cicil = false;
    public $staff;
    public $semesters = [];

    public function mount()
    {

        $semesters = Semester::orderBy('id_semester', 'asc')->get();
        $user = auth()->user();
        $staff = Staff::where('nip', $user->nim_nidn)->first();

        $this->staff = $staff;
        $this->semesters = $semesters;
    }

    public function rules()
    {
        return [
            'angkatan' => 'required|exists:semester,id_semester',
            'kode_prodi' => 'required|exists:prodi,kode_prodi',
            'semester' => 'required|exists:semester,id_semester',
            'jenis_tagihan' => 'required|string',
            'total_tagihan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'angkatan.required' => 'Angkatan Wajib dipilih.',
            'angkatan.exists' => 'Angkatan harus dari semester yang valid.',
            'kode_prodi.required' => 'Prodi Wajib dipilih.',
            'kode_prodi.exists' => 'Prodi harus dari prodi yang valid.',
            'semester.required' => 'Semester Wajib dipilih.',
            'semester.exists' => 'Semester harus dari semester yang valid.',
            'jenis_tagihan.required' => 'Jenis Tagihan Wajib dipilih.',
            'jenis_tagihan.string' => 'Jenis Tagihan harus berupa string.',
            'total_tagihan.required' => 'Total Tagihan Wajib diisi.',
        ];
    }


    public function save()
    {
        $validatedData = $this->validate();

        // Get information
        $staff = $this->staff;
        $semester = Semester::where('id_semester', $validatedData['semester'])->first();

        // Remove non-digit characters from total_tagihan
        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

        // Retrieve Mahasiswa matching the criteria
        if ($validatedData['kode_prodi'] == 'all' && $validatedData['angkatan'] == 'all') {
            $mahasiswa = Mahasiswa::whereNotNull('kode_prodi')
                ->whereNotNull('mulai_semester')
                ->get();
        } elseif ($validatedData['kode_prodi'] == 'all') {
            $mahasiswa = Mahasiswa::whereNotNull('kode_prodi')
                ->where('mulai_semester', $validatedData['angkatan'])
                ->get();
        } elseif ($validatedData['angkatan'] == 'all') {
            $mahasiswa = Mahasiswa::where('kode_prodi', $validatedData['kode_prodi'])
                ->whereNotNull('mulai_semester')
                ->get();
        } else {
            $mahasiswa = Mahasiswa::where('kode_prodi', $validatedData['kode_prodi'])
                ->where('mulai_semester', $validatedData['angkatan'])
                ->get();
        }

        // Check if there are any Mahasiswa matching the criteria
        if ($mahasiswa->isEmpty()) {
            $this->addError('angkatan', 'Tidak ada mahasiswa aktif yang terdaftar pada semester ini.');
            return;
        }

        // Check if there are any Mahasiswa matching the criteria
        if ($mahasiswa->isEmpty()) {
            $this->addError('kode_prodi', 'Tidak ada mahasiswa aktif yang terdaftar pada prodi ini.');
            return;
        }

        // Renaming the 'jenis_tagihan' field
        if ($validatedData['jenis_tagihan'] != 'BPP') {
            $jenis_tagihan = $this->tagihan_lain;
        } else {
            $jenis_tagihan = $validatedData['jenis_tagihan'] . ' Semester ' . $semester->nama_semester;
        }

        $cicil = $this->cicil;


        // Check if there are any Mahasiswa matching the criteria
        foreach ($mahasiswa as $mhs) {
            $existingTagihan = Tagihan::where('NIM', $mhs->NIM)
                ->where('jenis_tagihan', $jenis_tagihan)
                ->where('id_semester', $validatedData['semester'])
                ->first();

            // Check if there is already a Tagihan for the Mahasiswa
            if ($existingTagihan) {
                $this->addError('jenis_tagihan', 'Tagihan sudah ada untuk mahasiswa ' . $mhs->nama);
                return;
            } else {
                // Create a new Tagihan for the Mahasiswa
                $tagihan = Tagihan::create([
                    'NIM' => $mhs->NIM,
                    'total_tagihan' => $validatedData['total_tagihan'],
                    'status_tagihan' => 'Belum Bayar',
                    'jenis_tagihan' => $jenis_tagihan,
                    'bisa_dicicil' => $cicil,
                    'id_semester' => $validatedData['semester'],
                    'id_staff' => $staff->id_staff,
                ]);
                $this->reset(); // Reset only form-related properties
                $this->dispatch('TagihanCreated');
                Mail::to($mhs->email)->send(new TagihanMail($tagihan));
            }
        }
        $this->reset(); // Reset hanya properti terkait form
        return $tagihan ?? null;
    }

    public function render()
    {
        //$semesters = Semester::orderBy('id_semester', 'desc')->get();
        $s = $this->semesters;
        $prodis = Prodi::all();
        $mahasiswas = Mahasiswa::all();
        return view('livewire.staff.tagihan.group-create', [
            'semesters' => $s,
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas
        ]);
    }
}
