<?php

namespace App\Livewire\Table;

use App\Models\Pengumuman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class PengumumanTable extends PowerGridComponent
{
    public string $primaryKey = 'id_pengumuman';
    public string $sortField = 'id_pengumuman';
    public string $tableName = 'pengumuman-table-evxe2o-table';


    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        $this->checkboxAttribute = 'id_pengumuman';

        return [
            Button::add('bulk-delete')
                ->slot('Hapus data terpilih (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('bg-red-600 text-semibold text-white px-3 py-1 rounded hover:bg-red-700')
                ->dispatch('bulkDelete.' . $this->tableName, []),
        ];

    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        //$this->js('alert(window.pgBulkActions.get(\'' . $this->tableName . '\'))');
        $this->dispatch('bulkDelete.alert.' . $this->tableName, [
            'ids' => $this->checkboxValues
        ]);
    }

    public function datasource(): Builder
    {
        $query = Pengumuman::query();
        return $query;

    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_pengumuman')
            ->add('title', function ($pengumuman) {
                return e(Str::words($pengumuman->title, 6));
            })
            ->add('desc', function ($pengumuman) {
                return e(Str::words($pengumuman->desc, 5));
            })
            ->add('image', function ($pengumuman) {
                return '<img src="' . asset("storage/image/pengumuman/{$pengumuman->image}") . '">';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Judul', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Desc', 'desc')
                ->sortable()
                ->searchable(),

            Column::make('Image', 'image'),


            Column::action('Aksi')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }
    public function actions(Pengumuman $row): array
    {
        return [

        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.admin.pengumuman.action', ['row' => $row]);
    }


    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
