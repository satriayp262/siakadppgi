<?php

namespace App\Livewire\table;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class KelasTable extends PowerGridComponent
{
    public ?string $primaryKeyAlias = 'id_kelas';
    public string $primaryKey = 'kelas.id_kelas';
    public string $sortField = 'kelas.id_kelas';
    public string $tableName = 'kelas-gsy2i9-table';


    public function header(): array
    {
        $this->checkboxAttribute = 'id_kelas';
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
        return Kelas::with(['semester']);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('angkatan', function ($kelas) {
                $nama = $kelas->semester->nama_semester ?? '';
                return preg_replace('/\d{1}$/', '', $nama);
            })
            ->add(fieldName: 'nama_kelas')
            ->add(fieldName: 'bahasan')
            ->add('display_lingkup_kelas', function ($kelas) {
                if ($kelas->lingkup_kelas == '1') {
                    return 'Internal';
                } elseif ($kelas->lingkup_kelas == '2') {
                    return 'Eksternal';
                } elseif ($kelas->lingkup_kelas == '3') {
                    return 'Campuran';
                }
            })
            ->add('display_mode_kuliah', function ($kelas) {
                if ($kelas->mode_kuliah == 'O') {
                    return 'Online';
                } elseif ($kelas->mode_kuliah == 'F') {
                    return 'Offline';
                } elseif ($kelas->mode_kuliah == 'M') {
                    return 'Campuran';
                }
            })
            ->add('prodi.kode_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('Angkatan', 'angkatan')
                ->sortable()
                ->searchable(),

            Column::make('Nama Kelas', 'nama_kelas')
                ->sortable()
                ->searchable(),

            Column::make('Bahasan', 'bahasan')
                ->sortable()
                ->searchable(),

            Column::make('Lingkup Kelas', 'display_lingkup_kelas')
                ->sortable()
                ->searchable(),

            Column::make('Mode Kuliah', 'display_mode_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Prodi', 'prodi.kode_prodi')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.kelas.action', ['row' => $row]);
    }
}
