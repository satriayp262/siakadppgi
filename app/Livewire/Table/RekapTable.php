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
    public string $primaryKey = 'id_mahasiswa';
    public string $sortField = 'nama';

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
            ->select('id_mahasiswa', 'nim', 'nama')
            ->orderBy('nama', 'asc');


        for ($i = 1; $i <= 16; $i++) {
            $query->selectRaw("
                (
                    SELECT
                        CASE
                            WHEN LEFT(presensi.keterangan, 1) = 'H' THEN '✔'
                            ELSE LEFT(presensi.keterangan, 1)
                        END
                    FROM presensi
                    JOIN token ON token.token = presensi.token
                    WHERE presensi.id_mahasiswa = mahasiswa.id_mahasiswa
                    AND presensi.id_kelas = ?
                    AND presensi.id_mata_kuliah = ?
                    AND token.pertemuan = ?
                    LIMIT 1
                ) as p$i
            ", [$this->id_kelas, $this->id_mata_kuliah, $i]);
        }

        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.id_mahasiswa = mahasiswa.id_mahasiswa
             AND presensi.keterangan = 'Hadir'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_hadir
        ", [$this->id_mata_kuliah, $this->id_kelas]);

        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.id_mahasiswa = mahasiswa.id_mahasiswa
             AND presensi.keterangan = 'Ijin'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_ijin
        ", [$this->id_mata_kuliah, $this->id_kelas]);

        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.id_mahasiswa = mahasiswa.id_mahasiswa
             AND presensi.keterangan = 'Sakit'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_sakit
        ", [$this->id_mata_kuliah, $this->id_kelas]);

        $query->selectRaw("
            (SELECT COUNT(*) FROM presensi
             WHERE presensi.id_mahasiswa = mahasiswa.id_mahasiswa
             AND presensi.keterangan = 'Alpha'
             AND presensi.id_mata_kuliah = ?
             AND presensi.id_kelas = ?) as jumlah_alpha
        ", [$this->id_mata_kuliah, $this->id_kelas]);

        return $query->orderBy('nim');

    }

    public function datasourceWithRekap(): \Illuminate\Support\Collection
    {
        $data = $this->datasource()->get();

        $rekapRow = ['nim' => 'rekap', 'nama' => 'Rekap'];

        for ($i = 1; $i <= 16; $i++) {
            $rekap = DB::table('presensi')
                ->join('token', 'presensi.token', '=', 'token.token')
                ->where('token.pertemuan', $i)
                ->where('presensi.id_kelas', $this->id_kelas)
                ->where('presensi.id_mata_kuliah', $this->id_mata_kuliah)
                ->selectRaw("
                SUM(CASE WHEN keterangan = 'Hadir' THEN 1 ELSE 0 END) as H,
                SUM(CASE WHEN keterangan = 'Ijin' THEN 1 ELSE 0 END) as I,
                SUM(CASE WHEN keterangan = 'Sakit' THEN 1 ELSE 0 END) as S,
                SUM(CASE WHEN keterangan = 'Alpha' THEN 1 ELSE 0 END) as A
            ")
                ->first();

            // Handle null values if no data found
            $h = $rekap->H ?? 0;
            $i_count = $rekap->I ?? 0;
            $s = $rekap->S ?? 0;
            $a = $rekap->A ?? 0;

            $rekapRow["p$i"] = "H:$h I:$i_count S:$s A:$a";

            // Collect debug data instead of dd-ing immediately
            $debugData["meeting_$i"] = [
                'raw_rekap' => $rekap,
                'processed' => ['H' => $h, 'I' => $i_count, 'S' => $s, 'A' => $a],
                'formatted' => $rekapRow["p$i"]
            ];
        }

        // Set empty values for summary columns
        $rekapRow['jumlah_hadir'] = '';
        $rekapRow['jumlah_ijin'] = '';
        $rekapRow['jumlah_sakit'] = '';
        $rekapRow['jumlah_alpha'] = '';

        $data->push((object)$rekapRow);

        return $data;
    }

    public function datasourceToCollection(): \Illuminate\Support\Collection
    {
        return $this->datasourceWithRekap();
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
            Column::make('Nama', 'nama')->sortable()->searchable(),
        ];

        for ($i = 1; $i <= 16; $i++) {
            $columns[] = Column::make("$i", "p$i")->bodyAttribute('text-center text-bold');
        }

        $columns[] = Column::make('H', 'jumlah_hadir')->bodyAttribute('text-center');
        $columns[] = Column::make('I', 'jumlah_ijin')->bodyAttribute('text-center');
        $columns[] = Column::make('S', 'jumlah_sakit')->bodyAttribute('text-center');
        $columns[] = Column::make('A', 'jumlah_alpha')->bodyAttribute('text-center');

        return $columns;
    }

    public function filters(): array
    {
        return [];
    }
}
