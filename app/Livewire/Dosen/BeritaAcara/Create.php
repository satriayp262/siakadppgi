<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $id_berita_acara, $tanggal, $nidn = '', $nama_dosen = '', $materi, $kode_mata_kuliah = '', $jumlah_mahasiswa, $matkul;

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'kode_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|integer',
        ];
    }

    public function mount()
    {
        $this->matkul = Matakuliah::all() ?? collect([]);

        // Ambil user yang sedang login
        $user = Auth::user();
        $dosen = Dosen::where('id', $user->id)->first();

        if ($dosen) {
            $this->nidn = $dosen->nidn;
            $this->nama_dosen = $dosen->nama_dosen; // Set nama dosen berdasarkan NIDN
        }
    }

    public function save()
{
    $validatedData = $this->validate();

    $acara = BeritaAcara::create([
        'tanggal' => $validatedData['tanggal'],
        'nidn' => $validatedData['nidn'],
        'materi' => $validatedData['materi'],
        'kode_mata_kuliah' => $validatedData['kode_mata_kuliah'],
        'jumlah_mahasiswa' => $validatedData['jumlah_mahasiswa'],
    ]);

    // Reset form kecuali 'nama_dosen'
    $this->reset(['tanggal', 'materi', 'jumlah_mahasiswa']);

    $this->dispatch('acaraCreated');

    return $acara;
}


    public function messages()
    {
        return [
            'nidn.required' => 'Nama dosen tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'materi.required' => 'Materi tidak boleh kosong',
            'kode_mata_kuliah.required' => 'Mata kuliah tidak boleh kosong',
            'jumlah_mahasiswa.required' => 'Jumlah mahasiswa tidak boleh kosong',
        ];
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.create');
    }
}
