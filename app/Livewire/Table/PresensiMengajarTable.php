<?php

namespace App\Livewire\Table;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Token;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class PresensiMengajarTable extends PowerGridComponent
{
    public string $tableName = 'presensi-mengajar-table';
    public ?string $primaryKeyAlias = 'id';
    public string $primaryKey = 'dosen.id_dosen';
    public string $sortField = 'dosen.id_dosen';


    public function setUp(): array
    {
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
        return \App\Models\Dosen::query()
            ->with('prodi')
            ->withCount([
                'tokens as tokens_count'
            ]);
    }


    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_dosen')
            ->add('nama_dosen')
            ->add('nidn')
            ->add('prodi.nama_prodi')
            ->add('tokens_count') // hasil dari withCount
            ->add('jumlah_jam', fn($dosen) => $dosen->tokens_count * 1.5);
    }

    public function columns(): array
    {
        return [
            Column::make('NAMA DOSEN', 'nama_dosen')
                ->sortable()
                ->searchable(),

            Column::make('NIDN', 'nidn')
                ->sortable()
                ->searchable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->sortable(),

            Column::make('JUMLAH TOKEN', 'tokens_count')
                ->sortable(),

            Column::make('JUMLAH JAM', 'jumlah_jam')
                ->sortable(),

            Column::action('AKSI'),
        ];
    }

    public function filters(): array
    {
        return [

            // Filter Prodi
            Filter::select('prodi.nama_prodi', 'dosen.kode_prodi')
                ->dataSource(
                    Prodi::all()->map(fn($prodi) => [
                        'id' => $prodi->kode_prodi,
                        'name' => $prodi->nama_prodi,
                    ])
                )
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.presensi-dosen.action', ['row' => $row]);
    }
}
