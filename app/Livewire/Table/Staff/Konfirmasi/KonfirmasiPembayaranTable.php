<?php

namespace App\Livewire\Table\Staff\Konfirmasi;

use App\Models\Cicilan_BPP;
use Illuminate\Support\Carbon;
use App\Models\Konfirmasi_Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class KonfirmasiPembayaranTable extends PowerGridComponent
{
    public string $tableName = 'konfirmasi-pembayaran-table-chv3ux-table';

    public function datasource(): Collection
    {
        $query = Konfirmasi_Pembayaran::with('tagihan')->get();
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
            ->add('tagihan.semester.nama_semester')
            ->add('tagihan.mahasiswa.nama')
            ->add('tagihan.mahasiswa.NIM')
            ->add('tagihan.jenis_tagihan')
            ->add('status')
            ->add('bukti', function ($pengumuman) {
                return '<img src="' . asset("storage/image/bukti_pembayaran/{$pengumuman->bukti_pembayaran}") . '">';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')->index(),
            Column::make('Semester', 'tagihan.semester.nama_semester')
                ->sortable()
                ->searchable(),

            Column::make('Nama', 'tagihan.mahasiswa.nama')
                ->sortable()
                ->searchable(),

            Column::make('NIM', 'tagihan.mahasiswa.NIM')
                ->sortable()
                ->searchable(),

            Column::make('Pembayaran', 'tagihan.jenis_tagihan')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status'),
            Column::make('Bukti', 'bukti'),
            Column::action('Action')
        ];
    }

    public function actionsFromView($row)
    {

        return view('livewire.staff.konfirmasi.action', ['row' => $row]);
    }

    public function updateStatus($id, $status)
    {
        $konfirmasi = Konfirmasi_Pembayaran::find($id);
        $konfirmasi->status = $status;
        $konfirmasi->save();

        if ($status == 'Diterima') {
            if ($konfirmasi->bulan != null) {
                $adacicilan = Cicilan_BPP::where('id_tagihan', $konfirmasi->id_tagihan)
                    ->where('bulan', $konfirmasi->bulan)
                    ->first();
                if ($adacicilan) {
                    $this->dispatch('error', [
                        'message' => 'Bulan ini sudah ada cicilan yang dibayar',
                    ]);
                    return;
                }
                $hitung = Cicilan_BPP::where('id_tagihan', $konfirmasi->id_tagihan)->count();
                $cicilan = Cicilan_BPP::create([
                    'id_tagihan' => $konfirmasi->id_tagihan,
                    'id_konfirmasi' => $konfirmasi->id_konfirmasi,
                    'bulan' => $konfirmasi->bulan,
                    'jumlah_bayar' => $konfirmasi->jumlah_pembayaran,
                    'tanggal_bayar' => $konfirmasi->tanggal_pembayaran,
                    'metode_pembayaran' => 'Transfer',
                    'cicilan_ke' => $hitung + 1,
                ]);

                $cicilan->save();
            }

            $tagihan = Tagihan::where('id_tagihan', $konfirmasi->id_tagihan)->first();
            if ($tagihan) {
                $tagihan->total_bayar += $konfirmasi->jumlah_pembayaran;
                if ($tagihan->total_bayar == $tagihan->total_tagihan) {
                    $tagihan->status_tagihan = 'Lunas';
                    $tagihan->no_kwitansi = rand();
                    // Pastikan kwitansi unik
                    while (Tagihan::where('no_kwitansi', $tagihan->no_kwitansi)->exists()) {
                        $tagihan->no_kwitansi = rand();
                    }
                } else {
                    $tagihan->status_tagihan = 'Belum Lunas';
                }
                $tagihan->metode_pembayaran = 'Cicilan';
                $tagihan->save();
            }
        }
        $this->dispatch('updated', ['message' => 'Status Pembayaran Berhasil diubah']);
    }
}
