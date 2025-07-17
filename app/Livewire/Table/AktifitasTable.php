<?php

namespace App\Livewire\table;

use App\Models\aktifitas;
use App\Models\KHS;
use App\Models\KonversiNilai;
use App\Models\KRS;
use App\Models\Mahasiswa;
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
    public $id_mata_kuliah;

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
                $this->grades[$student->NIM][$aktifitas->id_aktifitas] = $grade ? (string) $grade->nilai : '';
            }
        }
    }

    public function setUp(): array
    {
        $this->loadInitialGrades();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {

        return [
            // Button::add('toggle-edit')
            //     ->slot($this->editMode ? 'Cancel Editing' : 'Edit Grades')
            //     ->class('bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 mr-2')
            //     ->dispatch('toggleEditMode', []),

            Button::add('save-grades')
                ->slot('Simpan Nilai')
                ->class('bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700')
                ->dispatch('saveGrades', []),
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
    #[On('saveGrades')]
    public function saveGrades(): void
    {
        // dd($this->grades);
        // if (!$this->editMode)
        //     return;

        // Validate all grades
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
                ->searchable(),

            Column::make('Name', 'nama')
                ->sortable()
                ->searchable(),
        ];
        

        foreach ($this->aktifitasList as $aktifitas) {
            $columns[] = Column::make($aktifitas->nama_aktifitas, $aktifitas->nama_aktifitas)
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center');
        }

        return $columns;
    }
}
