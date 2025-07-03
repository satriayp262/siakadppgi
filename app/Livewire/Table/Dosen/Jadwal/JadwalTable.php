<?php

namespace App\Livewire\Table\Dosen\Jadwal;

use App\Models\Dosen;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;


final class JadwalTable extends PowerGridComponent
{
    public string $primaryKey = 'id_jadwal';
    public string $sortField = 'id_jadwal';
    public string $tableName = 'jadwal-table-lw2rml-table';

    public function datasource(): Builder
    {
        $dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();
        return Jadwal::query()->where('nidn',$dosen->nidn)->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
        ->orderBy('sesi')
        ->with('prodi')
        ->with('mataKuliah')
        ->with('ruangan')
        ->with('kelas');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
        ->add('hari_display', function ($jadwal) {
                static $lastHari = null;

                $currentHari = $jadwal->hari;

                // Jika sama dengan baris sebelumnya, kosongkan
                if ($lastHari === $currentHari) {
                    return '';
                }

                // Update lastHari dan tampilkan
                $lastHari = $currentHari;
                return $currentHari;
            })
            ->add('sesi_display', function ($jadwal) {
                $jamMulai = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
                $jamSelesai = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');
                return 'Sesi ' . $jadwal->sesi . ' (' . $jamMulai . ' - ' . $jamSelesai . ')';
            })
            ->add('matakuliah.nama_mata_kuliah', function ($ammo) {
                if ($ammo->matakuliah->jenis_mata_kuliah == 'P') {
                    return $ammo->matakuliah->nama_mata_kuliah . ' (Grup ' . $ammo->grup . ')';
                } else {
                    return $ammo->matakuliah->nama_mata_kuliah;
                }
            })
            ->add('prodi.nama_prodi')
            ->add('kelas.nama_kelas')
            ->add('ruangan_display', function ($jadwal) {
                if ($jadwal->id_ruangan === 'Online') {
                    return 'Online';
                }

                return optional($jadwal->ruangan)->kode_ruangan ?? '-';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Hari', 'hari_display')
                ->sortable()
                ->searchable(),

            Column::make('Sesi', 'sesi_display')
                ->sortable()
                ->searchable(),

            Column::make('Mata Kuliah', 'matakuliah.nama_mata_kuliah')
                ->sortable()
                ->searchable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->sortable()
                ->searchable(),

            Column::make('Kelas', 'kelas.nama_kelas')
                ->sortable()
                ->searchable(),

            Column::make('Ruangan', 'ruangan_display')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.dosen.jadwal.action', ['row' => $row]);
    }

}
