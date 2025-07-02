<?php

namespace App\Livewire\Table;

use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Column;

final class TokenTable extends PowerGridComponent
{
    public string $tableName = 'token-table';

    public int $id_mata_kuliah;
    public int $id_kelas;

    public function setUp(): array
    {
        return [
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $userId = Auth::id();

        return Token::query()
            ->with(['matkul', 'kelas', 'semester'])
            ->where('id', $userId)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->latest();
    }


    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('token')
            ->add('semester.nama_semester')
            ->add('valid_until_formatted', fn($model) => \Carbon\Carbon::parse($model->valid_until)->format('H:i'))
            ->add('created_at_formatted', function ($model) {
                // Format: Senin, 2025-07-01
                return \Carbon\Carbon::parse($model->created_at)
                    ->locale('id') // gunakan lokal Indonesia
                    ->translatedFormat('l, Y-m-d');
            })
            ->add('sesi')
            ->add('pertemuan');
    }


    public function columns(): array
    {
        return [
            Column::make('Pertemuan', 'pertemuan')
                ->sortable()
                ->searchable()
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center'),

            Column::make('Tanggal', 'created_at_formatted')
                ->sortable()
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center'),

            Column::make('Sesi', 'sesi')
                ->sortable()
                ->searchable()
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center'),

            Column::make('Token', 'token')
                ->sortable()
                ->searchable()
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center'),

            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center'),

            Column::make('Valid Until', 'valid_until_formatted')
                ->sortable()
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center'),

            Column::action('Aksi')
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center'),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actionsFromView($row)
    {
        return view('livewire.dosen.presensi.action', ['row' => $row]);
    }
}
