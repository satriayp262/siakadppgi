<?php

namespace App\Livewire\Table\Staff\Tagihan;

use Illuminate\Support\Carbon;
use App\Models\Mahasiswa;
use App\Models\Tagihan;
use App\Models\Cicilan_BPP;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DetailTagihanTable extends PowerGridComponent
{
    public string $tableName = 'detail-tagihan-table-i0pfub-table';
    public $NIM;

    public function datasource(): Collection
    {
        $tagihans = Tagihan::with('cicilan_bpp')
            ->where('NIM', $this->NIM)
            ->get();
        return $tagihans;
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

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('semester.nama_semester')
            ->add('jenis_tagihan')
            ->add('total_tagihan', function ($dish) {
                return 'Rp. ' . number_format($dish->total_tagihan, 2, ',', '.'); // IDR 170,90
            })
            ->add('total_bayar', function ($dish) {
                return 'Rp. ' . number_format($dish->total_bayar, 2, ',', '.'); // IDR 170,90
            })
            ->add('status_tagihan', function ($dish) {
                $status = $dish->status_tagihan;
                $badgeClass = match ($status) {
                    'Lunas' => 'bg-green-100 text-green-800',
                    'Belum Bayar' => 'bg-red-100 text-red-800',
                    'Belum Lunas' => 'bg-yellow-100 text-yellow-800',
                    default => 'bg-gray-100 text-gray-800',
                };

                return "<span class='px-2 py-1 text-xs font-semibold rounded $badgeClass'>$status</span>";
            });
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')->index(),

            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->searchable(),
            Column::make('Tagihan', 'jenis_tagihan')
                ->searchable()
                ->sortable(),
            Column::make('Total Tagihan', 'total_tagihan'),
            Column::make('Total Pembayaran', 'total_bayar'),
            Column::make('Status', 'status_tagihan'),

            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.staff.tagihan.action-for-detail', ['row' => $row]);
    }
}
