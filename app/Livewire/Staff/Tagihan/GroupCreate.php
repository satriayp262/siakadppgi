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
    public $id_semester = '';
    public $status_tagihan = '';
    public $Bulan;
    public $jenis_tagihan;
    public $kode_prodi = '';

    public $selectedMahasiswa = [];

    public function rules()
    {
        return [
            'total_tagihan' => 'required',
            'Bulan' => 'required|date_format:Y-m', // Validasi menggunakan format YYYY-MM
            'jenis_tagihan' => 'required',
            'id_semester' => 'required',
            'kode_prodi' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'Bulan.required' => 'Bulan harus diisi',
            'Bulan.date_format' => 'Bulan harus berformat YYYY-MM',
            'jenis_tagihan.required' => 'Jenis tagihan harus diisi',
            'semester.required' => 'Semester harus dipilih',
            'kode_prodi.required' => 'Prodi harus dipilih',
        ];
    }


    public function save()
    {
        $validatedData = $this->validate();

        $user = auth()->user();

        $staff = Staff::where('nip', $user->nim_nidn)->first();

        // Remove non-digit characters from total_tagihan
        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

        // Retrieve Mahasiswa matching the criteria
        if ($validatedData['kode_prodi'] == 'all' && $validatedData['id_semester'] == 'all') {
            $mahasiswa = Mahasiswa::whereNotNull('kode_prodi')
                ->whereNotNull('mulai_semester')
                ->get();
        } elseif ($validatedData['kode_prodi'] == 'all') {
            $mahasiswa = Mahasiswa::whereNotNull('kode_prodi')
                ->where('mulai_semester', $validatedData['id_semester'])
                ->get();
        } elseif ($validatedData['id_semester'] == 'all') {
            $mahasiswa = Mahasiswa::where('kode_prodi', $validatedData['kode_prodi'])
                ->whereNotNull('mulai_semester')
                ->get();
        } else {
            $mahasiswa = Mahasiswa::where('kode_prodi', $validatedData['kode_prodi'])
                ->where('mulai_semester', $validatedData['id_semester'])
                ->get();
        }

        // Check if there are any Mahasiswa matching the criteria
        if ($mahasiswa->isEmpty()) {
            $this->addError('id_semester', 'Tidak ada mahasiswa aktif yang terdaftar pada semester ini.');
            return;
        }

        // Check if there are any Mahasiswa matching the criteria
        if ($mahasiswa->isEmpty()) {
            $this->addError('kode_prodi', 'Tidak ada mahasiswa aktif yang terdaftar pada prodi ini.');
            return;
        }

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

        // Check if there are any Mahasiswa matching the criteria
        foreach ($mahasiswa as $mhs) {
            $existingTagihan = Tagihan::where('NIM', $mhs->NIM)
                ->where('jenis_tagihan', $validatedData['jenis_tagihan'])
                ->where('Bulan', $validatedData['Bulan'])
                ->first();

            // Check if there is already a Tagihan for the Mahasiswa
            if ($existingTagihan) {
                $this->addError('jenis_tagihan', 'Tagihan' . $mhs->tagihan->jenis_tagihan . 'untuk bulan ini sudah ada untuk mahasiswa dengan prodi ' . $mhs->prodi->nama_prodi . ' semester ' . $mhs->semester->nama_semester);
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
        $semesters = Semester::all();
        $prodis = Prodi::all();
        $mahasiswas = Mahasiswa::all();
        return view('livewire.staff.tagihan.group-create', [
            'semesters' => $semesters,
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas
        ]);
    }
}
