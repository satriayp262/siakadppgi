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
            ->add('matkul.nama_mata_kuliah')
            ->add('kelas.nama_kelas')
            ->add('semester.nama_semester')
            ->add('valid_until');
    }

    public function columns(): array
    {
        return [
            Column::make('Token', 'token')->sortable()->searchable(),

            Column::make('Mata Kuliah', 'matkul.nama_mata_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Kelas', 'kelas.nama_kelas')
                ->sortable()
                ->searchable(),

            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->searchable(),

            Column::make('Valid Until', 'valid_until')
                ->sortable()
                ->searchable(),

            Column::action('Aksi'),
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
