<?php

namespace App\Livewire\Table\Mahasiswa\Keuangan;

use App\Models\Mahasiswa;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class TagihanTable extends PowerGridComponent
{
    public string $tableName = 'tagihan-table-gixu5a-table';
    public $id_tagihan;
    public $metode_pembayaran;

    public function datasource(): Collection
    {
        $user = auth()->user();
        $query = Tagihan::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($user) {
            $query->where('NIM', $user->nim_nidn);
        })->get();

        return $query;
    }

    public function setUp(): array
    {
        //$this->showCheckBox();

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
            })
            ->add('semester.nama_semester');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->index(),

            Column::make('Semester', 'semester.nama_semester')
                ->sortable()
                ->searchable(),

            Column::make('Tagihan', 'jenis_tagihan')
                ->searchable()
                ->sortable(),

            Column::make('Total Tagihan', 'total_tagihan'),
            Column::make('Total Pembayaran', 'total_bayar')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status_tagihan'),


            Column::action('Action')
        ];
    }
    public function actionsFromView($row)
    {
        return view('livewire.mahasiswa.keuangan.action', ['row' => $row]);
    }

    public function bayar($id_tagihan, $metode_pembayaran)
    {
        $tagihan = Tagihan::find($id_tagihan);


        if (!$tagihan) {
            $this->dispatch('warning', [
                'message' => 'Tagihan tidak ditemukan.',
            ]);
            return;
        }

        // Tentukan metode pembayaran dan hitung nominal
        $nominal = $tagihan->total_tagihan;
        $tagihan->metode_pembayaran = $metode_pembayaran;
        $tagihan->save();

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $order_id = 'ORDER - ' . rand();

        // Pastikan order_id unik
        while (Transaksi::where('order_id', $order_id)->exists()) {
            $order_id = 'ORDER - ' . rand();
        }

        $transaksi = Transaksi::create([
            'id_transaksi' => (string) Str::uuid(),
            'nominal' => $nominal + 5000, // Tambahkan biaya admin
            'NIM' => $tagihan->NIM,
            'id_tagihan' => $id_tagihan,
            'status' => 'pending',
            'snap_token' => null,
            'order_id' => $order_id,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $nominal + 5000,
            ],
            'customer_details' => [
                'first_name' => $tagihan->mahasiswa->nama,
                'email' => $tagihan->mahasiswa->email,
                'phone' => $tagihan->mahasiswa->no_hp,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $transaksi->snap_token = $snapToken;
        $transaksi->save();

        // Redirect ke halaman transaksi
        return redirect()->route('mahasiswa.transaksi', [
            'order_id' => $order_id,
        ]);
    }
}
