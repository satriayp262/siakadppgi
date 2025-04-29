<?php

namespace App\Livewire\Staff\Dashboard;

use App\Models\Konfirmasi_Pembayaran;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Cicilan_BPP;
use App\Models\Transaksi;
use App\Models\Konfirmasi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


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
                'jam' => \Carbon\Carbon::parse($item->tanggal_bayar)->format('H:i:A'),
                'nominal' => $item->jumlah_bayar,
                'metode' => $item->tagihan->jenis_tagihan . ' ( ' . $item->cicilan_ke . ' / 6 )',
            ]);

        $konfirmasi = Konfirmasi_Pembayaran::with('tagihan.mahasiswa')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->tagihan->mahasiswa->nama ?? '-',
                'nim' => $item->tagihan->mahasiswa->NIM ?? '-',
                'tanggal' => $item->tanggal_pembayaran,
                'jam' => \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('H:i;A'),
                'nominal' => $item->jumlah_pembayaran,
                'metode' => $item->tagihan->jenis_tagihan,
            ]);

        $transaksi = Transaksi::with('tagihan.mahasiswa')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->tagihan->mahasiswa->nama ?? '-',
                'nim' => $item->tagihan->mahasiswa->NIM ?? '-',
                'tanggal' => $item->tanggal_transaksi,
                'jam' => \Carbon\Carbon::parse($item->tanggal_transaksi)->format('H:i;A'),
                'nominal' => $item->nominal,
                'metode' => $item->tagihan->jenis_tagihan,
            ]);

        $tag = Tagihan::query()
            ->where('metode_pembayaran', '=', 'Tunai')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->mahasiswa->nama ?? '-',
                'nim' => $item->mahasiswa->NIM ?? '-',
                'tanggal' => $item->updated_at->timezone('Asia/Jakarta'),
                'jam' => \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Jakarta')->format('H:i A'),
                'nominal' => $item->total_bayar,
                'metode' => $item->jenis_tagihan,
            ]);

        // Gabungkan semua data
        $pembayaran = $cicilan->merge($konfirmasi)->merge($transaksi)->merge($tag)->sortByDesc('tanggal')->values();

        $hari_ini = Carbon::now()->toDateString();

        $totalUangMasukHariIni = $pembayaran
            ->filter(fn($item) => Carbon::parse($item['tanggal'])->toDateString() === $hari_ini)
            ->sum('nominal');

        // Lalu kamu bisa assign ke Livewire property atau view:
        $this->total_bayar = $totalUangMasukHariIni;

        // Ambil halaman sekarang dari query string (?page=...)
        $currentPage = request()->get('page', 1);
        $perPage = 10;

        // Ambil data yang sesuai halaman
        $currentPageResults = $pembayaran->slice(($currentPage - 1) * $perPage, $perPage)->values();

        // Buat paginator manual
        $paginatedPembayaran = new LengthAwarePaginator(
            $currentPageResults,
            $pembayaran->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );


        return view('livewire.staff.dashboard.index', [
            'tagihans' => $pembayaran,
            'paginatedPembayaran' => $paginatedPembayaran,
            'total_bayar' => $this->total_bayar,
        ]);
    }
}
