<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $id_berita_acara, $tanggal, $nidn = '', $nama_dosen = '', $materi, $id_kelas, $id_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $nama_kelas, $nama_mata_kuliah;

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'id_mata_kuliah' => 'required|integer|max:255',
            'jumlah_mahasiswa' => 'required|integer',
            'id_kelas' => 'required|integer',
        ];
    }

    public function mount()
    {
        // Fetch Matakuliah using the logged-in user's NIDN
        $matkul = Matakuliah::where('nidn', '=', Auth::user()->nim_nidn)->first();
        $this->matkul = $matkul;

        // Assign the mata kuliah name to the component property
        if ($matkul) {
            $this->id_mata_kuliah = $matkul->id_mata_kuliah;
            $this->nama_mata_kuliah = $matkul->nama_mata_kuliah; // Assign the value here
        }

        // Fetch Kelas based on the mata kuliah
        $kelas = Kelas::where('id_mata_kuliah', '=', $matkul->id_mata_kuliah)->first();
        if ($kelas) {
            $this->id_kelas = $kelas->id_kelas;
            $this->nama_kelas = $kelas->nama_kelas;
        }

        // Fetch Dosen data based on the logged-in user
        $user = Auth::user();
        $dosen = Dosen::where('nidn', $user->nim_nidn)->first();

        if ($dosen) {
            $this->nidn = $dosen->nidn;
            $this->nama_dosen = $dosen->nama_dosen;
        }
    }


    public function save()
    {
        $validatedData = $this->validate();

        BeritaAcara::create([
            'tanggal' => $validatedData['tanggal'],
            'nidn' => $validatedData['nidn'],
            'id_mata_kuliah' => $validatedData['id_mata_kuliah'],
            'materi' => $validatedData['materi'],
            'jumlah_mahasiswa' => $validatedData['jumlah_mahasiswa'],
            'id_kelas' => $validatedData['id_kelas'],
        ]);

        $this->resetExcept('nidn','id_mata_kuliah','id_kelas');
        $this->dispatch('acaraCreated');
    }


    public function messages()
    {
        return [
            'nidn.required' => 'Nama dosen tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'materi.required' => 'Materi tidak boleh kosong',
            'id_mata_kuliah.required' => 'Mata kuliah tidak boleh kosong',
            'jumlah_mahasiswa.required' => 'Jumlah mahasiswa tidak boleh kosong',
            'id_kelas.required' => 'Kelas tidak boleh kosong',
        ];
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.create',);
    }
}
