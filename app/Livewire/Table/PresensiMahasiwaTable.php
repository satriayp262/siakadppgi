<?php

namespace App\Livewire\Table;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

final class PresensiMahasiwaTable extends PowerGridComponent
{
    public string $tableName = 'presensi-mahasiwa-table-qyqn0i-table';
    public ?string $primaryKeyAlias = 'id_mahasiswa';
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
        $semesterFilter = $this->filters['semester'] ?? null;

        $query = Mahasiswa::with(['prodi', 'presensi.token.semester'])
            ->withCount([
                'presensi as alpha_count' => function ($query) use ($semesterFilter) {
                    $query->where('keterangan', 'Alpha');
                    if ($semesterFilter) {
                        $query->whereHas('token.semester', function ($q) use ($semesterFilter) {
                            $q->where('id', $semesterFilter);
                        });
                    }
                },
                'presensi as ijin_count' => function ($query) use ($semesterFilter) {
                    $query->where('keterangan', 'Ijin');
                    if ($semesterFilter) {
                        $query->whereHas('token.semester', function ($q) use ($semesterFilter) {
                            $q->where('id', $semesterFilter);
                        });
                    }
                },
                'presensi as sakit_count' => function ($query) use ($semesterFilter) {
                    $query->where('keterangan', 'Sakit');
                    if ($semesterFilter) {
                        $query->whereHas('token.semester', function ($q) use ($semesterFilter) {
                            $q->where('id', $semesterFilter);
                        });
                    }
                },
                'presensi as hadir_count' => function ($query) use ($semesterFilter) {
                    $query->where('keterangan', 'Hadir');
                    if ($semesterFilter) {
                        $query->whereHas('token.semester', function ($q) use ($semesterFilter) {
                            $q->where('id', $semesterFilter);
                        });
                    }
                },
            ]);

        return $query;
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
            ->add('id_mahasiswa')
            ->add('nama', fn($row) => $row->nama)
            ->add('nim', fn($row) => $row->NIM)
            ->add('prodi.nama_prodi')
            ->add('alpha_count', fn($row) => $row->alpha_count ?? 0)
            ->add('ijin_count', fn($row) => $row->ijin_count ?? 0)
            ->add('sakit_count', fn($row) => $row->sakit_count ?? 0)
            ->add('hadir_count', fn($row) => $row->hadir_count ?? 0);
            // ->add('semester', function ($row) {
            //     if ($row->presensi->count() > 0) {
            //         $semester = $row->presensi->first()->token->semester->nama_semester ?? '-';
            //         return $semester;
            //     }
            //     return '-';
            // });
    }


    public function columns(): array
    {
        return [
            Column::make('Nama', 'nama')->sortable()->searchable(),
            Column::make('NIM', 'nim')->sortable()->searchable(),
            // Column::make('Prodi', 'prodi')->sortable(),
            Column::make('Prodi', 'prodi.nama_prodi')
                ->sortable()
                ->searchable(),
            // Column::make('Semester', 'semester.nama_semester')
            //     ->sortable()
            //     ->searchable(),
            Column::make('H', 'hadir_count')->sortable(),
            Column::make('S', 'sakit_count')->sortable(),
            Column::make('I', 'ijin_count')->sortable(),
            Column::make('A', 'alpha_count')->sortable(),
            Column::action('Action'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('prodi.nama_prodi', 'mahasiswa.kode_prodi')
                ->dataSource(
                    Prodi::all()->map(fn($prodi) => [
                        'id' => $prodi->kode_prodi,
                        'name' => $prodi->nama_prodi,
                    ])
                )
                ->optionLabel('name')
                ->optionValue('id'),

            // Filter::select('semester.nama_semester', 'token.id_semester')
            //     ->dataSource(\App\Models\Semester::all()->map(fn($semester) => [
            //         'id' => $semester->id_semester,
            //         'name' => $semester->nama_semester,
            //     ]))
            //     ->optionLabel('name')
            //     ->optionValue('id'),

        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.presensi-mahasiswa.action', ['row' => $row]);
    }
}
