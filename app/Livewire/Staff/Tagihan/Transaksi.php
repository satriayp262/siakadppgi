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

class Transaksi extends Component
{

    public $selectedMahasiswa;
    public $mahasiswas;
    public $total_tagihan;
    public $jenis_tagihan;
    public $Bulan;


    public function mount()
    {
        // Ambil data mahasiswa dari session
        $this->mahasiswas = session('selectedMahasiswa', []);
    }

    public function rules()
    {
        return [

            'total_tagihan' => 'required',
            'Bulan' => 'required|date_format:Y-m', // Validasi menggunakan format YYYY-MM
            'jenis_tagihan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'jenis_tagihan.required' => 'Jenis tagihan tidak boleh kosong',
            'Bulan.required' => 'Bulan harus dipilih',
            'Bulan.date_format' => 'Bulan harus berformat YYYY-MM',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        $user = auth()->user();

        $staff = Staff::where('nip', $user->nim_nidn)->first();

        // Remove non-digit characters from total_tagihan
        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

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

        $mahasiswa = Mahasiswa::whereIn('id_mahasiswa', $this->selectedMahasiswa)->get();

        foreach ($mahasiswa as $mhs) {
            $existingTagihan = Tagihan::where('NIM', $mhs->NIM)
                ->where('jenis_tagihan', $validatedData['jenis_tagihan'])
                ->where('Bulan', $validatedData['Bulan'])
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
                    'jenis_tagihan' => $validatedData['jenis_tagihan'],
                    'Bulan' => $validatedData['Bulan'],
                    'id_semester' => $id,
                    'id_staff' => $staff->id_staff,
                ]);
                $this->dispatch('TagihanAdded');
                // Mail::to($mhs->email)->send(new TagihanMail($tagihan));
            }
        }
        $this->reset(['total_tagihan', 'jenis_tagihan', 'Bulan']);
        return $tagihan;
    }

    public function render()
    {
        $prodis = Prodi::all();

        $semesters = Semester::all();

        return view('livewire.staff.tagihan.transaksi', [
            'mahasiswas' => $this->mahasiswas,
            'prodis' => $prodis,
            'semesters' => $semesters,
        ]);
    }
}
