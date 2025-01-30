<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Token;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class AbsensiByToken extends Component
{
    use WithPagination;

    public $search = '';
    public $id_kelas, $CheckDosen = false;
    public $id_mata_kuliah;
    public $kelas;
    public $matkul;

    #[On('tokenCreated')]
    public function handletokenCreated($token)
    {
        $this->dispatch('created', params: ['message' => 'Token created Successfully']);

        // session()->flash('message', 'Token berhasil dibuat!');
        // session()->flash('message_type', 'success');
    }

    public function mount($id_kelas, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->id_mata_kuliah = $id_mata_kuliah;

        // $this->CheckDosen = (Auth()->user()->nim_nidn == Matakuliah::where('id_mata_kuliah', Kelas::where('id_kelas', $this->id_kelas)->first()->id_mata_kuliah)->first()->nidn);

        // Ambil detail kelas
        $this->kelas = Kelas::with('matkul')->findOrFail($id_kelas);

        // Ambil data mata kuliah berdasarkan ID
        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);
    }

    public function render()
    {
        $tokens = Token::query()
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->whereHas('matkul', function ($query) {
                $query->where('nidn', Auth()->user()->nim_nidn) // Filter berdasarkan NIDN
                    ->where(function ($query) {
                        $query->where('nama_mata_kuliah', 'like', '%' . $this->search . '%') // Filter nama_mata_kuliah
                            ->orWhere('id_mata_kuliah', 'like', '%' . $this->search . '%'); // Filter id_mata_kuliah
                    });
            })
            ->where(function ($query) {
                $query->orWhere('valid_until', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dosen.presensi.absensi-by-token', [
            'kelas' => $this->kelas,
            'matkul' => $this->matkul,
            'tokens' => $tokens,
        ]);
    }
}
