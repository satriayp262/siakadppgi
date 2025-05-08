<?php

namespace App\Livewire\table;

use App\Models\Kelas;
use App\Models\paketKRS;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class PakerKRSTable extends PowerGridComponent
{
    public ?string $primaryKeyAlias = 'id_paket_krs';
    public string $primaryKey = 'paket_krs.id_paket_krs';
    public string $sortField = 'paket_krs.id_paket_krs';
    public string $tableName = 'paker-k-r-s-table-th1jhx-table';


    public function header(): array
    {
        $this->checkboxAttribute = 'id_paket_krs';
        return [
            Button::add('bulk-delete')
                ->slot('Hapus data terpilih (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700')
                ->dispatch('bulkDelete.' . $this->tableName, [
                ]),
        ];
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        // $this->js('alert(window.pgBulkActions.get(\'' . $this->tableName . '\'))');
        $this->dispatch('bulkDelete.alert.' . $this->tableName, [
            'ids' => $this->checkboxValues
        ]);
        $this->checkboxValues = [];
    }
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): \Illuminate\Support\Collection
    {
        return paketKRS::query()
            ->select([
                'paket_krs.id_kelas',
                'paket_krs.id_semester',
                DB::raw('MIN(paket_krs.id_paket_krs) as id_paket_krs')
            ])
            ->groupBy('paket_krs.id_kelas', 'paket_krs.id_semester')
            ->get();
    }
    

    public function relationSearch(): array
    {
        return [
            'semester' => [
                'id_semester',
                'nama_semester',
            ],
            'kelas' => [
                'id_kelas',
                'nama_kelas',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('semester.nama_semester')
            ->add('kelas.nama_kelas')
            ->add('tanggal_mulai_formatted', fn (paketKRS $model) => Carbon::parse($model->tanggal_mulai)->format('d/m/Y'))
            ->add('tanggal_selesai_formatted', fn (paketKRS $model) => Carbon::parse($model->tanggal_selesai)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Semester', 'semester.nama_semester')
                ->searchable(),

            Column::make('Kelas', 'kelas.nama_kelas')
                ->searchable(),

            Column::make('Tanggal mulai', 'tanggal_mulai_formatted', 'tanggal_mulai')
                ->sortable(),

            Column::make('Tanggal selesai', 'tanggal_selesai_formatted', 'tanggal_selesai')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('semester.nama_semester', 'id_semester')
            ->dataSource(Semester::all()->map(fn($semester) => [
                'value' => $semester->id_semester,
                'label' => $semester->nama_semester,
            ]))
            ->optionLabel('label')
            ->optionValue('value'),

        Filter::select('kelas.nama_kelas', 'id_kelas')
            ->dataSource(Kelas::all()->map(fn($kelas) => [
                'value' => $kelas->id_kelas,
                'label' => $kelas->nama_kelas,
            ]))
            ->optionLabel('label')
            ->optionValue('value'),
    ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actionsFromView($row)
    {
        return view('livewire.admin.paket-krs.action', ['row' => $row]);
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
