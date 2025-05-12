<?php

namespace App\Livewire\Table\Emonev;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use App\Models\Prodi;

final class BelumIsiEmonevTable extends PowerGridComponent
{
    public string $tableName = 'belum-isi-emonev-table-kyayuq-table';
    public $mahasiswabelum = [];

    use WithExport;

    public function datasource(): Collection
    {
        $query = collect($this->mahasiswabelum);
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
            PowerGrid::exportable(fileName: 'belum_isi_emonev-file')
                ->type(Exportable::TYPE_XLS),

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
            Column::make('ID', 'id')->index()->visibleInExport(false),

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
