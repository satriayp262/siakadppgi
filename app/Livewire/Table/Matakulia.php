<?php

namespace App\Livewire\Table;

use App\Models\Dosen;
use App\Models\matakuliah;
use App\Models\Prodi;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class Matakulia extends PowerGridComponent
{
        public ?string $primaryKeyAlias = 'id_mata_kuliah';
    public string $primaryKey = 'matkul.id_mata_kuliah';
    public string $sortField = 'matkul.id_mata_kuliah';
    public string $tableName = 'matkul-gsy2i9-table';


    public function header(): array
    {
        $this->checkboxAttribute = 'id_mata_kuliah';
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
        return matakuliah::query();
    }

    public function relationSearch(): array
    {
        return [
            'prodi' => [
                'nama_prodi',
                'kode_prodi',
            ],
            'dosen' => [
                'nidn',
                'nama_dosen',
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('kode_mata_kuliah')
            ->add('nama_mata_kuliah')
            ->add('dosen.nama_dosen')
            ->add('prodi.nama_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('Kode mata kuliah', 'kode_mata_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Nama mata kuliah', 'nama_mata_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Dosen', 'dosen.nama_dosen')
                ->sortable()
                ->searchable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('prodi.nama_prodi', 'kode_prodi')
            ->dataSource(Prodi::all()->map(fn($prodi) => [
                'value' => $prodi->kode_prodi,
                'label' => $prodi->nama_prodi,
            ]))
            ->optionLabel('label')
            ->optionValue('value'),
            Filter::select('dosen.nama_dosen', 'nidn')
            ->dataSource(Dosen::all()->map(fn($dosen) => [
                'value' => $dosen->nidn,
                'label' => $dosen->nama_dosen,
            ]))
            ->optionLabel('label')
            ->optionValue('value'),
            
        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.matkul.action', ['row' => $row]);
    }
}
