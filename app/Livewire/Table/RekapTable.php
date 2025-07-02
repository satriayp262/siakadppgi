<?php

namespace App\Livewire\Table;

use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class RekapTable extends PowerGridComponent
{
    public string $tableName = 'rekap-table';
    public string $primaryKey = 'nim';
    public string $sortField = 'nim';

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

        $query = Mahasiswa::query()
            ->whereIn('nim', $nimList)
            ->select('id_mahasiswa', 'nim', 'nama');

        // Tambahkan kolom pertemuan 1 sampai 16 dengan huruf awal keterangan
        for ($i = 1; $i <= 16; $i++) {
            $query->selectRaw("
                (
                    SELECT LEFT(presensi.keterangan, 1)
                    FROM presensi
                    JOIN token ON token.token = presensi.token
                    WHERE presensi.nim = mahasiswa.nim
                    AND presensi.id_kelas = ?
                    AND presensi.id_mata_kuliah = ?
                    AND token.pertemuan = ?
                    LIMIT 1
                ) as p$i
            ", [$this->id_kelas, $this->id_mata_kuliah, $i]);
        }

        // Tambahkan total Hadir, Ijin, Sakit, Alpha
        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi WHERE presensi.nim = mahasiswa.nim AND presensi.keterangan = 'Hadir' AND presensi.id_mata_kuliah = ? AND presensi.id_kelas = ?) as jumlah_hadir
        ", [$this->id_mata_kuliah, $this->id_kelas]);
        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi WHERE presensi.nim = mahasiswa.nim AND presensi.keterangan = 'Ijin' AND presensi.id_mata_kuliah = ? AND presensi.id_kelas = ?) as jumlah_ijin
        ", [$this->id_mata_kuliah, $this->id_kelas]);
        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi WHERE presensi.nim = mahasiswa.nim AND presensi.keterangan = 'Sakit' AND presensi.id_mata_kuliah = ? AND presensi.id_kelas = ?) as jumlah_sakit
        ", [$this->id_mata_kuliah, $this->id_kelas]);
        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi WHERE presensi.nim = mahasiswa.nim AND presensi.keterangan = 'Alpha' AND presensi.id_mata_kuliah = ? AND presensi.id_kelas = ?) as jumlah_alpha
        ", [$this->id_mata_kuliah, $this->id_kelas]);

        return $query->orderBy('nim');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        $fields = PowerGrid::fields()
            ->add('nim')
            ->add('nama');

        for ($i = 1; $i <= 16; $i++) {
            $fields->add("p$i");
        }

        $fields->add('jumlah_hadir')
            ->add('jumlah_ijin')
            ->add('jumlah_sakit')
            ->add('jumlah_alpha');

        return $fields;
    }

    public function columns(): array
    {
        $columns = [
            // Column::make('NIM', 'nim')->sortable()->searchable(),
            Column::make('Nama', 'nama')->sortable()->searchable(),
        ];

        for ($i = 1; $i <= 16; $i++) {
            $columns[] = Column::make("$i", "p$i")
                ->bodyAttribute('text-center lowercase'); // Tambahkan 'lowercase' di sini
        }


        // $columns[] = Column::make('H', 'jumlah_hadir')->bodyAttribute('text-center');
        // $columns[] = Column::make('I', 'jumlah_ijin')->bodyAttribute('text-center');
        // $columns[] = Column::make('S', 'jumlah_sakit')->bodyAttribute('text-center');
        // $columns[] = Column::make('A', 'jumlah_alpha')->bodyAttribute('text-center');

        return $columns;
    }

    public function filters(): array
    {
        return [];
    }
}
