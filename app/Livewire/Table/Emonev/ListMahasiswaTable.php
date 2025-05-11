<?php

namespace App\Livewire\Table\Emonev;

use App\Models\MahasiswaEmonev;
use App\Models\PeriodeEMonev;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\KRS;
use App\Models\Semester;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Facades\Filter;


final class ListMahasiswaTable extends PowerGridComponent
{
    public string $tableName = 'list-mahasiswa-table-ynfb5z-table';
    public string $selectedSemester;
    public string $sesi;
    public string $a;

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

    public function datasource(): Collection
    {
        $periode = PeriodeEMonev::with('semester')
            ->where('id_periode', $this->selectedSemester)
            ->first();

        $sesi = substr($periode->nama_periode, 6, 1);

        $mahasiswaList = Mahasiswa::whereIn('NIM', function ($query) use ($periode) {
            $query->select('NIM')
                ->from('krs')
                ->where('id_semester', $periode->id_semester);
        })->get();

        $mahasiswaBelumIsi = [];

        foreach ($mahasiswaList as $mhs) {
            $matkulKRS = KRS::where('NIM', $mhs->NIM)
                ->where('id_semester', $periode->id_semester)
                ->pluck('id_mata_kuliah');

            $matkulEmonev = MahasiswaEmonev::where('NIM', $mhs->NIM)
                ->where('id_semester', $periode->id_semester)
                ->where('sesi', $sesi)
                ->pluck('id_mata_kuliah');

            $sudahIsiSemua = $matkulKRS->diff($matkulEmonev)->isEmpty();

            if (!$sudahIsiSemua) {
                $mahasiswaBelumIsi[] = $mhs;
            }
        }

        return collect($mahasiswaBelumIsi);
    }



    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama')
            ->add('NIM')
            ->add('prodi.nama_prodi');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->index(),

            Column::make('Nama', 'nama')
                ->searchable()
                ->sortable(),

            Column::make('NIM', 'NIM')
                ->sortable(),

            Column::make('Prodi', 'prodi.nama_prodi')
                ->searchable()
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [

            Filter::select('prodi.nama_prodi', 'kode_prodi')
                ->dataSource(Prodi::all()->map(fn($prodi) => [
                    'value' => $prodi->kode_prodi,
                    'label' => $prodi->nama_prodi,
                ]))
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }
}
