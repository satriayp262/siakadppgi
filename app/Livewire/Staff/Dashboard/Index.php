<?php

namespace App\Livewire\Staff\Dashboard;

use App\Models\Konfirmasi_Pembayaran;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Cicilan_BPP;
use App\Models\Transaksi;
use App\Models\PembayaranTunai;



class Index extends Component
{
    public $total_bayar;

    public $NIM;
    public function render()
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
                'pembayaran' => 'Cicilan' . ' ( ' . $item->metode_pembayaran . ' )',
            ]);

        $konfirmasi = Konfirmasi_Pembayaran::with('tagihan.mahasiswa')
            ->where('status', 'Diterima')
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

        $hari_ini = Carbon::now()->toDateString();

        $totalUangMasukHariIni = $dataPembayaran
            ->filter(fn($item) => Carbon::parse($item['tanggal'])->toDateString() === $hari_ini)
            ->sum('nominal');


        return view('livewire.staff.dashboard.index', [
            'dataPembayaran' => $dataPembayaran,
            'totalUangMasukHariIni' => $totalUangMasukHariIni,
            'total_bayar' => $this->total_bayar,
        ]);
    }
}
