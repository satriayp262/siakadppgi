<?php

namespace App\Livewire\Admin\Krs\Mahasiswa;

use Livewire\Component;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KRSExport;
use App\Models\Semester;


class Edit extends Component
{
    public $semester, $mahasiswa;
    public $krsRecords = [];
    public $NIM;
    public $kode_prodi;
    public $kelas = []; 
    public $selectedKelas = []; 


    public function mount($semester, $NIM)
    {
        $this->semester = $semester;
        $this->NIM = $NIM;
        $this->mahasiswa = Mahasiswa::where('NIM', $NIM)->first();
        $this->kode_prodi = $this->mahasiswa->prodi->kode_prodi;
        $this->loadKRSRecords();
    }

    public function loadKRSRecords()
    {
        $this->krsRecords = KRS::where('id_semester', $this->semester)
            ->where('NIM', $this->NIM)
            ->with(['matkul', 'matkul.dosen', 'kelas'])
            ->get()
            ->toArray();

        $this->kelas = Kelas::where('kode_prodi', $this->kode_prodi)->with('matkul.dosen')->get()->toArray();

        foreach ($this->krsRecords as $index => $record) {
            $this->selectedKelas[$index] = $record['id_kelas'];
        }
    }
    public function updatedSelectedKelas($value, $index)
    {
        $kelas = Kelas::with('matkul.dosen')->find($value);

        if ($kelas) {
            $this->krsRecords[$index]['id_mata_kuliah'] = $kelas['id_mata_kuliah'];
            $this->krsRecords[$index]['matkul'] = $kelas['matkul'];
            $this->krsRecords[$index]['matkul']['dosen']['nama_dosen'] = $kelas['matkul']['dosen']['nama_dosen'];
        }
    }


    public function save()
    {
        foreach ($this->krsRecords as $index => $record) {
            KRS::where('id_krs', $record['id_krs'])->update([
                'id_kelas' => $this->selectedKelas[$index],
                'id_mata_kuliah' => $record['id_mata_kuliah'], 
                'nilai_huruf' => $record['nilai_huruf'],
                'nilai_index' => $record['nilai_index'],
                'nilai_angka' => $record['nilai_angka'],
            ]);
        }

        $this->alert();        
    }
    #[On('KRSUpdated')] 
    public function alert(){
        $this->dispatch('updatedKRS', ['Update KRS Berhasil']);
        $this->loadKRSRecords();
    }
    public function destroy($id_krs)
    {
        krs::find($id_krs)->delete();
        $this->dispatch('destroyedKRS', ['message' => 'KRS deleted Successfully']);
        $this->loadKRSRecords();
    }


    public function export()
    {
        $semester = semester::where('id_semester', $this->semester)->first()->nama_semester;
        $fileName = 'Data KRS '.' '.$this->mahasiswa->nama.' semester '.$semester .' '. now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new KRSExport($semester,$this->NIM,null), $fileName);
    }
    public function render()
    {
        return view('livewire.admin.krs.mahasiswa.edit');
    }
}
