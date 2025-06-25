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
            $avgQuery = "
            (SELECT ROUND(AVG(jwbn.nilai), 0) 
             FROM jawaban jwbn 
             JOIN emonev em ON jwbn.id_emonev = em.id_emonev
             WHERE em.nidn = dosen.nidn 
             AND em.nama_periode = periode_emonev.nama_periode
             AND jwbn.id_pertanyaan = {$p->id_pertanyaan}
            )";

            $query->addSelect(DB::raw("$avgQuery AS pertanyaan_{$p->id_pertanyaan}"));

            $totalExpr[] = "COALESCE($avgQuery, 0)";

        }

        $maxSkorExpr = '(
            SELECT COUNT(DISTINCT jwbn.id_pertanyaan) * 10
            FROM jawaban jwbn
            JOIN emonev em ON jwbn.id_emonev = em.id_emonev
            WHERE em.nidn = dosen.nidn
            AND em.nama_periode = periode_emonev.nama_periode
        )';

        $skor = '(' . implode(' + ', $totalExpr) . ')';

        $skordevided = '(' . implode(' + ', $totalExpr) . ') / ' . count($totalExpr);


        $query->addSelect(DB::raw('(
            SELECT COUNT(DISTINCT em_sub.id_emonev)
            FROM emonev em_sub
            WHERE em_sub.nidn = dosen.nidn
              AND em_sub.nama_periode = periode_emonev.nama_periode
        ) AS jumlah_partisipan'));

        $query->addSelect(DB::raw("
        CONCAT($skor, ' / ', $maxSkorExpr) AS total_skor,
        ROUND(($skor / NULLIF($maxSkorExpr, 0)) * 100, 1) AS persentase,
        ROUND($skordevided, 2) AS rata_rata,
        CASE 
            WHEN ROUND(($skor / NULLIF($maxSkorExpr, 0)) * 100, 1) >= 90 THEN 'Luar Biasa'
            WHEN ROUND(($skor / NULLIF($maxSkorExpr, 0)) * 100, 1) >= 80 THEN 'Sangat Baik'
            WHEN ROUND(($skor / NULLIF($maxSkorExpr, 0)) * 100, 1) >= 70 THEN 'Baik'
            WHEN ROUND(($skor / NULLIF($maxSkorExpr, 0)) * 100, 1) >= 60 THEN 'Kurang'
            ELSE 'Sangat Kurang'
        END AS persentase_badge
    "));

        return $query->groupBy(
            'dosen.nidn',
            'dosen.nama_dosen',
            'matkul.nama_mata_kuliah',
            'prodi.nama_prodi',
            'periode_emonev.nama_periode',
        )->get();
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

        $fields->add('rata_rata');

        $fields->add('persentase', fn($row) => number_format((float) ($row->persentase ?? 0)) . '%');

        $fields->add('persentase_badge', function ($row) {
            $text = $row->persentase_badge ?? 'Tidak Diketahui';

            return match ($text) {
                'Luar Biasa' => "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800'>$text</span>",
                'Sangat Baik' => "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800'>$text</span>",
                'Baik' => "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800'>$text</span>",
                'Kurang' => "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800'>$text</span>",
                default => "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800'>$text</span>",
            };
        });


        $fields->add('jumlah_partisipan');

        $fields->add('total_skor');

        return $fields;
    }

    public function columns(): array
    {
        $columns = [];

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

                Column::make('Total NIlai', 'total_skor')
                    ->sortable()
                    ->searchable(),

                Column::make('Rata-rata', 'rata_rata')
                    ->withAvg('Avg Dosen ', header: true, footer: false)
                    ->sortable(),

                Column::make('Persentase', 'persentase')
                    ->sortable(),

                Column::make('Keterangan', 'persentase_badge')
                    ->visibleInExport(false)
                    ->sortable()
                    ->searchable(),

                Column::make('Partisipan', 'jumlah_partisipan')
                    ->sortable(),

            ],
            $columns
        );
    }

    public function filters(): array
    {
        return [
            Filter::select('nama_prodi', 'nama_prodi')
                ->dataSource(Prodi::all()->map(fn($prodi) => [
                    'value' => $prodi->nama_prodi,
                    'label' => $prodi->nama_prodi,
                ]))
                ->optionLabel('label')
                ->optionValue('value'),

            Filter::select('persentase_badge', 'persentase_badge')
                ->dataSource(collect([
                    ['value' => 'Luar Biasa', 'label' => 'Luar Biasa'],
                    ['value' => 'Sangat Baik', 'label' => 'Sangat Baik'],
                    ['value' => 'Baik', 'label' => 'Baik'],
                    ['value' => 'Kurang', 'label' => 'Kurang'],
                    ['value' => 'Sangat Kurang', 'label' => 'Sangat Kurang'],
                ]))
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }
}
