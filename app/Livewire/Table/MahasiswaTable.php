<?php

namespace App\Livewire\Table;

use App\Models\Mahasiswa;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;
use App\Models\Prodi;

final class MahasiswaTable extends PowerGridComponent
{
    public ?string $primaryKeyAlias = 'id';
    public string $primaryKey = 'mahasiswa.id_mahasiswa';
    public string $sortField = 'mahasiswa.id_mahasiswa';
    public string $tableName = 'mahasiswa-table-s8eldb-table';

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

    public function filters(): array
    {
        return [
            Filter::select('kode_prodi', 'kode_prodi')
                ->dataSource(Prodi::select('kode_prodi')->get()->map(function ($item) {
                    return [
                        'value' => $item->kode_prodi,
                        'label' => $item->kode_prodi,
                    ];
                })->toArray())
                ->optionLabel('label')
                ->optionValue('value'),

                Filter::select('semester_difference', 'Semester Difference')
                ->dataSource(collect(range(1, 8))->map(fn($n) => [
                    'value' => $n,
                    'label' => 'Semester ' . $n,
                ])->toArray())
                ->optionLabel('label')
                ->optionValue('value')


        ];
    }

    public function datasource(): \Illuminate\Support\Collection
    {
        $mahasiswaQuery = Mahasiswa::with('semester');
    
        if ($this->filters['semester_difference'] ?? null) {
            $mahasiswaQuery = $mahasiswaQuery->where('semester_difference', $this->filters['semester_difference']);
        }
    
        if ($this->filters['kode_prodi'] ?? null) {
            $mahasiswaQuery = $mahasiswaQuery->where('kode_prodi', $this->filters['kode_prodi']);
        }
    
        return $mahasiswaQuery->get();
    }
    

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('NIM')
            ->add('nama')
            ->add('mulai_semester')
            ->add('kode_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('NIM', 'NIM')
                ->sortable()
                ->searchable(),

            Column::make('Nama', 'nama')
                ->sortable()
                ->searchable(),

            Column::make('Semester', 'semester_difference'),

            Column::make('Kode prodi', 'kode_prodi')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }
    public function addColumns(): array
    {
        return [
            'semester_difference' => fn(Mahasiswa $row) => $row->semester_difference,

        ];
    }
    public function actionsFromView($row)
    {

        return view('livewire.admin.mahasiswa.action', ['row' => $row]);
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
