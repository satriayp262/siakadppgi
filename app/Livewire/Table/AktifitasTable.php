<?php

namespace App\Livewire\table;

use App\Models\aktifitas;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class AktifitasTable extends PowerGridComponent
{
    public string $tableName = 'aktifitas-table-fonjfc-table';
    public ?string $primaryKeyAlias = 'id_aktifitas';
    public string $primaryKey = 'id_aktifitas';
    public string $sortField = 'id_aktifitas';
    public $id_kelas, $id_mata_kuliah;

    public function setUp(): array
    {
        // $this->showCheckBox();
        // $this->checkboxAttribute = 'id_aktifitas';

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
            // Button::add('bulk-delete')
            //     ->slot('Hapus data terpilih (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
            //     ->class('bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700')
            //     ->dispatch('bulkDelete.' . $this->tableName, [
            //     ]),
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
        return aktifitas::query()->where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->orderByRaw("
        CASE 
            WHEN nama_aktifitas IN ('UTS', 'UAS', 'Partisipasi') THEN 
                CASE 
                    WHEN nama_aktifitas = 'UTS' THEN 2
                    WHEN nama_aktifitas = 'UAS' THEN 3
                    WHEN nama_aktifitas = 'Partisipasi' THEN 4
                    ELSE 1
                END
            ELSE 1
        END
    ");
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nama_aktifitas')
            ->add('catatan');
    }

    public function columns(): array
    {
        return [
            Column::make('Nama aktifitas', 'nama_aktifitas')
                ->sortable()
                ->searchable(),

            Column::make('Catatan', 'catatan')
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    public function actionsFromView($row)
    {
        $aktifitas = Aktifitas::find($row->id_aktifitas);
        $row->kode_mata_kuliah = $aktifitas->matkul->kode_mata_kuliah;
        $row->nama_kelas = $aktifitas->kelas->nama_kelas;
        return view('livewire.dosen.aktifitas.kelas.action', ['row' => $row]);
    }



}
