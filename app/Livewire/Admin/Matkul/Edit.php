<?php

namespace App\Livewire\Admin\Matkul;

use App\Models\Matakuliah;
use Livewire\Component;

class Edit extends Component
{
    public $id_mata_kuliah;
    public $kode_mata_kuliah;
    public $nama_mata_kuliah;
    public $jenis_mata_kuliah;
    public $sks_tatap_muka;
    public $sks_praktek;
    public $sks_praktek_lapangan;
    public $sks_simulasi;
    public $metode_pembelajaran;
    public $tgl_mulai_efektif;
    public $tgl_akhir_efektif;


    public function rules()
    {
        return [
            'kode_mata_kuliah' => 'required|string',
            'nama_mata_kuliah' => 'required|string',
            'jenis_mata_kuliah' => 'required|string',
            'sks_tatap_muka' => 'required|integer',
            'sks_praktek' => 'required|integer',
            'sks_praktek_lapangan' => 'required|integer',
            'sks_simulasi' => 'required|integer',
            'metode_pembelajaran' => 'required|string',
            'tgl_mulai_efektif' => 'required|date',
            'tgl_akhir_efektif' => 'required|date',
        ];
    }

    public function clear($id_mata_kuliah)
    {
        $this->reset();
        $this->dispatch('refreshComponent');
        $matkul = Matakuliah::find($id_mata_kuliah);
        if ($matkul) {
            $this->id_mata_kuliah = $matkul->id_mata_kuliah;
            $this->kode_mata_kuliah = $matkul->kode_mata_kuliah;
            $this->nama_mata_kuliah = $matkul->nama_mata_kuliah;
            $this->jenis_mata_kuliah = $matkul->jenis_mata_kuliah;
            $this->sks_tatap_muka = $matkul->sks_tatap_muka;
            $this->sks_praktek = $matkul->sks_praktek;
            $this->sks_praktek_lapangan = $matkul->sks_praktek_lapangan;
            $this->sks_simulasi = $matkul->sks_simulasi;
            $this->metode_pembelajaran = $matkul->metode_pembelajaran;
            $this->tgl_mulai_efektif = $matkul->tgl_mulai_efektif;
            $this->tgl_akhir_efektif = $matkul->tgl_akhir_efektif;

        }

    }
    protected $listeners = ['refreshComponent' => '$refresh'];
    public function placeholder()
    {
        return <<<'BLADE'
        <div>
            <h5 class="card-title placeholder-glow">
                <span class="placeholder col-4"></span>
            </h5>
            <p class="card-text placeholder-glow">
                <span class="placeholder col-7"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-6"></span>
                <span class="placeholder col-8"></span>
            </p>
        </div>
        BLADE;
    }
    public function mount($id_mata_kuliah)
    {
        $matkul = Matakuliah::find($id_mata_kuliah);
        if ($matkul) {
            $this->id_mata_kuliah = $matkul->id_mata_kuliah;
            $this->kode_mata_kuliah = $matkul->kode_mata_kuliah;
            $this->nama_mata_kuliah = $matkul->nama_mata_kuliah;
            $this->jenis_mata_kuliah = $matkul->jenis_mata_kuliah;
            $this->sks_tatap_muka = $matkul->sks_tatap_muka;
            $this->sks_praktek = $matkul->sks_praktek;
            $this->sks_praktek_lapangan = $matkul->sks_praktek_lapangan;
            $this->sks_simulasi = $matkul->sks_simulasi;
            $this->metode_pembelajaran = $matkul->metode_pembelajaran;
            $this->tgl_mulai_efektif = $matkul->tgl_mulai_efektif;
            $this->tgl_akhir_efektif = $matkul->tgl_akhir_efektif;

        }
        return $matkul;
    }
    public function update()
    {

        $validatedData = $this->validate([
            'kode_mata_kuliah' => 'required|string',
            'nama_mata_kuliah' => 'required|string',
            'jenis_mata_kuliah' => 'required|string',
            'sks_tatap_muka' => 'required|integer',
            'sks_praktek' => 'required|integer',
            'sks_praktek_lapangan' => 'required|integer',
            'sks_simulasi' => 'required|integer',
            'metode_pembelajaran' => 'required|string',
            'tgl_mulai_efektif' => 'required|date',
            'tgl_akhir_efektif' => 'required|date',
        ]);

        $matkul = Matakuliah::find($this->id_mata_kuliah);
        // if ($matkul) {
        //     // Jika ada gambar baru yang diupload
        //     if ($this->picture) {
        //         // Hapus gambar lama jika ada
        //         if ($matkul->picture) {
        //             \Storage::disk('public')->delete($matkul->picture);
        //         }
        //         // Unggah gambar baru dan simpan path-nya
        //         $path = $this->picture->store('images/matkul', 'public');
        //         $matkul->picture = $path;
        //     }

            // Update data matkul lainnya
            $matkul->update([
            'kode_mata_kuliah' => $validatedData['kode_mata_kuliah'],
            'nama_mata_kuliah' => $validatedData['nama_mata_kuliah'],
            'jenis_mata_kuliah' => $validatedData['jenis_mata_kuliah'],
            'sks_tatap_muka' => $validatedData['sks_tatap_muka'],
            'sks_praktek' => $validatedData['sks_praktek'],
            'sks_praktek_lapangan' => $validatedData['sks_praktek_lapangan'],
            'sks_simulasi' => $validatedData['sks_simulasi'],
            'metode_pembelajaran' => $validatedData['metode_pembelajaran'],
            'tgl_mulai_efektif' => $validatedData['tgl_mulai_efektif'],
            'tgl_akhir_efektif' => $validatedData['tgl_akhir_efektif']
            ]);

        // Reset form dan dispatch event
        $this->reset();
        $this->dispatch('matkulUpdated');
        return $matkul;
    }
    public function render()
    {
        return view('livewire.admin.matkul.edit');
    }
}
