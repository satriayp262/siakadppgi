<?php

namespace App\Livewire\table;

use App\Models\aktifitas;
use App\Models\Kelas;
use App\Models\KHS;
use App\Models\KonversiNilai;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class AktifitasTable extends PowerGridComponent
{
    public string $tableName = 'aktifitas-table-fonjfc-table';
    public string $primaryKey = 'NIM';
    public string $sortField = 'nama';
    public $id_kelas;
    public $nama_kelas;
    public $id_mata_kuliah;
    public $kode_mata_kuliah;

    public array $grades = [];
    public array $nilai = [];
    public bool $editMode = false;
    public $aktifitasList;

    protected $listeners = ['saveGrades'];

    // public function mount(): void
    // {
    //     parent::mount([]);
    //     $this->grades = [];
    //     $this->loadInitialGrades();
    // }

    protected function loadInitialGrades(): void
    {
        $this->aktifitasList = Aktifitas::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->orderByRaw("
                CASE 
                    WHEN nama_aktifitas IN ('UTS', 'UAS', 'Partisipasi') THEN 
                        CASE 
                            WHEN nama_aktifitas = 'UTS' THEN 2
                            WHEN nama_aktifitas = 'UAS' THEN 3
                            WHEN nama_aktifitas = 'Partisipasi' THEN 4
                            ELSE 1
                        END
                    ELSE 1
                END
            ")
            ->get();
        $this->nama_kelas = Kelas::where('id_kelas', $this->id_kelas)->first()->nama_kelas;
        $this->kode_mata_kuliah = $this->aktifitasList->first()->matkul->kode_mata_kuliah;

        $students = Mahasiswa::whereHas('kelas', fn($q) => $q->where('id_kelas', $this->id_kelas))
            ->with([
                'nilai' => function ($query) {
                    $query->whereHas('aktifitas', function ($q) {
                        $q->where('id_kelas', $this->id_kelas)
                            ->where('id_mata_kuliah', $this->id_mata_kuliah);
                    });
                }
            ])
            ->get();

        // Initialize grades array structure
        $this->grades = [];

        foreach ($students as $student) {
            $this->grades[$student->NIM] = [];
            foreach ($this->aktifitasList as $aktifitas) {
                $grade = $student->nilai->firstWhere('id_aktifitas', $aktifitas->id_aktifitas);
                $this->grades[$student->NIM][$aktifitas->id_aktifitas] = $grade ? (string) $grade->nilai : "0";
            }
        }
        // dd($this->grades);
    }

    public function setUp(): array
    {
        if (empty($this->grades)) {
            $this->loadInitialGrades();
        }
        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive(),
        ];
    }

    public function header(): array
    {

        return [

            Button::add('save-grades')
                ->slot('Simpan Nilai')
                ->class('bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700')
                ->dispatch('saveGrades', []),
            Button::add('refresh-table')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg> Refresh')
                ->class('bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 ml-2')
                ->dispatch('refreshTable', []),
        ];
    }

    #[On('toggleEditMode')]
    public function toggleEditMode(): void
    {
        $this->editMode = !$this->editMode;
    }
    protected function rules(): array
    {
        $rules = [];
        foreach ($this->grades as $nim => $aktifitasGrades) {
            foreach ($aktifitasGrades as $idAktifitas => $grade) {
                $rules["grades.$nim.$idAktifitas"] = ['nullable', 'numeric', 'min:0', 'max:100'];
            }
        }
        return $rules;
    }
    #[On('refreshTable')]
    public function refreshTable()
    {
        return redirect()->route('dosen.aktifitas.kelas.show', ['kode_mata_kuliah' => $this->kode_mata_kuliah, 'nama_kelas' => str_replace('/', '-', $this->nama_kelas)]);
    }
    #[On('saveGrades')]
    public function saveGrades(): void
    {

        $this->validate();

        // Save grades
        foreach ($this->grades as $nim => $aktifitasGrades) {
            foreach ($aktifitasGrades as $idAktifitas => $grade) {
                $gradeValue = $grade === '' ? 0 : (float) $grade;

                Nilai::updateOrCreate(
                    [
                        'NIM' => $nim,
                        'id_aktifitas' => $idAktifitas,
                        'id_kelas' => $this->id_kelas
                    ],
                    ['nilai' => $gradeValue]
                );
            }
        }

        $this->calculateKHS();
        $this->editMode = false;
        $this->dispatch('nilaiUpdated');
    }

    protected function normalizeGrade($grade)
    {
        if ($grade === '' || $grade === null) {
            return 0;
        }
        return min(100, max(0, (float) $grade));
    }

    protected function calculateKHS()
    {
        $krsData = KRS::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->get();

        foreach ($krsData as $krs) {
            if (KonversiNilai::where('id_krs', $krs->id_krs)->exists()) {
                $bobot = KonversiNilai::where('id_krs', $krs->id_krs)->first()->nilai;
            } else {
                $bobot = KHS::calculateBobot(
                    $krs->id_semester,
                    $krs->NIM,
                    $krs->id_mata_kuliah,
                    $krs->id_kelas
                );
            }

            KHS::updateOrCreate([
                'id_krs' => $krs->id_krs
            ], [
                'bobot' => $bobot
            ]);
        }

    }

    public function datasource(): Builder
    {
        return Mahasiswa::query()
            ->whereHas('kelas', function ($query) {
                $query->where('id_kelas', $this->id_kelas);
            })
            ->with([
                'nilai' => function ($query) {
                    $query->whereHas('aktifitas', function ($q) {
                        $q->where('id_kelas', $this->id_kelas)
                            ->where('id_mata_kuliah', $this->id_mata_kuliah);
                    });
                }
            ])
            ->orderBy('nama');
    }

    public function fields(): PowerGridFields
    {
        $fields = PowerGrid::fields()
            ->add('NIM')
            ->add('nama');
        foreach ($this->aktifitasList as $aktifitas) {
            $fields->add($aktifitas->nama_aktifitas, function ($mahasiswa) use ($aktifitas) {
                if (!$this->editMode) {
                    return view('livewire.dosen.aktifitas.edit', [
                        'value' => $this->grades[$mahasiswa->NIM][$aktifitas->id_aktifitas] ?? '',
                        'field' => "grades.{$mahasiswa->NIM}.{$aktifitas->id_aktifitas}"
                    ]);
                }

                $grade = $mahasiswa->nilai->firstWhere('id_aktifitas', $aktifitas->id_aktifitas);
                return $grade ? $grade->nilai : 0;
            });
        }
        return $fields;
    }

public function columns(): array
{
    $columns = [
        Column::make('NIM', 'NIM')
            ->sortable()
            ->searchable()
            ->headerAttribute('class', 'text-left')  
            ->bodyAttribute('class', 'text-left'),  
            
        Column::make('Name', 'nama')
            ->sortable()
            ->searchable()
            ->headerAttribute('class', 'text-left')
            ->bodyAttribute('class', 'text-left'),
    ];

    foreach ($this->aktifitasList as $aktifitas) {
        $columns[] = Column::make($aktifitas->nama_aktifitas, $aktifitas->nama_aktifitas)
            ->headerAttribute('class', 'text-center')
            ->bodyAttribute('class', 'text-center');
    }

    return $columns;
}
}
