<?php

namespace App\Livewire\Table\Mahasiswa\Jadwal;

use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Models\KRS;
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
        $mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();
        $semester = semester::where('is_active', 1)->first();
        $krs = KRS::where('NIM', $mahasiswa->NIM)
            ->where('id_semester', $semester->id_semester)
            ->first();
        return Jadwal::whereHas('kelas.krs', function ($query) use ($mahasiswa, $krs) {
            $query->where('NIM', $mahasiswa->NIM)
                ->where(function ($q) use ($krs) {
                    $q->whereNull('grup') // Tampilkan semua jadwal tanpa grup
                        ->orWhere('grup', $krs->grup_praktikum); // Tampilkan yang cocok dengan grup
                });
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('sesi')
            ->with('prodi')
            ->with('mataKuliah')
            ->with('ruangan')
            ->with('kelas')
            ->with('dosen');
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
            ->add('kelas.nama_kelas')
            ->add('matakuliah_display', function ($jadwal) {
                if ($jadwal->grup != null) {
                    return $jadwal->mataKuliah->nama_mata_kuliah . ' (' . 'Grup ' . $jadwal->grup . ')';
                }

                return optional($jadwal->mataKuliah)->nama_mata_kuliah ?? '-';
            })
            ->add('dosen.nama_dosen')
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

                Column::make('Kelas', 'kelas.nama_kelas')
                    ->sortable()
                    ->searchable(),

            Column::make('Mata Kuliah', 'matakuliah_display')
                ->sortable()
                ->searchable(),

            Column::make('Dosen', 'dosen.nama_dosen')
                ->sortable()
                ->searchable(),

            Column::make('Ruangan', 'ruangan_display')
                ->sortable()
                ->searchable(),
        ];
    }
}
