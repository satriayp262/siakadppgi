<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Konfirmasi_Pembayaran;
use App\Models\Tagihan;
use App\Models\Cicilan_BPP;
use App\Models\Transaksi;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class Histori extends Component
{
    public function render()
    {
        $user = auth()->user();

        $cicilan = Cicilan_BPP::with('tagihan.mahasiswa')
            ->whereHas('tagihan', fn($query) => $query->where('NIM', $user->nim_nidn))
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
            ->whereHas('tagihan', function ($query) use ($user) {
                $query->where('NIM', $user->nim_nidn);
            })
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
            ->whereHas('tagihan', function ($query) use ($user) {
                $query->where('NIM', $user->nim_nidn);
            })
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


        $tag = Tagihan::with('mahasiswa')
            ->where('NIM', $user->nim_nidn)
            ->where('metode_pembayaran', 'Tunai')
            ->get()
            ->map(fn($item) => [
                'nama' => $item->mahasiswa->nama ?? '-',
                'nim' => $item->mahasiswa->NIM ?? '-',
                'tanggal' => $item->updated_at->timezone('Asia/Jakarta'),
                'jam' => \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Jakarta')->format('H:i A'),
                'nominal' => $item->total_bayar,
                'metode' => $item->jenis_tagihan,
                'pembayaran' => 'Bayar Penuh (' . $item->metode_pembayaran . ')',
            ]);

        $dataPembayaran = collect()
            ->merge($cicilan)
            ->merge($konfirmasi)
            ->merge($transaksi)
            ->merge($tag)
            ->sortByDesc('tanggal')
            ->values(); // reset index




        // Gabungkan semua data
        $pembayaran = $cicilan->merge($konfirmasi)->merge($transaksi)->merge($tag)->sortByDesc('tanggal')->values();
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



        return view('livewire.mahasiswa.keuangan.histori', [
            'paginatedPembayaran' => $paginatedPembayaran,
        ]);
    }
}
