<?php

namespace App\Livewire\Table;

use App\Models\Mahasiswa;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DetailPresensiTable extends PowerGridComponent
{
    public string $tableName = 'detail-presensi-table';

    // Parameter dari luar
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
        return Mahasiswa::query()
            ->join('krs', 'mahasiswa.NIM', '=', 'krs.NIM')
            ->where('krs.id_kelas', $this->id_kelas)
            ->where('krs.id_mata_kuliah', $this->id_mata_kuliah)
            ->leftJoin('presensi', function ($join) {
                $join->on('mahasiswa.NIM', '=', 'presensi.nim')
                    ->where('presensi.token', '=', $this->token);
            })
            ->select(
                'mahasiswa.id_mahasiswa',
                'mahasiswa.nama',
                'mahasiswa.NIM as nim',
                'presensi.id',
                'presensi.token as token',
                'presensi.waktu_submit',
                'presensi.keterangan',
                'presensi.alasan'
            );
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nama')
            ->add('nim')
            ->add('waktu_submit')
            ->add('keterangan')
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

            Column::make('Jam Presensi', 'waktu_submit')
                ->sortable(),

            Column::make('Keterangan', 'keterangan')
                ->sortable(),

            Column::make('Alasan', 'alasan' ?? '-')
                ->sortable(),

            Column::action('Action'),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    // Uncomment jika ingin tambahkan tombol Edit:
    public function actionsFromView($row)
    {

        return view('livewire.dosen.presensi.action2', ['row' => $row]);
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert("Edit mahasiswa NIM: ' . $rowId . '")');
    // }
}
