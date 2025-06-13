<?php

namespace App\Livewire\Table;

use App\Models\Jawaban;
use App\Models\PeriodeEMonev;
use App\Models\Pertanyaan;
use App\Models\Prodi;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Facades\Filter;

use Illuminate\Support\Facades\DB;

final class EmonevAdmin extends PowerGridComponent
{
    public string $tableName = 'emonev-admin-jfjqjo-table';
    public $periode;


    use WithExport;

    public function datasource(): Collection
    {
        $periode = $this->periode;

        $pertanyaan = Pertanyaan::all();
        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
            ->join('kelas', 'emonev.id_kelas', '=', 'kelas.id_kelas')
            ->join('matkul', 'emonev.id_mata_kuliah', '=', 'matkul.id_mata_kuliah')
            ->join('dosen', 'matkul.nidn', '=', 'dosen.nidn')
            ->join('periode_emonev', 'emonev.nama_periode', '=', 'periode_emonev.nama_periode')
            ->join('prodi', 'matkul.kode_prodi', '=', 'prodi.kode_prodi')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'periode_emonev.nama_periode',
                'matkul.nama_mata_kuliah',
            );

        $query->where('periode_emonev.nama_periode', $periode);

        $totalExpr = [];

        foreach ($pertanyaan as $p) {
            $query->addSelect(DB::raw(
                "
            (SELECT ROUND(AVG(jwbn.nilai), 0) 
             FROM jawaban jwbn 
             JOIN emonev em ON jwbn.id_emonev = em.id_emonev
             WHERE em.nidn = dosen.nidn 
             AND em.nama_periode = periode_emonev.nama_periode
             AND jwbn.id_pertanyaan = $p->id_pertanyaan
            ) AS `pertanyaan_$p->id_pertanyaan`"
            ));

            $totalExpr[] = "COALESCE((
                SELECT ROUND(AVG(jwbn.nilai), 0) 
                FROM jawaban jwbn 
                JOIN emonev em ON jwbn.id_emonev = em.id_emonev
                WHERE em.nidn = dosen.nidn 
                AND em.nama_periode = periode_emonev.nama_periode
                AND jwbn.id_pertanyaan = $p->id_pertanyaan
            ), 0)";
        }

        //$query->addSelect(DB::raw('(' . implode(' + ', $totalExpr) . ') AS total_skor'));

        $query->addSelect(DB::raw('(
            CONCAT(
                (' . implode(' + ', $totalExpr) . '), 
                " / ", 
                (
                    SELECT COUNT(DISTINCT jwbn.id_pertanyaan) * 10
                    FROM jawaban jwbn
                    JOIN emonev em ON jwbn.id_emonev = em.id_emonev
                    WHERE em.nidn = dosen.nidn
                    AND em.nama_periode = periode_emonev.nama_periode
                )
            )
        ) AS total_skor'));


        $query->groupBy(
            'dosen.nidn',
            'dosen.nama_dosen',
            'matkul.nama_mata_kuliah',
            'prodi.nama_prodi',
            'periode_emonev.nama_periode',
        )->get();

        return $query->get();
    }


    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {

        return [

            PowerGrid::exportable(fileName: 'emonev-file')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->csvSeparator(separator: '|')
                ->csvDelimiter(delimiter: "'"),

            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function relationSearch(): array
    {
        return [
            'dosen' => [
                'nidn',
                'nama_dosen',
            ],
            'prodi' => [
                'kode_prodi',
                'nama_prodi',
            ],
            'periode_emonev' => [
                'nama_periode',
            ],
            'matkul' => [
                'id_mata_kuliah',
                'nama_mata_kuliah',
            ],
        ];
    }


    public function fields(): PowerGridFields
    {
        $fields = PowerGrid::fields()
            ->add('id')
            ->add('periode_emonev.nama_periode')
            ->add('dosen.nama_dosen')
            ->add('prodi.nama_prodi')
            ->add('matkul.nama_mata_kuliah');

        // Tambahkan semua field pertanyaan_X secara dinamis
        foreach (Pertanyaan::all() as $p) {
            $fields->add("pertanyaan_$p->id_pertanyaan");
        }

        $fields->add('total_skor');

        return $fields;
    }

    public function columns(): array
    {
        $columns = [];

        // Kolom dinamis untuk setiap pertanyaan
        foreach (Pertanyaan::whereHas('jawaban.emonev', function ($q) {
            $q->where('nama_periode', $this->periode);
        })->get() as $p) {
            $columns[] = Column::make($p->pertanyaan ?? "$p->nama_pertanyaan", "pertanyaan_$p->id_pertanyaan")
                ->sortable()
                ->searchable();
        }

        return array_merge(
            [
                Column::make('ID', 'id')->visibleInExport(false)->index(),


                Column::make('Dosen', 'nama_dosen')
                    ->searchable()
                    ->sortable(),

                Column::make('Prodi', 'nama_prodi')
                    ->searchable()
                    ->sortable(),

                Column::make('Mata Kuliah', 'nama_mata_kuliah')
                    ->searchable()
                    ->sortable(),

            ],
            $columns,
            [
                Column::make('Total NIlai', 'total_skor')
                    ->sortable()
                    ->searchable(),
            ]
        );
    }

    public function filters(): array
    {
        return [
            Filter::select('nama_periode', 'nama_periode')
                ->dataSource(PeriodeEMonev::all()->map(fn($periode) => [
                    'value' => $periode->nama_periode,
                    'label' => $periode->nama_periode,
                ]))
                ->optionLabel('label')
                ->optionValue('value'),

            Filter::select('nama_prodi', 'nama_prodi')
                ->dataSource(Prodi::all()->map(fn($prodi) => [
                    'value' => $prodi->nama_prodi,
                    'label' => $prodi->nama_prodi,
                ]))
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }
}
