<?php

namespace App\Livewire\Table\Staff\Dashboard;

use App\Models\PembayaranTunai;
use Illuminate\Support\Carbon;
use App\Models\Cicilan_BPP;
use App\Models\Konfirmasi_Pembayaran;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class HistoryTable extends PowerGridComponent
{
    public string $tableName = 'history-table-3c3mrw-table';

    public function datasource(): Collection
    {
        $cicilan = Cicilan_BPP::with('tagihan.mahasiswa')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->tagihan->mahasiswa->nama ?? '-',
                'nim' => $item->tagihan->mahasiswa->NIM ?? '-',
                'tanggal' => $item->tanggal_bayar,
                'jam' => \Carbon\Carbon::parse($item->tanggal_bayar)->format('H:i A'),
                'nominal' => $item->jumlah_bayar,
                'metode' => $item->tagihan->jenis_tagihan . ' ( ' . $item->cicilan_ke . ' / 6 )',
                'pembayaran' => 'Bayar Sebagian' . ' ( ' . $item->metode_pembayaran . ' )',
            ]);

        $konfirmasi = Konfirmasi_Pembayaran::with('tagihan.mahasiswa')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->tagihan->mahasiswa->nama ?? '-',
                'nim' => $item->tagihan->mahasiswa->NIM ?? '-',
                'tanggal' => $item->tanggal_pembayaran,
                'jam' => \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('H:i A'),
                'nominal' => $item->jumlah_pembayaran,
                'metode' => $item->tagihan->jenis_tagihan,
                'pembayaran' => $item->tagihan->metode_pembayaran,
            ]);

        $transaksi = Transaksi::with('tagihan.mahasiswa')
            ->where('status', 'success')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->tagihan->mahasiswa->nama ?? '-',
                'nim' => $item->tagihan->mahasiswa->NIM ?? '-',
                'tanggal' => $item->tanggal_transaksi,
                'jam' => \Carbon\Carbon::parse($item->tanggal_transaksi)->format('H:i A'),
                'nominal' => $item->nominal,
                'metode' => $item->tagihan->jenis_tagihan,
                'pembayaran' => 'Bayar Penuh (' . ($item->tagihan->metode_pembayaran ?? '-') . ')',
            ]);

        $tunai = PembayaranTunai::with('tagihan.mahasiswa')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->tagihan->mahasiswa->nama ?? '-',
                'nim' => $item->tagihan->mahasiswa->NIM ?? '-',
                'tanggal' => $item->tanggal_pembayaran,
                'jam' => \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('H:i A'),
                'nominal' => $item->nominal,
                'metode' => $item->tagihan->jenis_tagihan,
                'pembayaran' => 'Bayar Penuh (' . $item->tagihan->metode_pembayaran . ')',
            ]);

        $dataPembayaran = collect()
            ->merge($cicilan)
            ->merge($konfirmasi)
            ->merge($transaksi)
            ->merge($tunai)
            ->sortByDesc('tanggal')
            ->values();

        return $dataPembayaran;

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
            ->add('nama')
            ->add('tanggal', function ($dish) {
                return \Carbon\Carbon::parse($dish->tanggal)->format('d-m-Y');
            })
            ->add('jam')
            ->add('nominal', function ($dish) {
                return 'Rp. ' . number_format($dish->nominal, 2, ',', '.'); // IDR 170,90
            })
            ->add('metode')
            ->add('pembayaran');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->index(),

            Column::make('Nama', 'nama')
                ->searchable()
                ->sortable(),

            Column::make('Guna Pembayaran', 'metode')
                ->searchable()
                ->sortable(),

            Column::make('Tanggal Transaksi', 'tanggal')
            ,

            Column::make('Jam Transaksi', 'jam')
            ,

            Column::make('Nominal', 'nominal')
                ->searchable()
                ->sortable(),

            Column::make('Metode Pembayaran', 'pembayaran')
                ->searchable()
                ->sortable(),
        ];
    }
}
