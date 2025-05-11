<?php

namespace App\Livewire\Table;

use App\Models\PeriodeEMonev;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class PeriodeTable extends PowerGridComponent
{

    public string $tableName = 'periode-table-hwo90b-table';
    public string $primaryKey = 'id_periode';
    public string $sortField = 'id_periode';

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
        $this->checkboxAttribute = 'id_periode';
        return [
            Button::add('bulk-delete')
                ->slot('Hapus data terpilih (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700')
                ->dispatch('bulkDelete.' . $this->tableName, [
                    // 'ids' => $this->checkboxValues
                ]),
        ];
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        $this->checkboxAttribute = 'id_periode';
        $this->dispatch('bulkDelete.alert.' . $this->tableName, [
            'ids' => $this->checkboxValues
        ]);
        $this->checkboxValues = [];
    }

    public function datasource(): Builder
    {
        return PeriodeEMonev::query()->with('semester');
    }

    public function relationSearch(): array
    {
        return [
            'semester' => [
                'nama_semester',
                'id_semester',
            ],
        ];
    }


    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('semester.nama_semester')
            ->add('nama_periode')
            ->add('tanggal_mulai_formatted', fn(PeriodeEMonev $model) => Carbon::parse($model->tanggal_mulai)->format('d/m/Y'))
            ->add('tanggal_selesai_formatted', fn(PeriodeEMonev $model) => Carbon::parse($model->tanggal_selesai)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('No.', 'id')->index(),

            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->searchable(),

            Column::make('Nama periode', 'nama_periode')
                ->sortable()
                ->searchable(),

            Column::make('Tanggal mulai', 'tanggal_mulai_formatted', 'tanggal_mulai')
                ->sortable(),

            Column::make('Tanggal selesai', 'tanggal_selesai_formatted', 'tanggal_selesai')
                ->sortable(),

            Column::action('Action')
        ];
    }


    public function actionsFromView($row)
    {
        return view('livewire.admin.periode.action', ['row' => $row]);
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
