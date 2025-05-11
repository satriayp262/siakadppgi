<?php

namespace App\Livewire\Table\Staff\Tagihan;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Semester;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Button;

use PowerComponents\LivewirePowerGrid\Facades\Filter;


final class BuatTagihanTable extends PowerGridComponent
{
    public string $tableName = 'buat-tagihan-table-njgizx-table';

    public function datasource(): Collection
    {
        $query = Mahasiswa::with(['prodi', 'semester'])
            ->get();

        return $query;
    }

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
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

    public function header(): array
    {
        $this->checkboxAttribute = 'id_mahasiswa';
        return [
            Button::add('bulk-delete')
                ->slot('Tagihan terpilih (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700')
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
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama')
            ->add('NIM')
            ->add('prodi.nama_prodi')
            ->add('semester.nama_semester');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->index()
            ,

            Column::make('Nama Mahasiswa', 'nama')
                ->searchable()
                ->sortable(),

            Column::make('NIM', 'NIM')
                ->sortable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->sortable(),

            Column::make('Angkatan', 'semester.nama_semester')
                ->sortable(),


            Column::action('Aksi')
        ];
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

    public function filters(): array
    {
        return [
            Filter::select('prodi.nama_prodi', 'kode_prodi')
                ->dataSource(
                    Prodi::all()->map(fn($prodi) => [
                        'id' => $prodi->kode_prodi,
                        'name' => $prodi->nama_prodi,
                    ])
                )
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('semester.nama_semester', 'mulai_semester')
                ->dataSource(
                    Semester::all()->map(fn($semester) => [
                        'id' => $semester->id_semester,
                        'name' => $semester->nama_semester,
                    ])
                )
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.staff.tagihan.action', ['row' => $row]);
    }



}
