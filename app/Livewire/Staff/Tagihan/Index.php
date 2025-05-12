<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Livewire\Attributes\On;



class Index extends Component
{
    public $ids = '';
    public $selectedMahasiswa = [];
    public $showUpdateButton = false;
    public $buttontransaksi = false;

    #[On('TagihanCreated')]
    public function handletagihanCreated()
    {
        $this->dispatch('pg:eventRefresh-buat-tagihan-table-njgizx-table');
        $this->dispatch('created', ['message' => 'Tagihan Berhasil Ditambahkan']);
    }

    #[On('TagihanAdded')]
    public function handletagihanAdded()
    {
        $this->dispatch('pg:eventRefresh-buat-tagihan-table-njgizx-table');
        $this->dispatch('created', ['message' => 'Tagihan Berhasil Ditambahkan']);
        return redirect()->route('staff.tagihan');
    }

    #[On('PembayaranCreated')]
    public function handlePembayaranCreated()
    {
        $this->dispatch('created', ['message' => 'Pembayaran Berhasil Ditambahkan']);
        return redirect()->route('staff.tagihan.detail', ['id_tagihan' => $this->id_tagihan]);
    }


    public function Tagihan($ids)
    {
        $mahasiswa = Mahasiswa::whereIn('id_mahasiswa', $ids)->get();

        session(['selectedMahasiswa' => $mahasiswa]);

        $this->buttontransaksi = true;

        return $mahasiswa;
    }


    public function render()
    {
        return view(
            'livewire.staff.tagihan.index'
        );
    }
}
