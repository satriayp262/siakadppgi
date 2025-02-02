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
    public $Bulan = '';
    public $jenis_tagihan;
    public $id_semester;
    public $kode_prodi;

    public function rules()
    {
        return [
            'nim' => 'required',
            'total_tagihan' => 'required',
            'Bulan' => 'required|date_format:Y-m', // Validasi menggunakan format YYYY-MM
            'jenis_tagihan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nim.required' => 'nim tidak boleh kosong',
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'jenis_tagihan.required' => 'Jenis tagihan tidak boleh kosong',
            'Bulan.required' => 'Bulan harus dipilih',
            'Bulan.date_format' => 'Bulan harus berformat YYYY-MM',
        ];
    }

    public function mount($nim, $nama)
    {
        $this->nim = $nim;
        $this->nama = $nama;
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();

        // Set the id_semester from the Mahasiswa object
        $this->id_semester = $mahasiswa ? $mahasiswa->mulai_semester : null;
    }


    public function save()
    {
        $validatedData = $this->validate();

        $user = auth()->user();

        $staff = Staff::where('nip', $user->nim_nidn)->first();
        // Clean the 'total_tagihan' field (remove non-numeric characters)
        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

        // Assuming you want to create the Tagihan for the single Mahasiswa identified by $this->nim
        $mahasiswa = Mahasiswa::where('NIM', $this->nim)->first();

        $semester1 = substr($validatedData['Bulan'], 0, 4);

        if (in_array(substr($validatedData['Bulan'], 5, 2), [2, 3, 4, 5, 6, 7, 8])) {
            $semester = $semester1 . '2';
            $id = Semester::where('nama_semester', $semester)->value('id_semester');
        } elseif (in_array(substr($validatedData['Bulan'], 5, 2), [9, 10, 11, 12])) {
            $semester = (int) $semester1 + 1 . '1';
            $id = Semester::where('nama_semester', $semester)->value('id_semester');
        } elseif (substr($validatedData['Bulan'], 5, 2) == 1) {
            $semester = $semester1 . '1';
            $id = Semester::where('nama_semester', $semester)->value('id_semester');
        } else {
            $this->addError('Bulan', 'Bulan tidak valid');
        }

        // Check if the semester exists in the Semester table
        $semesterExists = Semester::where('nama_semester', $semester)->exists();

        if (!$semesterExists) {
            $this->addError('Bulan', 'Tahun ini belum terdaftar sebagai semester');
            return;
        }


        if (!$mahasiswa) {
            $this->addError('NIM', 'Mahasiswa dengan NIM ' . $this->nim . ' tidak ditemukan.');
            return;
        }

        // Check if a Tagihan already exists for the current Mahasiswa
        $existingTagihan = Tagihan::where('NIM', $mahasiswa->NIM)
            ->where('Bulan', $validatedData['Bulan'])
            ->where('id_semester', $this->id_semester)
            ->first();

        // If Tagihan exists, add an error
        if ($existingTagihan) {
            $this->addError('Bulan', 'Tagihan untuk bulan ini sudah ada untuk mahasiswa ' . $mahasiswa->nama . ' pada semester ' . $mahasiswa->semester->nama_semester);
            return;
        } else {
            // Create a new Tagihan if no existing one
            $tagihan = Tagihan::create([
                'NIM' => $mahasiswa->NIM,
                'total_tagihan' => $validatedData['total_tagihan'],
                'status_tagihan' => 'Belum Bayar',
                'Bulan' => $validatedData['Bulan'],
                'jenis_tagihan' => $validatedData['jenis_tagihan'],
                'id_semester' => $id,
                'id_staff' => $staff->id_staff,
            ]);

            Mail::to($mahasiswa->email)->send(new TagihanMail($tagihan));
            $this->dispatch('TagihanCreated');
        }

        // Reset the form values
        $this->reset(['total_tagihan', 'Bulan', 'jenis_tagihan']);
        return $tagihan ?? null;
    }


    public function render()
    {
        $mahasiswas = Mahasiswa::all();
        return view('livewire.staff.tagihan.create', [
            'mahasiswas' => $mahasiswas
        ]);
    }
}
