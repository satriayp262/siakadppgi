<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\Component;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Mail;
use App\Mail\TagihanMail;
use App\Models\Staff;

class Create extends Component
{
    public $nim;
    public $nama;
    public $total_tagihan;
    public $status_tagihan = '';
    public $jenis_tagihan = '';
    public $tagihan_lain;
    public $cicil = false;
    public $id_semester = '';
    public $semester = '';
    public $staff;
    public $kode_prodi;
    public $semesters = [];


    public function rules()
    {
        return [
            'total_tagihan' => 'required',
            'semester' => 'required
            |exists:semester,id_semester',
            'jenis_tagihan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'jenis_tagihan.required' => 'Jenis tagihan tidak boleh kosong',
            'semester.required' => 'Semester harus dipilih',
            'semester.exists' => 'Semester tidak valid',
        ];
    }

    public function mount($nim, $nama)
    {
        $this->nim = $nim;
        $this->nama = $nama;

        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();


        // Set the id_semester from the Mahasiswa object
        $this->id_semester = $mahasiswa?->mulai_semester;

        $semesters = Semester::where('id_semester', '>=', $mahasiswa?->mulai_semester)
            ->orderBy('id_semester', 'asc')
            ->get();

        $this->semesters = $semesters;

        $user = auth()->user();

        $staff = Staff::where('nip', $user->nim_nidn)->first();

        $this->staff = $staff;
    }


    public function save()
    {
        $validatedData = $this->validate();

        $mahasiswa = Mahasiswa::where('NIM', $this->nim)->first();
        $staff = $this->staff->id_staff;
        $semester = Semester::where('id_semester', $validatedData['semester'])->first();

        if (!$mahasiswa) {
            dd('Mahasiswa not found');
        }

        // Clean the 'total_tagihan' field (remove non-numeric characters)
        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

        // Renaming the 'jenis_tagihan' field
        if ($validatedData['jenis_tagihan'] != 'BPP') {
            $jenis_tagihan = $this->tagihan_lain;
        } else {
            $jenis_tagihan = $validatedData['jenis_tagihan'] . ' Semester ' . $semester->nama_semester;
        }

        // Check if a Tagihan already exists for the given NIM and semester
        $existingTagihan = Tagihan::where('NIM', $mahasiswa->NIM)
            ->where('jenis_tagihan', $jenis_tagihan)
            ->where('id_semester', $validatedData['semester'])
            ->first();

        if ($existingTagihan) {
            $this->addError('jenis_tagihan', 'Tagihan sudah ada untuk mahasiswa ini pada semester ini.');
        } else {
            // Create a new Tagihan if no existing one
            $tagihan = Tagihan::create([
                'NIM' => $mahasiswa->NIM,
                'total_tagihan' => $validatedData['total_tagihan'],
                'bisa_dicicil' => $this->cicil,
                'status_tagihan' => 'Menunggu Pembayaran',
                'jenis_tagihan' => $jenis_tagihan,
                'id_semester' => $validatedData['semester'],
                'id_staff' => $staff,
            ]);

            Mail::to($mahasiswa->email)->send(new TagihanMail($tagihan));

            $this->dispatch('TagihanCreated');
        }
        // Reset the form values
        $this->reset(['total_tagihan', 'semester', 'jenis_tagihan', 'cicil', 'tagihan_lain']);
        return $tagihan ?? null;
    }


    public function render()
    {

        $mahasiswas = Mahasiswa::with('prodi', 'semester')
            ->get();

        $s = $this->semesters;


        return view('livewire.staff.tagihan.create', [
            'mahasiswas' => $mahasiswas,
            // 'semesters' => Semester::orderBy('id_semester', 'desc')->get(),
            'semesters' => $s,
        ]);
    }
}
