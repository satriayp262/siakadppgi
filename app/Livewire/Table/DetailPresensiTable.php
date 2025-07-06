<?php

namespace App\Livewire\Table;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DetailPresensiTable extends PowerGridComponent
{
    public string $tableName = 'detail-presensi-table';

    public string $primaryKey = 'id_mahasiswa';

    public string $token;
    public int $id_kelas;
    public int $id_mata_kuliah;

    public function setUp(): array
    {
        return [
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        // Subquery presensi terbaru berdasarkan token
        $latestPresensi = DB::table('presensi')
            ->select('id_mahasiswa', 'id', 'keterangan', 'created_at', 'alasan')
            ->where('token', $this->token)
            ->orderByDesc('created_at');

        return Mahasiswa::query()
            ->join('krs', 'mahasiswa.NIM', '=', 'krs.NIM')
            ->leftJoinSub($latestPresensi, 'latest_presensi', function ($join) {
                $join->on('mahasiswa.id_mahasiswa', '=', 'latest_presensi.id_mahasiswa');
            })
            ->where('krs.id_kelas', $this->id_kelas)
            ->where('krs.id_mata_kuliah', $this->id_mata_kuliah)
            ->select(
                'mahasiswa.id_mahasiswa',
                'mahasiswa.nama',
                'mahasiswa.NIM as nim',
                'latest_presensi.id',
                'latest_presensi.keterangan',
                'latest_presensi.created_at',
                'latest_presensi.alasan'
            );
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nama')
            ->add('nim')
            ->add('keterangan')
            ->add('created_at')
            ->add('alasan');
    }

    public function columns(): array
    {
        return [
            Column::make('Nama Mahasiswa', 'nama')
                ->sortable()
                ->searchable(),

            Column::make('NIM', 'nim')
                ->sortable()
                ->searchable(),

            Column::make('Tanggal Presensi', 'created_at')
                ->sortable()
                ->searchable(),

            Column::make('Keterangan', 'keterangan')
                ->sortable(),

            Column::make('Alasan', 'alasan')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.dosen.presensi.action2', ['row' => $row]);
    }

    public function filters(): array
    {
        return [];
    }
}
