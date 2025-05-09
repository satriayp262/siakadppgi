<?php

namespace App\Livewire\Table;

use App\Models\Pertanyaan;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class PertanyaanTable extends PowerGridComponent
{
    public string $tableName = 'pertanyaan-table-adupmv-table';
    public string $primaryKey = 'id_pertanyaan';
    public string $sortField = 'id_pertanyaan';

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

    public function datasource(): Builder
    {
        return Pertanyaan::query();
    }
    public function header(): array
    {
        $this->checkboxAttribute = 'id_pertanyaan';

        return [
            Button::add('bulk-delete')
                ->slot('Hapus data terpilih')
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


    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_pertanyaan')
            ->add('nama_pertanyaan');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id_pertanyaan')->index(),

            Column::make('Nama pertanyaan', 'nama_pertanyaan')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.pertanyaan.action', ['row' => $row]);
    }

    public function filters(): array
    {
        return [
        ];
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
