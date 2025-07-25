<?php

namespace App\Livewire\Table;

use App\Models\Dosen;
use App\Models\Prodi;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;


final class DosenTable extends PowerGridComponent
{
    public string $primaryKey = 'id_dosen';
    public string $sortField = 'id_dosen';
    public string $tableName = 'dosen-table-lw2rml-table';
    public string $url = 'default';

    public function setUp(): array
    {
        if (!($this->url == 'bobot')) {
            $this->showCheckBox();
        }

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
        $this->checkboxAttribute = 'id_dosen';
        // dd($this);
        if (!($this->url == 'bobot')) {
            return [
                Button::add('bulk-delete')
                    ->slot('Hapus data terpilih (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                    ->class('bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700')
                    ->dispatch('bulkDelete.' . $this->tableName, [
                        // 'ids' => $this->checkboxValues
                    ]),
            ];
        }else{
            return [];
        }
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        // $this->js('alert(window.pgBulkActions.get(\'' . $this->tableName . '\'))');
        $this->dispatch('bulkDelete.alert.' . $this->tableName, [
            'ids' => $this->checkboxValues
        ]);
    }

    public function datasource(): Builder
    {
        return Dosen::query()->with('prodi');
    }

    public function relationSearch(): array
    {
        return [
            'prodi' => [
                'nama_prodi',
                'kode_prodi',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nama_dosen')
            ->add('nidn')
            // ->add('jenis_kelamin')
            ->add('jabatan_fungsional')
            ->add('kepangkatan')
            ->add('prodi.nama_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('Nama', 'nama_dosen')
                ->sortable()
                ->searchable(),

            Column::make('Nidn', 'nidn')
                ->sortable()
                ->searchable(),

            Column::make('Jabatan', 'jabatan_fungsional')
                ->sortable()
                ->searchable(),

            Column::make('Kepangkatan', 'kepangkatan')
                ->sortable()
                ->searchable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('prodi.nama_prodi', 'dosen.kode_prodi')
                ->dataSource(
                    Prodi::all()->map(fn($prodi) => [
                        'id' => $prodi->kode_prodi,
                        'name' => $prodi->nama_prodi,
                    ])
                )
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('jabatan_fungsional', 'jabatan_fungsional')
                ->dataSource(
                    Dosen::query()
                        ->select('jabatan_fungsional')
                        ->distinct()
                        ->whereNotNull('jabatan_fungsional')
                        ->get()
                        ->map(fn($item) => [
                            'id' => $item->jabatan_fungsional,
                            'name' => $item->jabatan_fungsional,
                        ])
                )
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }


    public function actionsFromView($row)
    {
        if ($this->url == 'bobot') {
            return view('livewire.admin.bobot.action', ['row' => $row]);
        } else {
            return view('livewire.admin.dosen.action', ['row' => $row]);
        }
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
