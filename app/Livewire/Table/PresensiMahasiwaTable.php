<?php

namespace App\Livewire\Table;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Semester;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Illuminate\Database\Eloquent\Builder;

final class PresensiMahasiwaTable extends PowerGridComponent
{
    public string $tableName = 'presensi-mahasiwa-table-qyqn0i-table';
    public ?string $primaryKeyAlias = 'id_mahasiswa';
    public string $primaryKey = 'id_mahasiswa';
    public string $sortField = 'id_mahasiswa';
    public string $semesterFilter = '';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns()
                ->includeViewOnTop('livewire.admin.presensi-mahasiswa.filters'),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function getSemestersProperty()
    {
        return Semester::orderBy('nama_semester', 'desc')
            ->orderBy('id_semester', 'desc')
            ->get();
    }

    public function getActiveSemesterIdProperty()
    {
        return Semester::where('is_active', 1)->value('id_semester');
    }

    public function updatedSemesterFilter($value)
    {
        $this->semesterFilter = $value;
        $this->refresh();
    }

    public function datasource(): Builder
    {
        // Gunakan semester yang dipilih jika ada, jika tidak gunakan semester aktif
        $semesterId = $this->semesterFilter ?: Semester::where('is_active', 1)->value('id_semester');

        $query = Mahasiswa::with(['prodi'])
            ->withCount([
                'presensi as alpha_count' => function ($query) use ($semesterId) {
                    $query->where('keterangan', 'Alpha')
                        ->when($semesterId, function ($q) use ($semesterId) {
                            $q->whereHas('token', function ($q) use ($semesterId) {
                                $q->where('id_semester', $semesterId);
                            });
                        });
                },
                'presensi as hadir_count' => function ($query) use ($semesterId) {
                    $query->where('keterangan', 'Hadir')
                        ->when($semesterId, function ($q) use ($semesterId) {
                            $q->whereHas('token', function ($q) use ($semesterId) {
                                $q->where('id_semester', $semesterId);
                            });
                        });
                },
                'presensi as ijin_count' => function ($query) use ($semesterId) {
                    $query->where('keterangan', 'Ijin')
                        ->when($semesterId, function ($q) use ($semesterId) {
                            $q->whereHas('token', function ($q) use ($semesterId) {
                                $q->where('id_semester', $semesterId);
                            });
                        });
                },
                'presensi as sakit_count' => function ($query) use ($semesterId) {
                    $query->where('keterangan', 'Sakit')
                        ->when($semesterId, function ($q) use ($semesterId) {
                            $q->whereHas('token', function ($q) use ($semesterId) {
                                $q->where('id_semester', $semesterId);
                            });
                        });
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
    }

    public function columns(): array
    {
        return [
            Column::make('Nama', 'nama')->sortable()->searchable(),
            Column::make('NIM', 'nim')->sortable()->searchable(),
            Column::make('Prodi', 'prodi.nama_prodi')
                ->sortable()
                ->searchable(),
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
                    Prodi::all()->map(function ($prodi) {
                        return [
                            'id' => $prodi->kode_prodi,
                            'name' => $prodi->nama_prodi,
                        ];
                    })
                )
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.presensi-mahasiswa.action', ['row' => $row]);
    }
}
