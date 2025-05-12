<?php

namespace App\Livewire\Table\Emonev;

use Illuminate\Support\Carbon;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Facades\Filter;


final class SudahIsiEmonevTable extends PowerGridComponent
{
    public string $tableName = 'sudah-isi-emonev-table-mmk450-table';
    public $mahasiswasudah = [];

    public function datasource(): Collection
    {
        $query = collect($this->mahasiswasudah);

        return $query;
    }

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
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
            ->add('NIM')
            ->add('semester.nama_semester')
            ->add('prodi.nama_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->index(),

            Column::make('Nama', 'nama')
                ->searchable()
                ->sortable(),

            Column::make('NIM', 'NIM')
                ->sortable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->searchable()
                ->sortable(),

            Column::make('Angkatan', 'semester.nama_semester')
                ->searchable()
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [

            Filter::select('prodi.nama_prodi', 'kode_prodi')
                ->dataSource(Prodi::all()->map(fn($prodi) => [
                    'value' => $prodi->kode_prodi,
                    'label' => $prodi->nama_prodi,
                ]))
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }
}
