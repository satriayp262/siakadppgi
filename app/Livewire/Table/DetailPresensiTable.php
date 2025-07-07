<?php

namespace App\Livewire\Table;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DetailPresensiTable extends PowerGridComponent
{
    public string $tableName = 'detail-presensi-table';

    // Gunakan primary key unik mahasiswa agar PowerGrid tidak cari kolom id
    public string $primaryKey = 'id_mahasiswa';

    // Parameter yang diterima dari luar (dikirim dari komponen induk)
    public string $token;
    public int $id_kelas;
    public int $id_mata_kuliah;

    /**
     * Konfigurasi tampilan PowerGrid
     */
    public function setUp(): array
    {
        return [
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    /**
     * Sumber data utama untuk tabel
     */
    public function datasource(): Builder
    {
        // Subquery presensi terbaru berdasarkan token
        $latestPresensi = DB::table('presensi')
            ->select('id_mahasiswa', 'id', 'keterangan', 'created_at', 'alasan')
            ->where('token', $this->token)
            ->orderByDesc('created_at');

        return Mahasiswa::query()
            ->join('krs', 'mahasiswa.NIM', '=', 'krs.NIM')
            ->leftJoinSub($latestPresensi, 'latest_presensi', function ($join) {
                $join->on('mahasiswa.id_mahasiswa', '=', 'latest_presensi.id_mahasiswa');
            })
            ->where('krs.id_kelas', $this->id_kelas)
            ->where('krs.id_mata_kuliah', $this->id_mata_kuliah)
            ->leftJoin('presensi', function ($join) {
                $join->on('mahasiswa.id_mahasiswa', '=', 'presensi.id_mahasiswa')
                    ->where('presensi.token', '=', $this->token);
            })
            ->select(
                'mahasiswa.id_mahasiswa',
                'mahasiswa.nama',
                'mahasiswa.NIM as nim',
                DB::raw('MAX(presensi.id) as id'), // ambil ID presensi jika ada
                DB::raw('MAX(presensi.keterangan) as keterangan'),
                DB::raw('MAX(presensi.created_at) as created_at'),
                DB::raw('MAX(presensi.alasan) as alasan')
            )
            ->groupBy('mahasiswa.id_mahasiswa', 'mahasiswa.nama', 'mahasiswa.NIM');
    }


    /**
     * Kolom yang tersedia di PowerGrid (data binding)
     */
    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('nama')
            ->add('nim')
            ->add('keterangan')
            ->add('created_at') // untuk menampilkan tanggal presensi
            ->add('alasan');
    }

    /**
     * Kolom yang ditampilkan di UI PowerGrid
     */
    public function columns(): array
    {
        return [
            Column::make('Nama Mahasiswa', 'nama')
                ->sortable()
                ->searchable(),

            Column::make('NIM', 'nim')
                ->sortable()
                ->searchable(),

            Column::make('Tanggal Presensi', 'created_at')
                ->sortable()
                ->searchable(),

            Column::make('Keterangan', 'keterangan')
                ->sortable(),

            Column::make('Alasan', 'alasan')
                ->sortable(),

            //  Column::action('Action'), // opsional, bisa diisi tombol aksi custom
        ];
    }

    // public function actionsFromView($row)
    // {

    //     return view('livewire.dosen.presensi.action2', ['row' => $row]);
    // }

    /**
     * Filter tambahan (tidak dipakai saat ini)
     */
    public function filters(): array
    {
        return [];
    }
}
