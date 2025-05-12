<?php

namespace App\Livewire\Table\Dosen\Emonev;

use App\Models\Pertanyaan;
use Illuminate\Support\Carbon;
use App\Models\Jawaban;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;


final class EmonevTable extends PowerGridComponent
{
    public string $tableName = 'emonev-table-txlquc-table';
    public $jawaban = [];
    use WithExport;

    public function datasource(): Collection
    {
        $jawaban = $this->jawaban;

        return $jawaban;
    }

    public function setUp(): array
    {
        //$this->showCheckBox();

        return [
            PowerGrid::exportable(fileName: 'emonev-file')
                ->type(Exportable::TYPE_XLS),

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

        foreach (Pertanyaan::all() as $p) {
            $columns[] = Column::make($p->pertanyaan ?? "$p->nama_pertanyaan", "pertanyaan_$p->id_pertanyaan")
                ->sortable()
                ->searchable();
        }

        return array_merge([
            Column::make('No', 'id')->visibleInExport(false)->index(),

        ], $columns, [Column::make('Saran', 'saran')]);
    }
}
