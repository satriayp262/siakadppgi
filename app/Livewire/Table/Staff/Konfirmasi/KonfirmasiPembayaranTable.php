<?php

namespace App\Livewire\Table\Staff\Konfirmasi;

use Illuminate\Support\Carbon;
use App\Models\Konfirmasi_Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class KonfirmasiPembayaranTable extends PowerGridComponent
{
    public string $tableName = 'konfirmasi-pembayaran-table-chv3ux-table';

    public function datasource(): Collection
    {
        $query = Konfirmasi_Pembayaran::with('tagihan', 'mahasiswa')->get();
        return $query;
    }

    public function setUp(): array
    {
        //$this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('semester.nama_semester')
            ->add('mahasiswa.nama')
            ->add('mahasiswa.nim')
            ->add('tagihan.jenis_tagihan')
            ->add('status')
            ->add('bukti', function ($pengumuman) {
                return '<img src="' . asset("storage/image/bukti_pembayaran/{$pengumuman->image}") . '">';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')->index(),
            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->searchable(),

            Column::make('Nama', 'mahasiswa.nama')
                ->sortable()
                ->searchable(),

            Column::make('NIM', 'mahasiswa.nim')
                ->sortable()
                ->searchable(),

            Column::make('Pembayaran', 'tagihan.jenis_tagihan')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status'),
            Column::make('Bukti', 'bukti'),
            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.staff.konfirmasi.action', ['row' => $row]);
    }

    public function updateStatus($id, $status)
    {
        $konfirmasi = Konfirmasi_Pembayaran::find($id);
        $konfirmasi->status = $status;
        $konfirmasi->save();

        // Update status tagihan
        $tagihan = Tagihan::where('id_tagihan', $konfirmasi->id_tagihan)->first();
        if ($tagihan) {
            if ($status == 'Diterima') {
                $tagihan->status_tagihan = 'Lunas';
            } else {
                $tagihan->status_tagihan = 'Belum Lunas';
            }
            $tagihan->save();
        }

        $this->dispatch('updated', ['message' => 'Status Pembayaran Berhasil diubah']);
    }
}
