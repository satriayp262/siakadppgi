<?php

namespace App\Livewire\Admin\PaketKrs;

use App\Models\Kelas;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\paketKRS;
use App\Models\Prodi;
use App\Models\Semester;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class Create extends Component
{
    public $semesters = [], $kode_prodi_list = [], $kelas = [], $matkul = [];
    public $selectedSemester, $selectedKodeProdi, $selectedKelas;
    public $paketKrsRecords = [];
    public $selectedKRS = [];
    public $tanggal_mulai, $tanggal_selesai;

    public function mount()
    {
        $this->semesters =
            Semester::orderBy('nama_semester', 'desc')->latest()
                ->take(10)->get();
        $this->kode_prodi_list = Prodi::all();
    }

    public function updatedSelectedKodeProdi()
    {
        // Update Kelas options based on selected kode_prodi
        $this->kelas = Kelas::where('kode_prodi', $this->selectedKodeProdi)->latest()->get();

        // Update Matakuliah options based on selected kode_prodi
        $this->matkul = Matakuliah::where('kode_prodi', $this->selectedKodeProdi)
            ->with('dosen')
            ->get()
            ->groupBy('nama_mata_kuliah')
            ->map(fn($items) => $items->toArray())
            ->toArray();
        // dd($this->matkul);
        $z = [];
        foreach ($this->matkul as $index => $x) {
            foreach ($x as $index2 => $y) {
                $z[$index][$index2] = $y;
            }
        }
        // dd($z);
        $this->selectedKelas = null;
        $this->paketKrsRecords = [];
    }

    public function handleMatkulChange()
    {
        foreach ($this->paketKrsRecords as $index => $x) {
            $matkul = Matakuliah::where('id_mata_kuliah', $x['id_mata_kuliah'])->first();
            $this->selectedKRS[$index] = $matkul->nama_mata_kuliah ?? null;
        }

    }

    public function addRow()
    {
        $this->paketKrsRecords[] = ['id_mata_kuliah' => null];
    }

    public function removeRow($index)
    {
        unset($this->paketKrsRecords[$index]);
        unset($this->selectedKRS[$index]);
        $this->paketKrsRecords = array_values($this->paketKrsRecords);
    }

    public function save()
    {
        $customMessages = [
            'selectedKodeProdi.required' => 'Kode Prodi wajib dipilih.',
            'selectedKodeProdi.exists' => 'Kode Prodi yang dipilih tidak valid.',
            'selectedSemester.required' => 'Semester wajib dipilih.',
            'selectedSemester.exists' => 'Semester yang dipilih tidak valid.',
            'selectedKelas.required' => 'Kelas wajib dipilih.',
            'selectedKelas.exists' => 'Kelas yang dipilih tidak valid.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'tanggal_mulai.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal selesai.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date' => 'Tanggal selesai harus berupa format tanggal yang valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'paketKrsRecords.required' => 'Paket KRS wajib dipilih.',
            'paketKrsRecords.array' => 'Paket KRS harus berupa array.',
            'paketKrsRecords.min' => 'Setidaknya satu paket KRS harus dipilih.',
            'paketKrsRecords.*.id_mata_kuliah.required' => 'Mata Kuliah Tidak boleh kosong',
            'paketKrsRecords.*.id_mata_kuliah.exists' => 'Mata kuliah yang dipilih tidak valid.',
        ];
    
        // Validate the inputs with custom messages
        $validatedData = $this->validate([
            'selectedKodeProdi' => 'required|exists:prodi,kode_prodi',
            'selectedSemester' => 'required|exists:semester,id_semester',
            'selectedKelas' => 'required|exists:kelas,id_kelas',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_selesai',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'paketKrsRecords' => 'required|array|min:1',
            'paketKrsRecords.*.id_mata_kuliah' => 'required|exists:matkul,id_mata_kuliah', 
        ], $customMessages);
        $id_prodi = prodi::where('kode_prodi', $this->selectedKodeProdi)->first()->id_prodi;
        if (paketKRS::where('id_semester', $this->selectedSemester)->where('id_prodi', $id_prodi)->where('id_kelas', $this->selectedKelas)->exists()) {
            $this->dispatch('warningPaketKRS', 'Paket KRS untuk kelas ini sudah ada');
        } else {
            foreach ($this->paketKrsRecords as $record) {
                PaketKRS::create([
                    'id_semester' => $this->selectedSemester,
                    'id_prodi' => $id_prodi,
                    'id_mata_kuliah' => $record['id_mata_kuliah'],
                    'id_kelas' => $this->selectedKelas,
                    'tanggal_mulai' => $this->tanggal_mulai,
                    'tanggal_selesai' => $this->tanggal_selesai,
                ]);
            }
            $this->alert();
        }
    }

    public function alert()
    {
        $this->dispatch('updatedPaketKRS', ['Paket KRS Berhasil Dibuat']);

    }

    public function render()
    {
        return view('livewire.admin.paket-krs.create');
    }
}
