<?php

namespace App\Livewire\Table;

use App\Models\Kelas;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Prodi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class KRSTable extends PowerGridComponent
{
    public ?string $primaryKeyAlias = 'id_mahasiswa';
    public string $primaryKey = 'mahasiswa.id_mahasiswa';
    public string $sortField = 'mahasiswa.id_mahasiswa';
    public string $tableName = 'k-r-s-table-epbrgt-table';

    public function setUp(): array
    {
        // $this->showCheckBox();
        
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
        return Mahasiswa::query()
            // ->whereIn('id_krs', function ($query) {
            //     $query->selectRaw('MIN(id_krs)')
            //         ->from('krs')
            //         ->groupBy('NIM');
            // })
            ->with(['prodi', 'kelas']);
    }


    public function relationSearch(): array
    {
        return [
            'prodi' => [
                'nama_prodi',
                'kode_prodi',
            ],
            'kelas' => [
                'nama_kelas',
                'id_kelas',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('NIM')
            ->add('nama')
            ->add('kelas.nama_kelas')
            ->add('prodi.nama_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')->index(),
            Column::make('NIM', 'NIM')
                ->sortable()
                ->searchable(),

            Column::make('Nama', 'nama')
                ->sortable()
                ->searchable(),
            
                Column::make('kelas', 'kelas.nama_kelas')
                ->sortable()
                ->searchable(),

            Column::make('prodi', 'prodi.nama_prodi')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('prodi.nama_prodi', 'kode_prodi')
                ->dataSource(Prodi::all()->map(callback: fn($prodi) => [
                    'value' => $prodi->kode_prodi,
                    'label' => $prodi->nama_prodi,
                ]))
                ->optionLabel('label')
                ->optionValue('value'),

            Filter::select('kelas.nama_kelas', 'id_kelas')
                ->dataSource(Kelas::all()->map(fn($kelas) => [
                    'value' => $kelas->id_kelas,
                    'label' => $kelas->nama_kelas,
                ]))
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actionsFromView($row)
    {

        return view('livewire.admin.krs.action', ['row' => $row]);
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
