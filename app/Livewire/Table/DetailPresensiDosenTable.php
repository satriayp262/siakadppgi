<?php

namespace App\Livewire\Table;

use App\Models\BeritaAcara;
use App\Models\Token;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class DetailPresensiDosenTable extends PowerGridComponent
{
    public string $tableName = 'detail-presensi-dosen-table';
    public string $primaryKey = 'id_berita_acara';
    public string $sortField = 'id_berita_acara';

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
        $nidn = request()->query('nidn');

        return BeritaAcara::query()
            ->with(['tokenList.matkul', 'tokenList.kelas'])
            ->when($nidn, fn($query) => $query->where('nidn', $nidn));
    }

    public function relationSearch(): array
    {
        return [
            'tokenList.matkul' => ['nama_mata_kuliah'],
            'tokenList.kelas' => ['nama_kelas'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_berita_acara')
            ->add('tanggal_formatted', fn(BeritaAcara $model) => Carbon::parse($model->tanggal)->format('d/m/Y'))
            ->add('tokenList.matkul.nama_mata_kuliah')
            ->add('tokenList.kelas.nama_kelas')
            ->add('tokenList.pertemuan')
            ->add('tokenList.sesi')
            ->add('materi')
            ->add('jumlah_mahasiswa');
            // ->add('keterangan'); ← bisa dibiarkan komen
    }


    public function columns(): array
    {
        return [
            Column::make('Tanggal', 'tanggal_formatted', 'tanggal')->sortable(),

            Column::make('Kelas', 'tokenList.kelas.nama_kelas')
                ->sortable()
                ->searchable(),

            Column::make('Mata Kuliah', 'tokenList.matkul.nama_mata_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Pertemuan', 'tokenList.pertemuan')
                ->sortable()
                ->searchable(),

            Column::make('Sesi', 'tokenList.sesi')
                ->sortable()
                ->searchable(),

            Column::make('Materi', 'materi')
                ->sortable()
                ->searchable(),

            Column::make('Mahasiswa', 'jumlah_mahasiswa')
                ->sortable()
                ->searchable(),

            // Column::make('Keterangan', 'keterangan')
            //     ->sortable()
            //     ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('tanggal'),

            // Filter::select('Mata Kuliah', 'tokenList.matkul.nama_mata_kuliah') // label tampilannya, bukan kolom DB
            //     ->dataSource(
            //         \App\Models\Token::with('matkul')
            //             ->get()
            //             ->map(fn($token) => [
            //                 'id' => $token->token,
            //                 'name' => $token->matkul->nama_mata_kuliah ?? '(Tidak Ditemukan)',
            //             ])
            //     )
            //     ->optionLabel('name')
            //     ->optionValue('id'),

            // Filter::select('Kelas', 'tokenList.kelas.nama_kelas') // masih pakai token sebagai kolom di berita_acara
            //     ->dataSource(
            //         \App\Models\Token::with('kelas')
            //             ->get()
            //             ->map(fn($token) => [
            //                 'id' => $token->token,
            //                 'name' => $token->kelas->nama_kelas ?? '(Tidak Ditemukan)',
            //             ])
            //     )
            //     ->optionLabel('name')
            //     ->optionValue('id'),
        ];
    }
}
