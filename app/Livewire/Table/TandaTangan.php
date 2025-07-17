<?php

namespace App\Livewire\table;

use App\Models\ttd;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class TandaTangan extends PowerGridComponent
{
    public string $primaryKey = 'id_ttd';
    public string $sortField = 'id_ttd';
    public string $tableName = 'ttd-table-rsed3p-table';

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
        $this->checkboxAttribute = 'id_ttd';
        return [
            Button::add('bulk-delete')
                ->slot('Hapus data terpilih (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700')
                ->dispatch('bulkDelete.' . $this->tableName, [
                ]),
        ];
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        // $this->js('alert(window.pgBulkActions.get(\'' . $this->tableName . '\'))');
        $this->dispatch('bulkDelete.alert.' . $this->tableName, [
            'ids' => $this->checkboxValues
        ]);
        $this->checkboxValues = [];
    }
    public function datasource(): Builder
    {
        return ttd::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nama')
            ->add('jabatan')
             ->add('ttd', function ($images) {
                return '<img src="' . asset("storage/{$images->ttd}") . '" style="width: 100px; height: auto;">';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Nama', 'nama')
                ->sortable()
                ->searchable(),

            Column::make('Jabatan', 'jabatan')
                ->sortable()
                ->searchable(),

            Column::make('TTD', 'ttd')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }
        public function actionsFromView($row)
    {

        return view('livewire.admin.ttd.action', ['row' => $row]);
    }

    
}
