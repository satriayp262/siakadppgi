<?php

namespace App\Livewire\Table;

use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Column;
use Carbon\Carbon;

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
            ->with(['matkul', 'kelas', 'semester', 'jadwal'])
            ->where('id', $userId)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->orderByDesc('pertemuan');
    }


    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('token')
            ->add('semester.nama_semester')
            ->add('jadwal.jam_selesai', function ($model) {
                return \Carbon\Carbon::parse($model->jadwal->jam_selesai)->format('H:i');
            })
            ->add('created_at_formatted', function ($model) {
                return Carbon::parse($model->created_at)
                    ->timezone('Asia/Jakarta') // Konversi timezone
                    ->locale('id')             // Bahasa Indonesia
                    ->isoFormat('dddd, YYYY-MM-DD'); // Format contoh: "Jumat, 2025-07-03"
            })
            ->add('jadwal.sesi')
            ->add('pertemuan')
            ->add('valid_until', function ($model) {
                return Carbon::parse($model->valid_until)
                    ->timezone('Asia/Jakarta') // Konversi timezone
                    ->locale('id');         // Bahasa Indonesia
                    // ->isoFormat('HH:mm'); // Format contoh: "Jumat, 2025-07-03 14:00"
            });
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

            Column::make('Sesi', 'jadwal.sesi')
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

            Column::make('Valid Until', 'valid_until')
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
