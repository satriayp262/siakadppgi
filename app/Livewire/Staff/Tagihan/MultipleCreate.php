<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use App\Models\Prodi;
use App\Models\Staff;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Mail;
use App\Mail\TagihanMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MultipleCreate extends Component
{
    public $selectedMahasiswa;
    public $mahasiswas;
    public $total_tagihan;
    public $semester = '';
    public $cicil = false;
    public $staff;
    public $tagihan_lain;
    public $jenis_tagihan = '';



    public function mount()
    {
        // Ambil data mahasiswa dari session
        $this->mahasiswas = session('selectedMahasiswa', []);
        $user = auth()->user();
        $staff = Staff::where('nip', $user->nim_nidn)->first();

        $this->staff = $staff;
    }

    public function rules()
    {
        return [
            'semester' => 'required|exists:semester,id_semester',
            'jenis_tagihan' => 'required|string',
            'total_tagihan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'semester.required' => 'Semester Wajib dipilih.',
            'semester.exists' => 'Semester harus dari semester yang valid.',
            'jenis_tagihan.required' => 'Jenis Tagihan Wajib dipilih.',
            'total_tagihan.required' => 'Total Tagihan Wajib diisi.',
            'total_tagihan.numeric' => 'Total Tagihan harus berupa angka.',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();
        $staff = $this->staff;
        $semester = Semester::where('id_semester', $validatedData['semester'])->first();

        // Remove non-digit characters from total_tagihan
        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

        $mahasiswa = Mahasiswa::whereIn('id_mahasiswa', $this->selectedMahasiswa)->get();

        // Renaming the 'jenis_tagihan' field
        if ($validatedData['jenis_tagihan'] != 'BPP') {
            $jenis_tagihan = $this->tagihan_lain;
        } else {
            $jenis_tagihan = $validatedData['jenis_tagihan'] . ' Semester ' . $semester->nama_semester;
        }

        $cicil = $this->cicil;

        foreach ($mahasiswa as $mhs) {
            $existingTagihan = Tagihan::where('NIM', $mhs->NIM)
                ->where('jenis_tagihan', $jenis_tagihan)
                ->where('id_semester', $validatedData['semester'])
                ->first();

            // Check if there is already a Tagihan for the Mahasiswa
            if ($existingTagihan) {
                $this->addError('jenis_tagihan', 'Tagihan untuk bulan ini sudah ada untuk mahasiswa dengan prodi ' . $mhs->prodi->nama_prodi . ' semester ' . $mhs->semester->nama_semester);
                return;
            } else {
                // Create a new Tagihan for the Mahasiswa
                $tagihan = Tagihan::create([
                    'NIM' => $mhs->NIM,
                    'total_tagihan' => $validatedData['total_tagihan'],
                    'status_tagihan' => 'Belum Bayar',
                    'jenis_tagihan' => $jenis_tagihan,
                    'id_semester' => $validatedData['semester'],
                    'id_staff' => $staff->id_staff,
                    'bisa_cicil' => $cicil,
                ]);
                $this->dispatch('TagihanAdded');
                Mail::to($mhs->email)->send(new TagihanMail($tagihan));
                // Mail::to($mhs->email)->send(new TagihanMail($tagihan));
            }
        }
        $this->reset(['total_tagihan', 'semester', 'jenis_tagihan', 'cicil', 'tagihan_lain']);
        return $tagihan;
    }
    public function render()
    {
        $prodis = Prodi::all();
        $semesters = Semester::orderBy('id_semester', 'desc')->get();
        return view('livewire.staff.tagihan.multiple-create', [
            'mahasiswas' => $this->mahasiswas,
            'prodis' => $prodis,
            'semesters' => $semesters,
        ]);
    }
}
