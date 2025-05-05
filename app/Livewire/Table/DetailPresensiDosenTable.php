<?php

namespace App\Livewire\Table;

use App\Models\BeritaAcara;
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
        // Ambil nidn dari query parameter URL
        $nidn = request()->query('nidn');  // Ambil nilai nidn dari URL

        return BeritaAcara::query()
            ->when($nidn, function ($query) use ($nidn) {
                return $query->where('nidn', $nidn);  // Filter berdasarkan nidn
            });
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_berita_acara')
            ->add('tanggal_formatted', fn (BeritaAcara $model) => Carbon::parse($model->tanggal)->format('d/m/Y'))
            ->add('nidn')
            ->add('id_mata_kuliah')
            ->add('materi')
            ->add('jumlah_mahasiswa')
            ->add('id_kelas')
            ->add('id_semester');
    }

    public function columns(): array
    {
        return [
            // Column::make('Id berita acara', 'id_berita_acara')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Tanggal', 'tanggal_formatted', 'tanggal')
                ->sortable(),

            Column::make('Nidn', 'nidn')
                ->sortable()
                ->searchable(),

            Column::make('Id mata kuliah', 'id_mata_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Materi', 'materi')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah mahasiswa', 'jumlah_mahasiswa')
                ->sortable()
                ->searchable(),

            Column::make('Id kelas', 'id_kelas')
                ->sortable()
                ->searchable(),

            Column::make('Id semester', 'id_semester')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('tanggal'),
        ];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    // public function actions(BeritaAcara $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: '.$row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }
}
