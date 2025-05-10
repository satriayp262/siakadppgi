<?php

namespace App\Livewire\table;

use App\Models\prodi;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class ProdiTable extends PowerGridComponent
{
    
    public ?string $primaryKeyAlias = 'id_prodi';
    public string $primaryKey = 'id_prodi';
    public string $sortField = 'id_prodi';
    public string $tableName = 'prodi-table-pzqflt-table';
    
    public function setUp(): array
    {
        $this->showCheckBox();
        $this->checkboxAttribute = 'id_prodi';

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
        return prodi::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('kode_prodi')
            ->add('nama_prodi')
            ->add('jenjang');
    }

    public function columns(): array
    {
        return [
            Column::make('Kode prodi', 'kode_prodi')
                ->sortable()
                ->searchable(),

            Column::make('Nama prodi', 'nama_prodi')
                ->sortable()
                ->searchable(),

            Column::make('Jenjang', 'jenjang')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('jenjang', 'jenjang')
                ->dataSource([
                    [
                        'value' => 'D3',
                        'label' => 'D3',
                    ],
                    [
                        'value' => 'D4',
                        'label' => 'D4',
                    ],
                    [
                        'value' => 'S1',
                        'label' => 'S1',
                    ],
        ])
                ->optionLabel('label')
                ->optionValue('value')
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.admin.prodi.action', ['row' => $row]);
    }

}
