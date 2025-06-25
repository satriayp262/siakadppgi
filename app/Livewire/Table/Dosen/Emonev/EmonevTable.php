<?php

namespace App\Livewire\Table\Dosen\Emonev;

use App\Models\Pertanyaan;
use Illuminate\Support\Carbon;
use App\Models\Jawaban;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;


final class EmonevTable extends PowerGridComponent
{
    public string $tableName = 'emonev-table-txlquc-table';
    public $periode;
    public $matakuliah;

    use WithExport;

    public function datasource(): Collection
    {
        $periode = $this->periode;

        $matakuliah = $this->matakuliah;

        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
            ->join('periode_emonev', 'emonev.nama_periode', '=', 'periode_emonev.nama_periode')
            ->join('matkul', 'emonev.id_mata_kuliah', '=', 'matkul.id_mata_kuliah')
            ->join('dosen', 'matkul.nidn', '=', 'dosen.nidn')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'emonev.saran',
                'periode_emonev.nama_periode',
                'matkul.nama_mata_kuliah',
            );

        $query->where('dosen.nidn', auth()->user()->nim_nidn);
        $query->where('emonev.nama_periode', $periode);
        $query->where('emonev.id_mata_kuliah', $matakuliah);

        $pertanyaan = Pertanyaan::all();

        foreach ($pertanyaan as $p) {
            $query->addSelect(DB::raw("
            MAX(CASE WHEN jawaban.id_pertanyaan = {$p->id_pertanyaan} THEN jawaban.nilai END) AS pertanyaan_{$p->id_pertanyaan}
        "));
        }

        $this->monev = $query->groupBy(
            'dosen.nidn',
            'dosen.nama_dosen',
            'matkul.nama_mata_kuliah',
            'emonev.saran',
            'periode_emonev.nama_periode',
        )->get();

        return $this->monev;
    }

    public function setUp(): array
    {
        //$this->showCheckBox();

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

    public function fields(): PowerGridFields
    {
        $fields = PowerGrid::fields()
            ->add('id')
            ->add('periode_emonev.nama_periode')
            ->add('dosen.nama_dosen')
            ->add('prodi.nama_prodi')
            ->add('matkul.nama_mata_kuliah')
            ->add('saran');

        foreach (Pertanyaan::all() as $p) {
            $fields->add("pertanyaan_$p->id_pertanyaan");
        }
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

        return array_merge([
            Column::make('No', 'id')->visibleInExport(false)->index(),

        ], $columns, [Column::make('Saran', 'saran')]);
    }
}
