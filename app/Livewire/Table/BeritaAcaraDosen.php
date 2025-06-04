<?php

namespace App\Livewire\Table;

use App\Models\BeritaAcara;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Auth;

final class BeritaAcaraDosen extends PowerGridComponent
{
    public string $tableName = 'berita-acara-dosen-cmhc6z-table';
    public string $primaryKey = 'id_berita_acara';
    public string $sortField = 'id_berita_acara';

    public int $id_mata_kuliah;
    public int $id_kelas;

    protected $listeners = ['acaraCreated' => '$refresh'];


    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $nidn = Auth::user()->nim_nidn;

        return BeritaAcara::query()
            ->with(['mataKuliah', 'kelas', 'semester', 'dosen'])
            ->where('nidn', $nidn)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->latest(); // Urut berdasarkan created_at DESC
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_berita_acara')
            ->add('tanggal_formatted', fn(BeritaAcara $model) => Carbon::parse($model->tanggal)->format('d/m/Y'))
            ->add('materi')
            ->add('jumlah_mahasiswa')
            ->add('semester.nama_semester');
    }

    public function columns(): array
    {
        return [
            Column::make('Tanggal', 'tanggal_formatted', 'tanggal')
                ->sortable(),

            Column::make('Materi', 'materi')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah mahasiswa', 'jumlah_mahasiswa')
                ->sortable()
                ->searchable(),

            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('tanggal'),
        ];
    }

    public function actionsFromView($row)
    {
        return view('livewire.dosen.berita_acara.action2', ['row' => $row]);
    }
}
