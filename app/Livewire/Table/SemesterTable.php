<?php

namespace App\Livewire\Table;

use App\Models\Semester;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class SemesterTable extends PowerGridComponent
{
    public string $tableName = 'semester-table-4jkmt3-table';
    public string $primaryKey = 'id_semester';
    public string $sortField = 'id_semester';

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
        $this->checkboxAttribute = 'id_semester';
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
        return Semester::query()->orderByDesc('id_semester');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama_semester')
            ->add('status', function ($dish) {
                $status = $dish->is_active;
                $badgeClass = match ($status) {
                    1 => 'bg-green-100 text-green-800',
                    0 => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                };
                $status_name = match ($status) {
                    1 => 'Aktif',
                    0 => 'Tidak aktif',
                    default => 'Unknown',
                };

                return "<span class='px-2 py-1 text-xs font-semibold rounded $badgeClass'>$status_name</span>";
            })
            ->add('bulan_mulai')
            ->add('bulan_selesai');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')->index(),

            Column::make('Nama semester', 'nama_semester')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status'),

            Column::make('Bulan mulai', 'bulan_mulai')
                ->sortable()
                ->searchable(),

            Column::make('Bulan selesai', 'bulan_selesai')
                ->sortable()
                ->searchable(),

            Column::action('Aksi')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.admin.semester.action', ['row' => $row]);
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
