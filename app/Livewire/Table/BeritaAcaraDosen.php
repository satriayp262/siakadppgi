<?php

namespace App\Livewire\Table;

use App\Models\BeritaAcara;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Illuminate\Support\Facades\Auth;

final class BeritaAcaraDosen extends PowerGridComponent
{
    public string $tableName = 'berita-acara-dosen-table';
    public string $primaryKey = 'id_berita_acara';
    public string $sortField = 'id_berita_acara';
    public int $id_mata_kuliah;
    public int $id_kelas;

    protected $listeners = ['acaraCreated' => '$refresh'];

    public function setUp(): array
    {
        return [
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function datasource(): Builder
    {
        return BeritaAcara::with('token')
            ->whereHas('token', function ($query) {
                $query->where('id_mata_kuliah', $this->id_mata_kuliah)
                      ->where('id_kelas', $this->id_kelas);
            })
            ->where('nidn', Auth::user()->nim_nidn)
            ->latest();
    }

    // ✅ Ini WAJIB ada jika pakai relasi langsung di Column::make()
    public function relationSearch(): array
    {
        return [
            'token' => ['pertemuan', 'sesi'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_berita_acara')
            ->add('tanggal_formatted', fn(BeritaAcara $model) => Carbon::parse($model->tanggal)->format('d/m/Y'))
            ->add('materi')
            ->add('jumlah_mahasiswa')
            ->add('keterangan')
            ->add('token.pertemuan')
            ->add('token.sesi');
    }

    public function columns(): array
    {
        return [
            Column::make('Pertemuan', 'token.pertemuan')
                ->searchable(),

            Column::make('Sesi', 'token.sesi')
                ->sortable()
                ->searchable(),

            Column::make('Tanggal', 'tanggal_formatted', 'tanggal')
                ->sortable(),

            Column::make('Materi Yang Diajarkan', 'materi')
                ->sortable()
                ->searchable(),

            Column::make('Mahasiswa', 'jumlah_mahasiswa')
                ->sortable()
                ->searchable(),

            Column::make('Keterangan', 'keterangan')
                ->sortable()
                ->searchable(),

            Column::action('Action'),
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
