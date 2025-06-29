<?php

namespace App\Livewire\table;

use App\Models\KonversiNilai;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class konversiTable extends PowerGridComponent
{
    public string $primaryKey = 'id_konversi_nilai';
    public string $sortField = 'id_konversi_nilai';
    public string $tableName = 'konversi-table-chavt8-table';

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
        $this->checkboxAttribute = 'id_konversi_nilai';
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
        return KonversiNilai::query();
    }

    public function relationSearch(): array
    {
        return [
            'krs' => ['id_krs'],
            'krs.matkul' => ['nama_mata_kuliah', 'kode_mata_kuliah'],
            'krs.mahasiswa' => ['nama', 'NIM'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_krs')
            ->add('NIM', fn($model) => $model->krs->mahasiswa->NIM ?? '-')
            ->add('nama', fn($model) => $model->krs->mahasiswa->nama ?? '-')
            ->add('matkul', fn($model) => $model->krs->matkul->nama_mata_kuliah ?? '-')
            ->add('keterangan')
            ->add('nilai')
            ->add('file', function ($model) {
                $url = route('konversi.download', ['id' => $model->id_konversi_nilai]);
                return '<a href="' . $url . '" class="text-blue-600 hover:underline">Download File</a>';
            });

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

            Column::make('Matakuliah', 'matkul'),

            Column::make('Keterangan', 'keterangan'),

            Column::make('Nilai', 'nilai'),

            Column::make('File', 'file'),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actionsFromView($row)
    {

        return view('livewire.admin.konversi.action', ['row' => $row]);
    }
}
