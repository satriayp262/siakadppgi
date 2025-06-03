<?php

namespace App\Livewire\table;

use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class RuanganTable extends PowerGridComponent
{
    public ?string $primaryKeyAlias = 'id_ruangan';
    public string $primaryKey = 'ruangan.id_ruangan';
    public string $sortField = 'ruangan.id_ruangan';
    public string $tableName = 'ruangan-gsy2i9-table';


    public function header(): array
    {
        $this->checkboxAttribute = 'id_ruangan';
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
        return Ruangan::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('kode_ruangan')
            ->add('nama_ruangan')
            ->add('kapasitas');
    }

    public function columns(): array
    {
        return [
            Column::make('Kode Ruangan', 'kode_ruangan')
                ->sortable()
                ->searchable(),

            Column::make('Nama Ruangan', 'nama_ruangan')
                ->sortable()
                ->searchable(),

            Column::make('Kapasitas', 'kapasitas')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.ruangan.action', ['row' => $row]);
    }
}
