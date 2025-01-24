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
    public $id_semester;
    public $kode_prodi;

    public function rules()
    {
        return [
            'nim' => 'required',
            'total_tagihan' => 'required',
            'Bulan' => 'required|date_format:Y-m', // Validasi menggunakan format YYYY-MM
        ];
    }

    public function messages()
    {
        return [
            'nim.required' => 'nim tidak boleh kosong',
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
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
                'status_tagihan' => 'Belum Lunas',
                'Bulan' => $validatedData['Bulan'],
                'id_semester' => $this->id_semester,
                'id_staff' => $staff->id_staff,
            ]);

            Mail::to($mahasiswa->email)->send(new TagihanMail($tagihan));
            $this->dispatch('TagihanCreated');
        }

        // Reset the form values
        $this->reset(['total_tagihan', 'status_tagihan', 'Bulan', 'id_semester', 'kode_prodi']);
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
