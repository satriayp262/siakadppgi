<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Models\Transaksi;
use Livewire\Attributes\On;
use Auth;
use Livewire\WithPagination;
use Midtrans\Snap;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Str;

class Index extends Component
{
    public $id_tagihan;
    public $snapToken;
    public $tagihan;

    use WithPagination;

    public function bayar($id_tagihan, $metode_pembayaran)
    {
        $this->id_tagihan = $id_tagihan;

        $tagihan = Tagihan::find($id_tagihan);

        if (!$tagihan) {
            session()->flash('message', 'Tagihan tidak ditemukan.');
            session()->flash('message_type', 'error');
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
            'id_tagihan' => $this->id_tagihan,
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


    public function render()
    {
        $user = auth()->user(); // Get the currently logged-in user

        $tagihans = Tagihan::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($user) {
            $query->where('NIM', $user->nim_nidn); // Match the user with mahasiswa
        })->paginate(5);

        // dd($tagihans);

        return view('livewire.mahasiswa.keuangan.index', [
            'tagihans' => $tagihans,
        ]);
    }
}
