<?php

namespace App\Livewire\table;

use App\Models\Mahasiswa;
use App\Models\Semester;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class PresensiMahasiwaTable extends PowerGridComponent
{
    public string $tableName = 'presensi-mahasiwa-table-qyqn0i-table';
    public string $primaryKey = 'id_mahasiswa';
    public string $sortField = 'id_mahasiswa';

    public function setUp(): array
    {
        return [
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Mahasiswa::query()
            ->leftJoin('presensi', 'mahasiswa.NIM', '=', 'presensi.nim')
            ->leftJoin('token', 'presensi.token', '=', 'token.token')
            ->leftJoin('semester', 'token.id_semester', '=', 'semester.id_semester')
            ->leftJoin('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi')
            ->selectRaw('
            mahasiswa.nama as nama_mahasiswa,
            mahasiswa.NIM as nim,
            prodi.nama_prodi as prodi,
            COALESCE(semester.nama_semester, "-") as semester,
            SUM(CASE WHEN presensi.keterangan = "Alpha" THEN 1 ELSE 0 END) as alpha_count,
            SUM(CASE WHEN presensi.keterangan = "Ijin" THEN 1 ELSE 0 END) as ijin_count,
            SUM(CASE WHEN presensi.keterangan = "Sakit" THEN 1 ELSE 0 END) as sakit_count,
            MAX(semester.id_semester) as id_semester
        ')
            ->groupBy(
                'mahasiswa.nama',
                'mahasiswa.id_mahasiswa',
                'mahasiswa.NIM',
                'prodi.nama_prodi',
                'semester.nama_semester'
            );
    }


    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_mahasiswa')
            ->add('nama_mahasiswa')
            ->add('nim')
            ->add('prodi')
            // ->add('semester')
            ->add('alpha_count')
            ->add('ijin_count')
            ->add('sakit_count');
        // ->add('id');
    }

    public function columns(): array
    {
        return [
            Column::make('Nama', 'nama_mahasiswa')->sortable()->searchable(),
            Column::make('NIM', 'nim')->sortable()->searchable(),
            Column::make('Program Studi', 'prodi')->sortable(),
            Column::make('Ijin', 'alpha_count')->sortable(),
            Column::make('Sakit', 'sakit_count')->sortable(),
            Column::make('Alpha', 'alpha_count')->sortable(),
            // Column::make('Semester', 'semester')->sortable(),
            Column::action('Action'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('Semester', 'id_semester')
                ->dataSource(Semester::all())
                ->optionValue('id_semester')
                ->optionLabel('nama_semester'),
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.admin.presensi-mahasiswa.action', ['row' => $row]);
    }
}
