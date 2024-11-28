<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Tagihan;

class GroupCreate extends Component
{
    public $total_tagihan;
    public $id_semester = '';
    public $status_tagihan = '';
    public $Bulan = '';
    public $kode_prodi = '';


    public function rules()
    {
        return [
            'total_tagihan' => 'required',
            'Bulan' => 'required',
            'id_semester' => 'required',
            'kode_prodi' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong',
            'total_tagihan.numeric' => 'Total tagihan harus berupa angka',
            'Bulan.required' => 'Bulan harus dipilih',
            'semester.required' => 'Semester harus dipilih',
            'kode_prodi.required' => 'Prodi harus dipilih',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['total_tagihan'] = preg_replace('/\D/', '', $validatedData['total_tagihan']);

        $mahasiswa = Mahasiswa::where('kode_prodi', $validatedData['kode_prodi'])
            ->where('mulai_semester', $validatedData['id_semester'])
            ->get();

        foreach ($mahasiswa as $mhs) {
            $existingTagihan = Tagihan::where('NIM', $mhs->NIM)
                ->where('Bulan', $validatedData['Bulan'])
                ->where('id_semester', $validatedData['id_semester'])
                ->first();

            if ($existingTagihan) {
                $this->addError('Bulan', 'Tagihan untuk bulan ini sudah ada untuk mahasiswa dengan NIM ' . $mhs->NIM);
                continue;
            }

            $tagihan = Tagihan::create([
                'NIM' => $mhs->NIM,
                'total_tagihan' => $validatedData['total_tagihan'],
                'status_tagihan' => 'Belum Lunas',
                'Bulan' => $validatedData['Bulan'],
                'id_semester' => $validatedData['id_semester'],
            ]);
        }
        $this->reset();
        $this->dispatch('TagihanCreated');


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
