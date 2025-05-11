<?php

namespace App\Livewire\Table;

use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DaftarStafTable extends PowerGridComponent
{
    public string $primaryKey = 'id_staff';
    public string $sortField = 'id_staff';
    public string $tableName = 'daftar-staf-table-cmdve0-table';

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
        $this->checkboxAttribute = 'id_staff';
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
        return Staff::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_staff')
            ->add('nama_staff')
            ->add('nip')
            ->add('ttd', function ($images) {
                return '<img src="' . asset("storage/image/ttd/{$images->ttd}") . '" style="width: 100px; height: auto;">';
            })
            ->add('email');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id_staff')->index(),

            Column::make('Nama staff', 'nama_staff')
                ->sortable()
                ->searchable(),

            Column::make('Nip', 'nip')
                ->sortable()
                ->searchable(),

            Column::make('Ttd', 'ttd'),

            Column::make('Email', 'email')
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

        return view('livewire.admin.staff.action', ['row' => $row]);
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
