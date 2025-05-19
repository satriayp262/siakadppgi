<?php

namespace App\Livewire\Table;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class UserTable extends PowerGridComponent
{
    public string $tableName = 'user-table-igtxk9-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                // perPage: 5, perPageValues: [5, 10, 50, 100]
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
                    // 'ids' => $this->checkboxValues
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
        return User::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('name')
            ->add('email')
            ->add('nim_nidn')
            ->add('role', function ($dish) {
                $role = $dish->role;
                $badgeClass = match ($role) {
                    'admin' => 'bg-blue-100 text-blue-800',
                    'dosen' => 'bg-indigo-100 text-indigo-800',
                    'mahasiswa' => 'bg-pink-100 text-pink-800',
                    'staff' => 'bg-purple-100 text-purple-800',
                    default => 'bg-gray-100 text-gray-800',
                };
                return "<span class='px-2 py-1 text-xs font-semibold rounded $badgeClass'>$role</span>";
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Nim/Nidn', 'nim_nidn')
                ->sortable()
                ->searchable(),

            Column::make('Role', 'role')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('role', 'role')
                ->dataSource([
                    ['id' => 'Admin', 'name' => 'Admin'],
                    ['id' => 'Mahasiswa', 'name' => 'Mahasiswa'],
                    ['id' => 'Dosen', 'name' => 'Dosen'],
                    ['id' => 'Staff', 'name' => 'Staff'],
                ])
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }



    public function actionsFromView($row)
    {

        return view('livewire.admin.user.action', ['row' => $row]);
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
