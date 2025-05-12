<?php

namespace App\Livewire\Table\Staff\Dashboard;

use App\Models\PembayaranTunai;
use Illuminate\Support\Carbon;
use App\Models\Cicilan_BPP;
use App\Models\Konfirmasi_Pembayaran;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class HistoryTable extends PowerGridComponent
{
    public string $tableName = 'history-table-3c3mrw-table';
    public $dataPembayaran = [];

    public function datasource(): Collection
    {
        $dataPembayaran = $this->dataPembayaran;
        return $dataPembayaran;

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
            ->add('nama')
            ->add('tanggal', function ($dish) {
                return \Carbon\Carbon::parse($dish->tanggal)->format('d-m-Y');
            })
            ->add('jam')
            ->add('nominal', function ($dish) {
                return 'Rp. ' . number_format($dish->nominal, 2, ',', '.'); // IDR 170,90
            })
            ->add('metode')
            ->add('pembayaran');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')->index(),

            Column::make('Nama', 'nama')
                ->searchable()
                ->sortable(),

            Column::make('Guna Pembayaran', 'metode')
                ->searchable()
                ->sortable(),

            Column::make('Tanggal Transaksi', 'tanggal')
            ,

            Column::make('Jam Transaksi', 'jam')
            ,

            Column::make('Nominal', 'nominal')
                ->searchable()
                ->sortable(),

            Column::make('Metode Pembayaran', 'pembayaran')
                ->searchable()
                ->sortable(),
        ];
    }
}
