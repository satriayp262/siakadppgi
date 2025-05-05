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

final class PengumumanTable extends PowerGridComponent
{
    public string $tableName = 'pengumuman-table-evxe2o-table';
    public ?string $primaryKeyAlias = 'id';
    public string $primaryKey = 'pengumuman.id_pengumuman';
    public string $sortField = 'pengumuman.id_pengumuman';

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
        return Pengumuman::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            // ->add('id_pengumuman')
            // ->add('id_pengumuman')
            ->add('title', function ($pengumuman) {
                return e(Str::words($pengumuman->title, 6));
            })
            ->add('desc', function ($pengumuman) {
                return e(Str::words($pengumuman->desc, 5));
            })
            ->add('image', function ($pengumuman) {
                return '<img src="' . asset("storage/image/pengumuman/{$pengumuman->image}") . '">';
            })
            ->add('file');
        // ->add('created_at');
    }

    public function columns(): array
    {
        return [
            // Column::make('Id pengumuman', 'id_pengumuman')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Id pengumuman', 'id_pengumuman')
            //     ->sortable()
            //     ->searchable(),

            Column::make('No.', 'id')->index(),

            Column::make('Title', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Desc', 'desc')
                ->sortable()
                ->searchable(),

            Column::make('Image', 'image')
                ->sortable()
                ->searchable(),

            Column::make('File', 'file')
                ->sortable()
                ->searchable(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->sortable(),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Pengumuman $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: ' . $row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
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
