<?php

namespace App\Livewire\Table;

use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class RekapTable extends PowerGridComponent
{
    public string $tableName = 'rekap-table';
    public string $primaryKey = 'nim'; // Pakai 'nim' sebagai primary key
    public string $sortField = 'nim'; // Jangan gunakan 'id' karena tidak tersedia
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
        $nimList = Krs::where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->pluck('nim');

        return Mahasiswa::query()
            ->whereIn('nim', $nimList)
            ->select('id_mahasiswa', 'nim', 'nama')
            ->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.nim = mahasiswa.nim
             AND presensi.keterangan = 'Hadir'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_hadir
        ", [$this->id_mata_kuliah, $this->id_kelas])
            ->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.nim = mahasiswa.nim
             AND presensi.keterangan = 'Ijin'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_ijin
        ", [$this->id_mata_kuliah, $this->id_kelas])
            ->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.nim = mahasiswa.nim
             AND presensi.keterangan = 'Sakit'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_sakit
        ", [$this->id_mata_kuliah, $this->id_kelas])
            ->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.nim = mahasiswa.nim
             AND presensi.keterangan = 'Alpha'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_alpha
        ", [$this->id_mata_kuliah, $this->id_kelas])
            ->orderBy('nim');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nim')
            ->add('nama')
            ->add('jumlah_hadir')
            ->add('jumlah_ijin')
            ->add('jumlah_sakit')
            ->add('jumlah_alpha');
    }

    public function columns(): array
    {
        return [
            Column::make('NIM', 'nim')
                ->sortable()
                ->searchable(),

            Column::make('Nama', 'nama')
                ->sortable()
                ->searchable(),

            Column::make('Hadir', 'jumlah_hadir')
                ->sortable()
                ->bodyAttribute('text-center'),

            Column::make('Ijin', 'jumlah_ijin')
                ->sortable()
                ->bodyAttribute('text-center'),

            Column::make('Sakit', 'jumlah_sakit')
                ->sortable()
                ->bodyAttribute('text-center'),

            Column::make('Alpha', 'jumlah_alpha')
                ->sortable()
                ->bodyAttribute('text-center'),
        ];
    }

    public function filters(): array
    {
        return [];
    }
}
