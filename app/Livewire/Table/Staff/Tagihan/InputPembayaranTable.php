<?php

namespace App\Livewire\Table\Staff\Tagihan;

use Illuminate\Support\Carbon;
use App\Models\Mahasiswa;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class InputPembayaranTable extends PowerGridComponent
{
    public string $tableName = 'input-pembayaran-table-fkhj7n-table';

    public function datasource(): Collection
    {
        $mahasiswas = Mahasiswa::query()->whereHas('tagihan')->get();
        return $mahasiswas;
    }

    public function setUp(): array
    {
        //$this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }
    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama')
            ->add('NIM')
            ->add('semester.nama_semester')
            ->add('prodi.nama_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')->index(),

            Column::make('Name', 'nama')
                ->searchable()
                ->sortable(),

            Column::make('NIM', 'NIM')
                ->sortable(),

            Column::make('Angkatan', 'semester.nama_semester')
                ->sortable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->sortable(),

            Column::action('Action')
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

        return view('livewire.staff.tagihan.action2', ['row' => $row]);
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
}
