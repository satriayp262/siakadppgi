<?php

namespace App\Livewire\Table;

use App\Models\BeritaAcara;
use App\Models\Kelas;
use App\Models\Matakuliah;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DetailPresensiDosenTable extends PowerGridComponent
{
    public string $tableName = 'detail-presensi-dosen-table-l65zhd-table';
    public string $primaryKey = 'id_berita_acara';
    public string $sortField = 'id_berita_acara';

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
        $nidn = request()->query('nidn');

        return BeritaAcara::query()
            ->with(['mataKuliah', 'kelas', 'semester'])
            ->when($nidn, function ($query) use ($nidn) {
                return $query->where('nidn', $nidn);
            });
    }

    public function relationSearch(): array
    {
        return [
            'mataKuliah' => [
                'nama_mata_kuliah',
                'id_mata_kuliah',
            ],
            'kelas' => [
                'nama_kelas',
                'id_kelas',
            ],
            'semester' => [
                'nama_semester',
                'id_semester',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_berita_acara')
            ->add('tanggal_formatted', fn(BeritaAcara $model) => Carbon::parse($model->tanggal)->format('d/m/Y'))
            ->add('nidn')
            ->add('mataKuliah.nama_mata_kuliah')
            ->add('materi')
            ->add('jumlah_mahasiswa')
            ->add('kelas.nama_kelas')
            ->add('semester.nama_semester');
    }

    public function columns(): array
    {
        return [
            Column::make('Tanggal', 'tanggal_formatted', 'tanggal')
                ->sortable(),

            Column::make('NIDN', 'nidn')
                ->sortable()
                ->searchable(),

            Column::make('Mata Kuliah', 'mataKuliah.nama_mata_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Materi', 'materi')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah Mahasiswa', 'jumlah_mahasiswa')
                ->sortable()
                ->searchable(),

            Column::make('Kelas', 'kelas.nama_kelas')
                ->sortable()
                ->searchable(),

            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('tanggal'),

            Filter::select('mataKuliah.nama_mata_kuliah', 'berita_acara.id_mata_kuliah')
                ->dataSource(
                    \App\Models\Matakuliah::all()->map(fn($mataKuliah) => [
                        'id' => $mataKuliah->id_mata_kuliah,
                        'name' => $mataKuliah->nama_mata_kuliah,
                    ])
                )
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('kelas.nama_kelas', 'berita_acara.id_kelas')
                ->dataSource(
                    \App\Models\Kelas::all()->map(fn($kelas) => [
                        'id' => $kelas->id_kelas,
                        'name' => $kelas->nama_kelas,
                    ])
                )
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }
}
